# WooCommerce Store Project

This WordPress project powers an online store built with **WooCommerce**.  
It includes custom themes and plugins for managing products, orders, and secure payments.  
Database credentials are handled securely through **GitHub Actions Secrets** during automated deployments.

## Key Information

- **Platform:** WordPress + WooCommerce
- **Deployment:** GitHub Actions → FTP
- **Uploads:** Product images and media stored in `wp-content/uploads/` (excluded from auto deploys)
- **Database Credentials:** Injected via `wp-config.php` using GitHub Secrets
