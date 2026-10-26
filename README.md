# Prime Recovery theme

Custom WordPress theme for Prime Recovery. The theme lives in `theme/`.

Every push to `main` deploys `theme/` to the SiteGround **staging** site (primerecovery.yroc.host) at `wp-content/themes/prime-recovery` via `.github/workflows/deploy-staging.yml`. It can also be run by hand from the Actions tab. Nothing outside the theme folder is touched, and it never deploys to the live site.

Required repo secrets: `SG_SSH_PRIVATE_KEY`, `SG_SSH_HOST`, `SG_SSH_USER`, `SG_SSH_PORT`, `SG_THEME_PATH`.
