# Prime Recovery theme

Custom WordPress theme for Prime Recovery. The theme lives in `theme/`.

Every push to `main` deploys `theme/` to the SiteGround **staging** site (primerecovery.yroc.host) at `wp-content/themes/prime-recovery` via `.github/workflows/deploy-staging.yml`. It can also be run by hand from the Actions tab. Nothing outside the theme folder is touched, and it never deploys to the live site.

Required repo secrets: `SG_SSH_PRIVATE_KEY`, `SG_SSH_HOST`, `SG_SSH_USER`, `SG_SSH_PORT`, `SG_THEME_PATH`, plus `SG_SSH_PASSPHRASE` if the key has a passphrase (keys generated in SiteGround do).

## Home page

The client chose design Option C. It is `theme/page-templates/home.php` (template "Home"), and `theme/front-page.php` renders it as the site's front page. Business facts live in `theme/inc/content.php` and feed both the page copy and the JSON-LD in `theme/inc/schema.php` (MedicalBusiness, locations, products, FAQPage), following the ai-search-optimization-framework guidance.

- Hero photo: add the DonJoy photo as `theme/assets/img/hero-donjoy.jpg` and it replaces the stand-in automatically.
- Regeomedix copy is a placeholder and is left out of the structured data until the products are confirmed.
- Links to Shop, Resource Library, Meet the Team, Our Mission and Connect With Us point at `/shop/`, `/resources/`, `/meet-the-team/`, `/about/` and `/contact/`. Social profile URLs go in `prime_recovery_business()['social']`.
