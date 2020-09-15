2020-07-07 01:07

# running php upgrade upgrade see: https://github.com/silverstripe/silverstripe-upgrader
cd /var/www/upgrades/ecommerce_newsletter_campaign_monitor
php /var/www/upgrades/upgrader_tool/vendor/silverstripe/upgrader/bin/upgrade-code upgrade /var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor  --root-dir=/var/www/upgrades/ecommerce_newsletter_campaign_monitor --write -vvv
Writing changes for 6 files
Running upgrades on "/var/www/upgrades/ecommerce_newsletter_campaign_monitor/ecommerce_newsletter_campaign_monitor"
[2020-07-07 13:07:18] Applying RenameClasses to _config.php...
[2020-07-07 13:07:18] Applying ClassToTraitRule to _config.php...
[2020-07-07 13:07:18] Applying UpdateConfigClasses to config.yml...
[2020-07-07 13:07:18] Applying RenameClasses to EcommerceNewsletterCampaignMonitorTest.php...
[2020-07-07 13:07:18] Applying ClassToTraitRule to EcommerceNewsletterCampaignMonitorTest.php...
[2020-07-07 13:07:18] Applying RenameClasses to NewsletterCampaignMonitorSignupDecoratorFormFixes.php...
[2020-07-07 13:07:18] Applying ClassToTraitRule to NewsletterCampaignMonitorSignupDecoratorFormFixes.php...
[2020-07-07 13:07:18] Applying RenameClasses to EcommerceNewsletterCampaignMonitorSignupDecoratorConfigFixes.php...
[2020-07-07 13:07:18] Applying ClassToTraitRule to EcommerceNewsletterCampaignMonitorSignupDecoratorConfigFixes.php...
[2020-07-07 13:07:18] Applying RenameClasses to NewsletterCampaignMonitorSignupDecoratorConfigFixes.php...
[2020-07-07 13:07:18] Applying ClassToTraitRule to NewsletterCampaignMonitorSignupDecoratorConfigFixes.php...
[2020-07-07 13:07:18] Applying RenameClasses to EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.php...
[2020-07-07 13:07:18] Applying ClassToTraitRule to EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.php...
modified:	_config/config.yml
@@ -3,12 +3,10 @@
 Before: 'app/*'
 After: ['#coreconfig', '#cmsextensions', '#ecommerce']
 ---
-OrderFormAddress:
+Sunnysideup\Ecommerce\Forms\OrderFormAddress:
   extensions:
-    - EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes
+    - Sunnysideup\EcommerceNewsletterCampaignMonitor\Extensions\EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes
+Sunnysideup\Ecommerce\Model\Config\EcommerceDBConfig:
+  extensions:
+    - Sunnysideup\EcommerceNewsletterCampaignMonitor\Extensions\EcommerceNewsletterCampaignMonitorSignupDecoratorConfigFixes

-EcommerceDBConfig:
-  extensions:
-    - EcommerceNewsletterCampaignMonitorSignupDecoratorConfigFixes
-
-

modified:	tests/EcommerceNewsletterCampaignMonitorTest.php
@@ -1,4 +1,6 @@
 <?php
+
+use SilverStripe\Dev\SapphireTest;

 class EcommerceNewsletterCampaignMonitorTest extends SapphireTest
 {

modified:	src/Extensions/NewsletterCampaignMonitorSignupDecoratorFormFixes.php
@@ -2,17 +2,31 @@

 namespace Sunnysideup\EcommerceNewsletterCampaignMonitor\Extensions;

-use Extension;
-use CampaignMonitorAPIConnector;
-use FieldList;
-use Member;
-use Config;
-use Requirements;
-use EcommerceDBConfig;
-use HeaderField;
-use LiteralField;
-use CheckboxField;
-use Convert;
+
+
+
+
+
+
+
+
+
+
+
+use Sunnysideup\CampaignMonitor\Api\CampaignMonitorAPIConnector;
+use SilverStripe\Forms\FieldList;
+use SilverStripe\Security\Member;
+use SilverStripe\Core\Config\Config;
+use Sunnysideup\EcommerceNewsletterCampaignMonitor\Extensions\EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes;
+use SilverStripe\View\Requirements;
+use Sunnysideup\Ecommerce\Model\Config\EcommerceDBConfig;
+use SilverStripe\Forms\HeaderField;
+use SilverStripe\Forms\LiteralField;
+use SilverStripe\Forms\CheckboxField;
+use SilverStripe\Control\Email\Email;
+use SilverStripe\Core\Convert;
+use SilverStripe\Core\Extension;
+



@@ -68,7 +82,7 @@
                     $member = new Member();
                 }
                 $signupField = $member->getCampaignMonitorSignupField($page->ListID, "SubscribeChoice");
-                $fieldsToHide = Config::inst()->get("EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes", "fields_to_hide");
+                $fieldsToHide = Config::inst()->get(EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes::class, "fields_to_hide");
                 foreach ($fieldsToHide as $field) {
                     Requirements::customCSS("#CMCustomField".$field." {display: none;}");
                 }
