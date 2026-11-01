<?php
defined('ABSPATH') || exit;

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
    register_nav_menus(['primary' => __('Huvudmeny', 'arvinge')]);
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('arvinge-style', get_stylesheet_uri(), [], wp_get_theme()->get('Version'));
    wp_enqueue_script('arvinge-home', get_template_directory_uri() . '/assets/home.js', [], wp_get_theme()->get('Version'), true);
    if (is_page('kontakt')) {
        wp_enqueue_style('arvinge-contact', get_template_directory_uri() . '/assets/contact.css', ['arvinge-style'], wp_get_theme()->get('Version'));
        wp_enqueue_script('arvinge-contact', get_template_directory_uri() . '/assets/contact.js', [], wp_get_theme()->get('Version'), true);
        wp_localize_script('arvinge-contact', 'arvingeContact', [
            'endpoint' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('arvinge_contact'),
        ]);
    }
    if (is_page('forum-event')) {
        wp_enqueue_style('arvinge-forum', get_template_directory_uri() . '/assets/forum.css', ['arvinge-style'], wp_get_theme()->get('Version'));
        wp_enqueue_script('arvinge-forum', get_template_directory_uri() . '/assets/forum.js', [], wp_get_theme()->get('Version'), true);
    }
    if (is_page('om-oss')) {
        wp_enqueue_style('arvinge-about', get_template_directory_uri() . '/assets/about.css', ['arvinge-style'], wp_get_theme()->get('Version'));
        wp_enqueue_script('arvinge-about', get_template_directory_uri() . '/assets/about.js', [], wp_get_theme()->get('Version'), true);
    }
    if (is_page('blogg') || (is_home() && !is_front_page())) {
        wp_enqueue_style('arvinge-blog', get_template_directory_uri() . '/assets/blog.css', ['arvinge-style'], wp_get_theme()->get('Version'));
    }
    if (is_page('press')) {
        wp_enqueue_style('arvinge-press', get_template_directory_uri() . '/assets/press.css', ['arvinge-style'], wp_get_theme()->get('Version'));
    }
});

function arvinge_asset($name) {
    return esc_url(get_template_directory_uri() . '/assets/' . $name);
}

function arvinge_page($slug) {
    return esc_url(home_url('/' . trim($slug, '/') . '/'));
}

function arvinge_author_name($user_id) {
    $first = trim((string) get_the_author_meta('first_name', $user_id));
    $last = trim((string) get_the_author_meta('last_name', $user_id));
    if ($first !== '' && $last !== '') return $first . ' ' . $last;
    $email = strtolower((string) get_the_author_meta('user_email', $user_id));
    $known = ['par@arvinge.se' => 'Pär Johansson', 'max@arvinge.se' => 'Max Loman'];
    if (isset($known[$email])) return $known[$email];
    return (string) get_the_author_meta('display_name', $user_id);
}

function arvinge_author_markup($name) {
    if ($name === 'Max Loman') {
        return '<img class="person-name-image" src="' . arvinge_asset('person-02.png') . '" alt="" width="387" height="56">';
    }
    return esc_html($name);
}

