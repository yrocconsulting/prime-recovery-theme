# Prime Recovery theme

Custom WordPress theme for Prime Recovery. The theme lives in `theme/`.

Every push to `main` deploys `theme/` to the SiteGround **staging** site (primerecovery.yroc.host) at `wp-content/themes/prime-recovery` via `.github/workflows/deploy-staging.yml`. It can also be run by hand from the Actions tab. Nothing outside the theme folder is touched, and it never deploys to the live site.

Required repo secrets: `SG_SSH_PRIVATE_KEY`, `SG_SSH_HOST`, `SG_SSH_USER`, `SG_SSH_PORT`, `SG_THEME_PATH`, plus `SG_SSH_PASSPHRASE` if the key has a passphrase (keys generated in SiteGround do).

## Home page

The client chose design Option C. It is `theme/page-templates/home.php` (template "Home"), and `theme/front-page.php` renders it as the site's front page. Business facts live in `theme/inc/content.php` and feed both the page copy and the JSON-LD in `theme/inc/schema.php` (MedicalBusiness, locations, products, FAQPage), following the ai-search-optimization-framework guidance.

- Hero photo: add the DonJoy photo as `theme/assets/img/hero-donjoy.jpg` and it replaces the stand-in automatically.
- Regeomedix copy is a placeholder and is left out of the structured data until the products are confirmed.
- Links to Shop, Resource Library, Meet the Team, Our Mission and Connect With Us point at `/shop/`, `/resources/`, `/meet-the-team/`, `/about/` and `/contact/`. Social profile URLs go in `prime_recovery_business()['social']`.

## Inner pages

The site map lives in `theme/inc/routes.php`: each route has a URL, H1, search title, meta description and a template in `theme/templates/`. A route renders its template whether or not a WordPress page exists at that URL, so pages can be previewed on staging before they are created in WP admin. Once a page exists at the same path (for example "NICE" with parent "Products" for `/products/nice/`), it uses the same template, and anything typed into the page editor is added above the FAQ.

Shared pieces (header, page hero with breadcrumbs, connect band, footer, FAQ, video cards, person cards) are in `theme/inc/template-tags.php`. Every page outputs Organization and WebSite JSON-LD; inner pages add WebPage, BreadcrumbList and whatever the template registers with `prime_recovery_add_schema()`.

Styles: `base.css` (tokens and components), `site.css` (Option C header, footer and shared sections), `pages.css` (inner pages).
