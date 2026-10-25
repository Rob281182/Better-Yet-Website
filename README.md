# Better Yet website (WordPress theme)

This repository **is** the WordPress theme for betteryet (one-page site + "Our work" page + enquiry form).
It is deployed to Hostinger with Git: Hostinger clones this repo into `wp-content/themes/better-yet` on the live site.

## How updates go live
1. Change files here and push to `main`.
2. Trigger a pull on Hostinger (hPanel > Advanced > Git > Deploy, or the Hostinger API). Claude does this after each push.
3. Reload the site. No zip uploads.

## Files
| File | Purpose |
|---|---|
| `front-page.php` | Home page copy and sections |
| `page-our-work.php` | "Our work" case studies (template, page auto-created at /our-work/) |
| `header.php`, `footer.php` | Navigation and footer |
| `functions.php` | Settings (Appearance > Customize > Better Yet settings), enquiry form handler, Enquiries post type, privacy page |
| `assets/site.css` | Styles. Brand tokens (`--bg`, `--ink`, `--accent`, fonts) at the top |
| `assets/site.js` | Calculator, nav, form submit, analytics loaders |
| `style.css` | Theme header (name, version) |

## Brand
Follows Christie's brand deck (Oct 2026): human-first AI agency, "Smarter systems. More time back.", Gotham-like geometric sans (Plus Jakarta Sans), off-white and near-black, less decoration, more distinction. Palette and final mark still to be decided; `--accent` is black until then.

## Local testing
Copy the folder into any WordPress install under `wp-content/themes/better-yet` and activate it.
