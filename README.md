# Prime Recovery theme

Custom WordPress theme for Prime Recovery. The theme lives in `theme/`.

Every push to `main` deploys `theme/` to the SiteGround **staging** site (primerecovery.yroc.host) at `wp-content/themes/prime-recovery` via `.github/workflows/deploy-staging.yml`. It can also be run by hand from the Actions tab. Nothing outside the theme folder is touched, and it never deploys to the live site.

Required repo secrets: `SG_SSH_PRIVATE_KEY`, `SG_SSH_HOST`, `SG_SSH_USER`, `SG_SSH_PORT`, `SG_THEME_PATH`, plus `SG_SSH_PASSPHRASE` if the key has a passphrase (keys generated in SiteGround do).

## Home page design options

Three home page designs are in `theme/page-templates/` for the client to choose from. All three share the same business facts (`theme/inc/content.php`) and JSON-LD (`theme/inc/schema.php`: MedicalBusiness, locations, products and FAQPage), following the ai-search-optimization-framework guidance.

| Option | Template | Look |
| --- | --- | --- |
| A | Home – Option A (Clean Clinical) | White, top navigation, NICE1 split hero, quick-link tiles |
| B | Home – Option B (Recovery Circle) | Left navigation, clickable product circle with NICE1 at the center, info menu bars |
| C | Home – Option C (Bold Performance) | Dark and athletic, full-screen NICE1 hero, stats, Resource Library preview |

How to view them once the theme is active on staging:

- `https://primerecovery.yroc.host/` shows a chooser that links to all three (when the front page is not set to a page using one of these templates).
- `https://primerecovery.yroc.host/?pr_home=a` (or `b`, `c`) previews one option directly. Preview URLs are marked `noindex`.
- Or create a page, pick one of the templates under Page Attributes, and set it as the static front page.

Links to Shop, Resource Library, Meet the Team, Our Mission and Connect With Us point at `/shop/`, `/resources/`, `/meet-the-team/`, `/about/` and `/contact/`, which will be built after a design is chosen. Social profile URLs go in `prime_recovery_business()['social']`.