@@ -116,7 +130,7 @@
                     $member = Security::currentUser();
                     if (!$member) {
                         $memberAlreadyLoggedIn = false;
-                        $existingMember = Member::get()->filter(array("Email" => Convert::raw2sql($data["Email"])))->First();
+                        $existingMember = Member::get()->filter(array("Email" => Convert::raw2sql($data[Email::class])))->First();
                         //if($isSubscribe && $existingMember){
                         //$form->addErrorMessage('Email', _t("CAMPAIGNMONITORSIGNUPPAGE.EMAIL_EXISTS", "This email is already in use. Please log in for this email or try another email address."), 'warning');
                         //$this->redirectBack();

modified:	src/Extensions/EcommerceNewsletterCampaignMonitorSignupDecoratorConfigFixes.php
@@ -2,12 +2,19 @@

 namespace Sunnysideup\EcommerceNewsletterCampaignMonitor\Extensions;

-use DataExtension;
-use FieldList;
-use CampaignMonitorSignupPage;
-use DropdownField;
-use TextField;
-use LiteralField;
+
+
+
+
+
+
+use Sunnysideup\CampaignMonitor\CampaignMonitorSignupPage;
+use SilverStripe\Forms\FieldList;
+use SilverStripe\Forms\DropdownField;
+use SilverStripe\Forms\TextField;
+use SilverStripe\Forms\LiteralField;
+use SilverStripe\ORM\DataExtension;
+



@@ -29,7 +36,7 @@
     );

     private static $has_one = array(
-        "CampaignMonitorSignupPage" => "CampaignMonitorSignupPage"
+        "CampaignMonitorSignupPage" => CampaignMonitorSignupPage::class
     );

     public function onBeforeWrite()

modified:	src/Extensions/NewsletterCampaignMonitorSignupDecoratorConfigFixes.php
@@ -2,12 +2,19 @@

 namespace Sunnysideup\EcommerceNewsletterCampaignMonitor\Extensions;

-use DataExtension;
-use FieldList;
-use CampaignMonitorSignupPage;
-use DropdownField;
-use TextField;
-use LiteralField;
+
+
+
+
+
+
+use Sunnysideup\CampaignMonitor\CampaignMonitorSignupPage;
+use SilverStripe\Forms\FieldList;
+use SilverStripe\Forms\DropdownField;
+use SilverStripe\Forms\TextField;
+use SilverStripe\Forms\LiteralField;
+use SilverStripe\ORM\DataExtension;
+



@@ -29,7 +36,7 @@
     );

     private static $has_one = array(
-        "CampaignMonitorSignupPage" => "CampaignMonitorSignupPage"
+        "CampaignMonitorSignupPage" => CampaignMonitorSignupPage::class
     );

     public function onBeforeWrite()

modified:	src/Extensions/EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.php
@@ -2,17 +2,31 @@

 namespace Sunnysideup\EcommerceNewsletterCampaignMonitor\Extensions;

-use Extension;
-use CampaignMonitorAPIConnector;
-use FieldList;
-use Member;
-use Config;
-use Requirements;
-use EcommerceDBConfig;
-use HeaderField;
-use LiteralField;
-use CheckboxField;
-use Convert;
+
+
+
+
+
+
+
+
+
+
+
+use Sunnysideup\CampaignMonitor\Api\CampaignMonitorAPIConnector;
+use SilverStripe\Forms\FieldList;
+use SilverStripe\Security\Member;
+use SilverStripe\Core\Config\Config;
+use Sunnysideup\EcommerceNewsletterCampaignMonitor\Extensions\EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes;
+use SilverStripe\View\Requirements;
+use Sunnysideup\Ecommerce\Model\Config\EcommerceDBConfig;
+use SilverStripe\Forms\HeaderField;
+use SilverStripe\Forms\LiteralField;
+use SilverStripe\Forms\CheckboxField;
+use SilverStripe\Control\Email\Email;
+use SilverStripe\Core\Convert;
+use SilverStripe\Core\Extension;
+



@@ -68,7 +82,7 @@
                     $member = new Member();
                 }
                 $signupField = $member->getCampaignMonitorSignupField($page->ListID, "SubscribeChoice");
-                $fieldsToHide = Config::inst()->get("EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes", "fields_to_hide");
+                $fieldsToHide = Config::inst()->get(EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes::class, "fields_to_hide");
                 foreach ($fieldsToHide as $field) {
                     Requirements::customCSS("#CMCustomField".$field." {display: none;}");
                 }
@@ -116,7 +130,7 @@
                     $member = Security::currentUser();
                     if (!$member) {
                         $memberAlreadyLoggedIn = false;
-                        $existingMember = Member::get()->filter(array("Email" => Convert::raw2sql($data["Email"])))->First();
+                        $existingMember = Member::get()->filter(array("Email" => Convert::raw2sql($data[Email::class])))->First();
                         //if($isSubscribe && $existingMember){
                         //$form->addErrorMessage('Email', _t("CAMPAIGNMONITORSIGNUPPAGE.EMAIL_EXISTS", "This email is already in use. Please log in for this email or try another email address."), 'warning');
                         //$this->redirectBack();

Writing changes for 6 files
✔✔✔