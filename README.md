# Arvinge WordPress theme

Custom classic theme for Arvinge, based on the supplied design references.

## Install

Copy this directory to `wp-content/themes/arvinge`, then activate **Arvinge** in WordPress. The home page is rendered by `front-page.php`. Dedicated templates render `/kontakt/`, `/forum-event/`, `/om-oss/`, `/blogg/` and `/press/`.

## Current scope

- Responsive home page with navigation, services, case selector, Forum, testimonials, team, CTA and FAQ.
- Images and video are bundled under `assets/`.
- The hero keeps its still image visible while the page loads. After the page, font and still image are ready, it loads a separate optimized video for desktop or mobile during idle time and fades it in only after the first decoded frame. Video stays off for reduced-motion or data-saving visitors.
- Page URLs are generated from the WordPress site URL. The theme creates `forum-event`, `om-oss`, `kontakt`, `blogg` and `press` pages if they are missing. The blog lists published WordPress posts. The press page renders `[arvinge_pressrum]`, supplied by the press room plugin.
- Individual articles use an editorial template. Author names display as Pär Johansson and Max Loman where the WordPress profile name is an email address.
- The footer points to the contact page. The analyzer form was removed because the old Breakdance tool is no longer active. Two placeholder testimonials were removed until real quotes are available.
- Old Breakdance-only pages redirect to the relevant new page while their replacement content is being planned.

## Next steps

The theme is active on arvinge.se. Update by uploading a new ZIP in WordPress or deploying the repository to `wp-content/themes/arvinge`. Keep the version in `style.css` in sync with the ZIP filename. Verify every changed page after an update.