add_action('init', function () {
    register_post_type('arvinge_forfragan', [
        'labels' => [
            'name' => 'Förfrågningar',
            'singular_name' => 'Förfrågan',
            'menu_name' => 'Förfrågningar',
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => false,
        'menu_icon' => 'dashicons-email-alt',
        'supports' => ['title', 'editor'],
        'capabilities' => [
            'edit_post' => 'manage_options',
            'read_post' => 'manage_options',
            'delete_post' => 'manage_options',
            'edit_posts' => 'manage_options',
            'edit_others_posts' => 'manage_options',
            'publish_posts' => 'manage_options',
            'read_private_posts' => 'manage_options',
            'create_posts' => 'do_not_allow',
        ],
        'map_meta_cap' => false,
    ]);
});

add_filter('manage_arvinge_forfragan_posts_columns', function ($columns) {
    $columns['arvinge_mail_status'] = 'E-post';
    return $columns;
});
add_action('manage_arvinge_forfragan_posts_custom_column', function ($column, $post_id) {
    if ($column !== 'arvinge_mail_status') return;
    echo get_post_meta($post_id, '_arvinge_mail_status', true) === 'sent' ? 'Skickad' : 'Misslyckades';
}, 10, 2);

add_action('template_redirect', function () {
    if (is_preview()) return;
    if (is_page(['event', 'delta-som-partner', 'motesplats', 'varfor-samlas-vi'])) {
        wp_safe_redirect(arvinge_page('forum-event'), 302);
        exit;
    }
    if (is_page('testa-hemsida')) {
        wp_safe_redirect(arvinge_page('kontakt'), 302);
        exit;
    }
    if (is_page('nyhetsbrev')) {
        wp_safe_redirect(arvinge_page('blogg'), 302);
        exit;
    }
    if (is_page('logga-in')) {
        wp_safe_redirect(wp_login_url(), 302);
        exit;
    }
});

function arvinge_contact_submit() {
    if (!check_ajax_referer('arvinge_contact', 'nonce', false)) {
        wp_send_json_error(['message' => 'Sessionen har gått ut. Ladda om sidan och försök igen.'], 403);
    }
    // Invisible field catches simple automated submissions without affecting visitors.
    if (!empty($_POST['website'])) {
        wp_send_json_success();
    }
    $type = isset($_POST['type']) ? sanitize_key(wp_unslash($_POST['type'])) : '';
    $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';
    if (!in_array($type, ['projekt', 'event', 'ovrigt'], true) || !$name || !is_email($email) || !$message || empty($_POST['consent'])) {
        wp_send_json_error(['message' => 'Kontrollera de obligatoriska fälten och försök igen.'], 400);
    }
    $fields = ['company', 'phone', 'when', 'people', 'period', 'topic'];
    $labels = ['company' => 'Företag', 'phone' => 'Telefon', 'when' => 'Start', 'people' => 'Deltagare', 'period' => 'Period', 'topic' => 'Ämne'];
    $lines = ['Ärende: ' . $type, 'Namn: ' . $name, 'E-post: ' . $email];
    foreach ($fields as $field) {
        if (!empty($_POST[$field]) && is_scalar($_POST[$field])) {
            $lines[] = $labels[$field] . ': ' . sanitize_text_field(wp_unslash($_POST[$field]));
        }
    }
    foreach (['needs' => 'Behov', 'kinds' => 'Eventtyp', 'formats' => 'Format'] as $field => $label) {
        if (!empty($_POST[$field]) && is_array($_POST[$field])) {
            $values = array_map('sanitize_text_field', wp_unslash($_POST[$field]));
            $lines[] = $label . ': ' . implode(', ', array_slice($values, 0, 10));
        }
    }
    $lines[] = "\nMeddelande:\n" . $message;
    $saved = wp_insert_post([
        'post_type' => 'arvinge_forfragan',
        'post_status' => 'private',
        'post_title' => ucfirst($type) . ' – ' . $name,
        'post_content' => implode("\n", $lines),
    ], true);
    if (is_wp_error($saved)) {
        wp_send_json_error(['message' => 'Förfrågan kunde inte sparas just nu. Försök igen eller ring oss.'], 500);
    }
    $recipients = $type === 'event' ? ['johan@arvinge.se'] : ($type === 'projekt' ? ['par@arvinge.se', 'max@arvinge.se'] : [get_option('admin_email')]);
    $subject = 'Ny förfrågan via arvinge.se: ' . ucfirst($type);
    $sent = wp_mail($recipients, $subject, implode("\n", $lines), ['Reply-To: ' . $name . ' <' . $email . '>']);
    update_post_meta($saved, '_arvinge_mail_status', $sent ? 'sent' : 'failed');
    if (!$sent) {
        wp_send_json_error(['message' => 'Meddelandet kunde inte skickas just nu. Försök igen eller ring oss.'], 500);
    }
    wp_send_json_success();
}
add_action('wp_ajax_nopriv_arvinge_contact', 'arvinge_contact_submit');
add_action('wp_ajax_arvinge_contact', 'arvinge_contact_submit');

add_action('init', function () {
    if (get_option('arvinge_contact_page_checked')) return;
    if (!get_page_by_path('kontakt')) {
        $created = wp_insert_post([
            'post_title' => 'Kontakt / Boka möte',
            'post_name' => 'kontakt',
            'post_status' => 'publish',
            'post_type' => 'page',
        ], true);
        if (is_wp_error($created)) return;
    }
    update_option('arvinge_contact_page_checked', '1');
});

add_action('init', function () {
    if (get_option('arvinge_forum_page_checked')) return;
    if (!get_page_by_path('forum-event')) {
        $created = wp_insert_post([
            'post_title' => 'Forum & Event',
            'post_name' => 'forum-event',
            'post_status' => 'publish',
            'post_type' => 'page',
        ], true);
        if (is_wp_error($created)) return;
    }
    update_option('arvinge_forum_page_checked', '1');
});

add_action('init', function () {
    if (get_option('arvinge_about_page_checked')) return;
    if (!get_page_by_path('om-oss')) {
        $created = wp_insert_post([
            'post_title' => 'Om oss',
            'post_name' => 'om-oss',
            'post_status' => 'publish',
            'post_type' => 'page',
        ], true);
        if (is_wp_error($created)) return;
    }
    update_option('arvinge_about_page_checked', '1');
});

add_action('init', function () {
    if (get_option('arvinge_blog_press_pages_checked')) return;
    foreach (['blogg' => 'Blogg', 'press' => 'Press'] as $slug => $title) {
        if (get_page_by_path($slug)) continue;
        $created = wp_insert_post([
            'post_title' => $title,
            'post_name' => $slug,
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => $slug === 'press' ? '[arvinge_pressrum]' : '',
        ], true);
        if (is_wp_error($created)) return;
    }
    update_option('arvinge_blog_press_pages_checked', '1');
});
