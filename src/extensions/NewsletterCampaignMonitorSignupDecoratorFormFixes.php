<?php


class EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes extends Extension
{
    private static $fields_to_hide = array(
        "FirstName",
        "Surname",
        "SubscribeChoice"
    );
    /**
     *
     * @var CampaignMonitorAPIConnector
     */
    private static $_api = null;

    /**
     *
     * @return CampaignMonitorAPIConnector
     */
    public function getAPI()
    {
        if (!self::$_api) {
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
                $member = Member::currentUser();
                $api = $this->getAPI();
                $currentValues = $api->getSubscriber($page->ListID, $member);
                if (!$currentValues) {
                    $emailField = null;
                    $emailRequired = true;
                }
                if (!$member) {
                    $member = new Member();
                }
                $signupField = $member->getCampaignMonitorSignupField($page->ListID, "SubscribeChoice");
                $fieldsToHide = Config::inst()->get("EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes", "fields_to_hide");
                foreach ($fieldsToHide as $field) {
                    Requirements::customCSS("#CMCustomField".$field." {display: none;}");
                }
                $config = EcommerceDBConfig::current_ecommerce_db_config();
                if ($config->CampaignMonitorSignupHeader) {
                    $fields->push(new HeaderField("CampaignMonitorNewsletterSignupHeader", $config->CampaignMonitorSignupHeader, 3));
                }
                if ($config->CampaignMonitorSignupIntro) {
                    $fields->push(new LiteralField("CampaignMonitorNewsletterSignupContent", "<p class=\"campaignMonitorNewsletterSignupContent\">".$config->CampaignMonitorSignupIntro."</p>"));
                }
                $label = $config->CampaignMonitorSignupLabel;
                if (!$label) {
                    $label = _t("EcommerceNewsletterCampaignMonitorSignupDecoratorFormFixes.JOIN", "Join");
                }
                $fields->push(new CheckboxField("CampaignMonitorNewsletterSubscribeCheckBox", $config->CampaignMonitorSignupLabel));
                $fields->push($signupField);
                Requirements::customCSS("
                    #SubscribeChoice {display: none!important;}
                    .CMFieldsCustomFieldsHolder {display: none!important;}
                ");
                Requirements::customScript("jQuery(\"#CampaignMonitorNewsletterSubscribeCheckBox\").on(\"change\", function(){jQuery(\".CMFieldsCustomFieldsHolder\").slideToggle();});");
            }
        }
    }


    /**
     * adds the user to the list ...
     * @param Array $data
     * @param Form $form
     * @param Order $order
     * @param Member $member
     */
    public function saveAddressExtension($data, $form, $order = null, $member = null)
    {
        if (isset($data["CampaignMonitorNewsletterSubscribeCheckBox"]) && $data["CampaignMonitorNewsletterSubscribeCheckBox"]) {
            if ($this->hasCampaignMonitorPage()) {
                $page = $this->CampaignMonitorPage();
                if ($page->ReadyToReceiveSubscribtions()) {

                    //true until proven otherwise.
                    $newlyCreatedMember = false;
                    $api = $this->getAPI();
                    $isSubscribe = isset($data["SubscribeChoice"]) && $data["SubscribeChoice"] == "Subscribe";
                    $member = Member::currentUser();
                    if (!$member) {
                        $memberAlreadyLoggedIn = false;
                        $existingMember = Member::get()->filter(array("Email" => Convert::raw2sql($data["Email"])))->First();
                        //if($isSubscribe && $existingMember){
                        //$form->addErrorMessage('Email', _t("CAMPAIGNMONITORSIGNUPPAGE.EMAIL_EXISTS", "This email is already in use. Please log in for this email or try another email address."), 'warning');
                        //$this->redirectBack();
                        //return;
                        //}
                        $member = $existingMember;
                        if (!$member) {
                            $newlyCreatedMember = true;
                            $member = new Member();
                        }
                    }

                    //logged in: if the member already as someone else then you can't sign up.
                    else {
                        $memberAlreadyLoggedIn = true;
                        //$existingMember = Member::get()
                        //	->filter(array("Email" => Convert::raw2sql($data["CampaignMonitorEmail"])))
                        //	->exclude(array("ID" => $member->ID))
                        //	->First();
                        //if($isSubscribe && $existingMember) {
                            //$form->addErrorMessage('CampaignMonitorEmail', _t("CAMPAIGNMONITORSIGNUPPAGE.EMAIL_EXISTS", "This email is already in use by someone else. Please log in for this email or try another email address."), 'warning');
                            //$this->redirectBack();
                            //return;
                        //}
                    }

                    //if this is a new member then we save the member
                    if ($isSubscribe) {
                        if ($newlyCreatedMember) {
                            $form->saveInto($member);
                            $member->Email = Convert::raw2sql($data["CampaignMonitorEmail"]);
                            $member->SetPassword = true;
                            $member->Password = Member::create_new_password();
                            $member->write();
                        }
                    }
                    $outcome = $member->processCampaignMonitorSignupField($page, $data, $form);
                }
            }
        }
    }

    /**
     * returns ID of Mailing List that people are subscribing to.
     * @return CampaignMonitorPage
     */
    protected function hasCampaignMonitorPage()
    {
        $config = EcommerceDBConfig::current_ecommerce_db_config();
        return $config->CampaignMonitorSignupPageID ? true : false;
    }

    /**
     * returns ID of Mailing List that people are subscribing to.
     * @return CampaignMonitorPage
     */
    protected function campaignMonitorPage()
    {
        $config = EcommerceDBConfig::current_ecommerce_db_config();
        return $config->CampaignMonitorSignupPage();
    }
}
