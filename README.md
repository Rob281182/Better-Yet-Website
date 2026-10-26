# Better Yet website (WordPress theme)

This repository **is** the WordPress theme for betteryet (one-page site + "Our work" page + enquiry form).
It is deployed to Hostinger with Git: Hostinger clones this repo into `wp-content/themes/betteryet` on the live site.

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
Follows Christianna's Brand Identity Board and concept doc (26 Oct 2026, proposed, not yet jointly approved): Electric Blue #0047FF, Black #0A0A0A, Off White #F7F6F3, Stone #E5E0D8, Grey #B7B7B7; bold caps Gotham-style headlines (Plus Jakarta Sans 800 as the stand-in); hand-drawn blue underlines, circles, arrows and handwriting (Caveat) via `by_scribble()` in functions.php; blue campaign panels; black-and-white people photography. Tokens at the top of `assets/site.css`; the v2 overrides are at the bottom.

## Local testing
Copy the folder into any WordPress install under `wp-content/themes/better-yet` and activate it.

## Pictures and embeds on "Our work"
Case-study images are loaded directly from the client sites (heiden.bike, roamorthotics.com.au, stephanieannestudio.com, all on the same Hostinger account), so nothing is uploaded to this site. The URLs live in the `$by_media` array at the top of `page-our-work.php`; swap a path there to change a picture. The Heiden Bike Builder is embedded live (`https://heiden.bike/builder-v2/`), and the Roam and Stephanie sites load in a frame when a visitor clicks "Preview". If a client site ever blocks framing, the poster image and "open" link still work.

## Versions
- 2.0.0: restyled to the brand identity board (electric blue, bold caps, hand-drawn marks, blue panels, B&W photos), new headline language, four-step process (Audit, Prescribe, Implement, Manage), B/Y favicon.
- 1.5.0: productised audit section, ready-made fixes (First Fix, Missed-Call Catcher, Keep It Working), data promise, tools strip, calculator email capture, new FAQ answers. Prices, credit and guarantee lines are Customizer settings (blank shows "Quoted on the call").
- 1.4.0: Ready Steady Go Kids and Damselfly case studies, plus their home-page cards.
- 1.3.0: pictures, galleries, live Heiden Bike Builder embed and site previews on Our work; thumbnails on the home-page work cards.
- 1.2.0: Our work page. 1.1.0: brand deck styling. 1.0.0: first release.
