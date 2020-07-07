<?php



/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: automated upgrade
  * OLD:  extends DataExtension (ignore case)
  * NEW:  extends DataExtension (COMPLEX)
  * EXP: Check for use of $this->anyVar and replace with $this->anyVar[$this->owner->ID] or consider turning the class into a trait
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
class EcommerceNewsletterCampaignMonitorSignupDecoratorConfigFixes extends DataExtension
{
    private static $db = array(
        "CampaignMonitorSignupHeader" => "Varchar(50)",
        "CampaignMonitorSignupIntro" => "Varchar(255)",
        "CampaignMonitorSignupLabel" => "Varchar(30)"
    );

    private static $has_one = array(
        "CampaignMonitorSignupPage" => "CampaignMonitorSignupPage"
    );

    public function onBeforeWrite()
    {
        if (!$this->owner->CampaignMonitorSignupPageID) {
            $this->owner->CampaignMonitorSignupHeader = "";
            $this->owner->CampaignMonitorSignupIntro = "";
            $this->owner->CampaignMonitorSignupLabel = "";
        }
    }

    public function updateCMSFields(FieldList $fields)
    {
        $lists = CampaignMonitorSignupPage::get_ready_ones();
        if ($lists && $lists->count()) {
            $options = array(0 => _t("EcommerceNewsletterCampaignMonitorSignup.PLEASE_SELECT", "-- please select --")) + $lists->map()->toArray();
            if ($this->owner->CampaignMonitorSignupPageID) {
                $fields->addFieldsToTab(
                    "Root.Newsletter",
                    array(
                        new DropdownField(
                            "CampaignMonitorSignupPageID",
                            _t("EcommerceNewsletterCampaignMonitorSignup.SIGN_UP_TO", "Sign-up for ..."),
                            $options
                        ),
                        new TextField("CampaignMonitorSignupHeader", _t("EcommerceNewsletterCampaignMonitorSignup.HEADER", "Header")),
                        new TextField("CampaignMonitorSignupIntro", _t("EcommerceNewsletterCampaignMonitorSignup.INTRO", "Intro")),
                        new TextField("CampaignMonitorSignupLabel", _t("EcommerceNewsletterCampaignMonitorSignup.LABEL", "Label"))
                    )
                );
            } else {
                $fields->addFieldsToTab(
                    "Root.Newsletter",
                    array(
                        new DropdownField(
                            "CampaignMonitorSignupPageID",
                            _t("EcommerceNewsletterCampaignMonitorSignup.SIGN_UP_TO", "Sign-up for ..."),
                            $options
                        ),
                    )
                );
                $fields->removeFieldsFromTab("Root.Main", array("CampaignMonitorSignupHeader", "CampaignMonitorSignupIntro", "CampaignMonitorSignupLabel"));
            }
        } else {
            $fields->addFieldsToTab(
                "Root.Newsletter",
                array(
                    new LiteralField(
                        "ListExplanation",
                        "<p class=\"message warning\">
						"._t("EcommerceNewsletterCampaignMonitorSignup.RECOMMENDATION_TO_SETUP", "It is recommended you set up a Campaign Monitor Page with a valid list to subscribe to.")."
						</p>"
                    ),
                    new TextField("CampaignMonitorSignupHeader", _t("EcommerceNewsletterCampaignMonitorSignup.HEADER", "Header")),
                    new TextField("CampaignMonitorSignupIntro", _t("EcommerceNewsletterCampaignMonitorSignup.INTRO", "Intro")),
                    new TextField("CampaignMonitorSignupLabel", _t("EcommerceNewsletterCampaignMonitorSignup.LABEL", "Label"))
                )
            );
            $fields->removeFieldFromTab("Root.Main", "CampaignMonitorSignupPageID");
        }
    }
}

