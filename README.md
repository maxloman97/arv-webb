# Arvinge WordPress theme

Custom classic theme for Arvinge, based on the supplied design references.

## Install

Copy this directory to `wp-content/themes/arvinge`, then activate **Arvinge** in WordPress. The home page is rendered by `front-page.php`. Dedicated templates render `/kontakt/`, `/forum-event/` and `/om-oss/`.

## Current scope

- Responsive home page with navigation, services, case selector, Forum, testimonials, team, CTA and FAQ.
- Images and video are bundled under `assets/`.
- The hero keeps its still image visible while the page loads. After the page, font and still image are ready, it loads a separate optimized video for desktop or mobile during idle time and fades it in only after the first decoded frame. Video stays off for reduced-motion or data-saving visitors.
- Page URLs are generated from the WordPress site URL. The theme creates the `forum-event`, `om-oss` and `kontakt` pages if they are missing. The linked `blogg` and `press` pages still need content.
- The supplied design contains an unfinished third testimonial and a nonfunctional analyzer form. Both are displayed to match the design and require final content or integration before launch.

## Next steps

Verify the theme in a WordPress staging environment, confirm all linked page slugs, and compare the rendered page at desktop and phone widths with the supplied references before activating it on the live site.
