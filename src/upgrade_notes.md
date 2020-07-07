2020-07-07 01:07

# running php upgrade inspect see: https://github.com/silverstripe/silverstripe-upgrader
cd /var/www/upgrades/ecommerce_newsletter_campaign_monitor
php /var/www/upgrades/upgrader_tool/vendor/silverstripe/upgrader/bin/upgrade-code inspect /var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor/src  --root-dir=/var/www/upgrades/ecommerce_newsletter_campaign_monitor --write -vvv
Array
(
    [0] => Running post-upgrade on "/var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor/src"
    [1] => [2020-07-07 13:07:39] Applying ApiChangeWarningsRule to NewsletterCampaignMonitorSignupDecoratorFormFixes.php...
    [2] => PHP Fatal error:  Cannot declare class Sunnysideup\EcommerceNewsletterCampaignMonitor\Extensions\EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes, because the name is already in use in /var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor/src/Extensions/NewsletterCampaignMonitorSignupDecoratorFormFixes.php on line 204
)


------------------------------------------------------------------------
To continue, please use the following parameter: startFrom=InspectAPIChanges-1
e.g. php runme.php startFrom=InspectAPIChanges-1
------------------------------------------------------------------------
            
# running php upgrade inspect see: https://github.com/silverstripe/silverstripe-upgrader
cd /var/www/upgrades/ecommerce_newsletter_campaign_monitor
php /var/www/upgrades/upgrader_tool/vendor/silverstripe/upgrader/bin/upgrade-code inspect /var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor/src  --root-dir=/var/www/upgrades/ecommerce_newsletter_campaign_monitor --write -vvv
Array
(
    [0] => Running post-upgrade on "/var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor/src"
    [1] => [2020-07-07 13:13:31] Applying ApiChangeWarningsRule to EcommerceNewsletterCampaignMonitorSignupDecoratorConfigFixes.php...
    [2] => PHP Fatal error:  Cannot declare class Sunnysideup\EcommerceNewsletterCampaignMonitor\Extensions\EcommerceNewsletterCampaignMonitorSignupDecoratorConfigFixes, because the name is already in use in /var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor/src/Extensions/NewsletterCampaignMonitorSignupDecoratorConfigFixes.php on line 101
)


------------------------------------------------------------------------
To continue, please use the following parameter: startFrom=InspectAPIChanges-1
e.g. php runme.php startFrom=InspectAPIChanges-1
------------------------------------------------------------------------
            
# running php upgrade inspect see: https://github.com/silverstripe/silverstripe-upgrader
cd /var/www/upgrades/ecommerce_newsletter_campaign_monitor
php /var/www/upgrades/upgrader_tool/vendor/silverstripe/upgrader/bin/upgrade-code inspect /var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor/src  --root-dir=/var/www/upgrades/ecommerce_newsletter_campaign_monitor --write -vvv
Array
(
    [0] => Running post-upgrade on "/var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor/src"
    [1] => [2020-07-07 13:13:52] Applying ApiChangeWarningsRule to EcommerceNewsletterCampaignMonitorSignupDecoratorConfigFixes.php...
    [2] => PHP Fatal error:  Cannot declare class Sunnysideup\EcommerceNewsletterCampaignMonitor\Extensions\EcommerceNewsletterCampaignMonitorSignupDecoratorConfigFixes, because the name is already in use in /var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor/src/Extensions/NewsletterCampaignMonitorSignupDecoratorConfigFixes.php on line 101
)


------------------------------------------------------------------------
To continue, please use the following parameter: startFrom=InspectAPIChanges-1
e.g. php runme.php startFrom=InspectAPIChanges-1
------------------------------------------------------------------------
            
# running php upgrade inspect see: https://github.com/silverstripe/silverstripe-upgrader
cd /var/www/upgrades/ecommerce_newsletter_campaign_monitor
php /var/www/upgrades/upgrader_tool/vendor/silverstripe/upgrader/bin/upgrade-code inspect /var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor/src  --root-dir=/var/www/upgrades/ecommerce_newsletter_campaign_monitor --write -vvv
Writing changes for 0 files
Running post-upgrade on "/var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor/src"
[2020-07-07 13:14:24] Applying ApiChangeWarningsRule to EcommerceNewsletterCampaignMonitorSignupDecoratorConfigFixes.php...
[2020-07-07 13:14:24] Applying UpdateVisibilityRule to EcommerceNewsletterCampaignMonitorSignupDecoratorConfigFixes.php...
[2020-07-07 13:14:24] Applying ApiChangeWarningsRule to EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.php...
[2020-07-07 13:14:24] Applying UpdateVisibilityRule to EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.php...
unchanged:	Extensions/EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.php
Warnings for Extensions/EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.php:
 - Extensions/EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.php:91 SilverStripe\Forms\HeaderField: Requires an explicit $name constructor argument (in addition to $title)
Writing changes for 0 files
✔✔✔
# running php upgrade inspect see: https://github.com/silverstripe/silverstripe-upgrader
cd /var/www/upgrades/ecommerce_newsletter_campaign_monitor
php /var/www/upgrades/upgrader_tool/vendor/silverstripe/upgrader/bin/upgrade-code inspect /var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor/src  --root-dir=/var/www/upgrades/ecommerce_newsletter_campaign_monitor --write -vvv
Writing changes for 0 files
Running post-upgrade on "/var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor/src"
[2020-07-07 13:14:53] Applying ApiChangeWarningsRule to EcommerceNewsletterCampaignMonitorSignupDecoratorConfigFixes.php...
[2020-07-07 13:14:53] Applying UpdateVisibilityRule to EcommerceNewsletterCampaignMonitorSignupDecoratorConfigFixes.php...
[2020-07-07 13:14:54] Applying ApiChangeWarningsRule to EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.php...
[2020-07-07 13:14:54] Applying UpdateVisibilityRule to EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.php...
unchanged:	Extensions/EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.php
Warnings for Extensions/EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.php:
 - Extensions/EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.php:91 SilverStripe\Forms\HeaderField: Requires an explicit $name constructor argument (in addition to $title)
Writing changes for 0 files
✔✔✔