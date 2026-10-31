<?php
defined('ABSPATH') || exit;

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
    register_nav_menus(['primary' => __('Huvudmeny', 'arvinge')]);
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('arvinge-font', 'https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300;400;500;600;700&display=swap', [], null);
    wp_enqueue_style('arvinge-style', get_stylesheet_uri(), ['arvinge-font'], wp_get_theme()->get('Version'));
    wp_enqueue_script('arvinge-home', get_template_directory_uri() . '/assets/home.js', [], wp_get_theme()->get('Version'), true);
});

function arvinge_asset($name) {
    return esc_url(get_template_directory_uri() . '/assets/' . $name);
}

function arvinge_page($slug) {
    return esc_url(home_url('/' . trim($slug, '/') . '/'));
}
