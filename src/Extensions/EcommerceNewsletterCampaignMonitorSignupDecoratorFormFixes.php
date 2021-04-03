<?php

namespace Sunnysideup\EcommerceNewsletterCampaignMonitor\Extensions;

use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Convert;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;
use Sunnysideup\CampaignMonitor\Api\CampaignMonitorAPIConnector;
use Sunnysideup\Ecommerce\Config\EcommerceConfig;

class EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes extends Extension
{
    private static $fields_to_hide = [
        'FirstName',
        'Surname',
        'SubscribeChoice',
    ];

    /**
     * @var CampaignMonitorAPIConnector
     */
    private static $_api;

    /**
     * @return CampaignMonitorAPIConnector
     */
    public function getAPI()
    {
        if (! self::$_api) {
            self::$_api = CampaignMonitorAPIConnector::create();
            self::$_api->init();
        }
        return self::$_api;
    }

    public function updateFields(FieldList $fields)
    {
        if ($this->hasCampaignMonitorPage()) {
            $page = $this->CampaignMonitorPage();
            if ($page->ReadyToReceiveSubscribtions()) {
                // Create fields
                $member = Security::getCurrentUser();
                if (! $member) {
                    $member = new Member();
                }
                $signupField = $member->getCampaignMonitorSignupField($page->ListID, 'SubscribeChoice');
                $fieldsToHide = Config::inst()->get(EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes::class, 'fields_to_hide');
                foreach ($fieldsToHide as $field) {
                    Requirements::customCSS('#CMCustomField' . $field . ' {display: none;}');
                }
                $config = EcommerceConfig::inst();
                if ($config->CampaignMonitorSignupHeader) {
                    $fields->push(new HeaderField('CampaignMonitorNewsletterSignupHeader', $config->CampaignMonitorSignupHeader, 3));
                }
                if ($config->CampaignMonitorSignupIntro) {
                    $fields->push(new LiteralField('CampaignMonitorNewsletterSignupContent', '<p class="campaignMonitorNewsletterSignupContent">' . $config->CampaignMonitorSignupIntro . '</p>'));
                }
                $label = $config->CampaignMonitorSignupLabel;
                if (! $label) {
                    $label = _t('EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.JOIN', 'Join');
                }
                $fields->push(new CheckboxField('CampaignMonitorNewsletterSubscribeCheckBox', $label));
                $fields->push($signupField);
                Requirements::customCSS('
                    #SubscribeChoice {display: none!important;}
                    .CMFieldsCustomFieldsHolder {display: none!important;}
                ');
                Requirements::customScript('jQuery("#CampaignMonitorNewsletterSubscribeCheckBox").on("change", function(){jQuery(".CMFieldsCustomFieldsHolder").slideToggle();});');
            }
        }
    }

    /**
     * adds the user to the list ...
     * @param array $data
     * @param \SilverStripe\Forms\Form $form
     * @param \Sunnysideup\Ecommerce\Model\Order $order
     * @param Member $member
     */
    public function saveAddressExtension($data, $form, $order = null, $member = null)
    {
        if (isset($data['CampaignMonitorNewsletterSubscribeCheckBox']) && $data['CampaignMonitorNewsletterSubscribeCheckBox']) {
            if ($this->hasCampaignMonitorPage()) {
                $page = $this->CampaignMonitorPage();
                if ($page->ReadyToReceiveSubscribtions()) {
                    //true until proven otherwise.
                    $newlyCreatedMember = false;
                    $isSubscribe = isset($data['SubscribeChoice']) && $data['SubscribeChoice'] === 'Subscribe';
                    $member = Security::getCurrentUser();
                    if (! $member) {
                        //$memberAlreadyLoggedIn = false;
                        $existingMember = Member::get()->filter(['Email' => Convert::raw2sql($data[Email::class])])->First();
                        //if($isSubscribe && $existingMember){
                        //$form->addErrorMessage('Email', _t("CAMPAIGNMONITORSIGNUPPAGE.EMAIL_EXISTS", "This email is already in use. Please log in for this email or try another email address."), 'warning');
                        //$this->redirectBack();
                        //return;
                        //}
                        $member = $existingMember;
                        if (! $member) {
                            $newlyCreatedMember = true;
                            $member = new Member();
                        }
                    }
                    //logged in: if the member already as someone else then you can't sign up.
                    //$memberAlreadyLoggedIn = true;
                    //$existingMember = Member::get()
                    //	->filter(array("Email" => Convert::raw2sql($data["CampaignMonitorEmail"])))
                    //	->exclude(array("ID" => $member->ID))
                    //	->First();
                    //if($isSubscribe && $existingMember) {
                    //$form->addErrorMessage('CampaignMonitorEmail', _t("CAMPAIGNMONITORSIGNUPPAGE.EMAIL_EXISTS", "This email is already in use by someone else. Please log in for this email or try another email address."), 'warning');
                    //$this->redirectBack();
                    //return;
                    //}

                    //if this is a new member then we save the member
                    if ($isSubscribe) {
                        if ($newlyCreatedMember) {
                            $form->saveInto($member);
                            $member->Email = Convert::raw2sql($data['CampaignMonitorEmail']);
                            //$member->SetPassword = true;
                            //$member->Password = Member::create_new_password();
                            $member->write();
                        }
                    }
                    $member->processCampaignMonitorSignupField($page, $data, $form);
                }
            }
        }
    }

    /**
     * returns ID of Mailing List that people are subscribing to.
     * @return \Sunnysideup\CampaignMonitor\CampaignMonitorSignupPage
     */
    protected function hasCampaignMonitorPage()
    {
        $config = EcommerceConfig::inst();
        return (bool) $config->CampaignMonitorSignupPageID;
    }

    /**
     * returns ID of Mailing List that people are subscribing to.
     * @return \Sunnysideup\CampaignMonitor\CampaignMonitorSignupPage
     */
    protected function campaignMonitorPage()
    {
        $config = EcommerceConfig::inst();
        return $config->CampaignMonitorSignupPage();
    }
}
