<?php
class Bc_Email_Model_Source_Rule_Template
{
    const TEMPLATE_SOURCE_EMAIL = 'email';
    const TEMPLATE_SOURCE_NEWSLETTER = 'nsltr';
    const TEMPLATE_SOURCE_SEPARATOR = ':';

    /*
     * Returns email template names
     * @return array
     */
    public function getEmailTemplates()
    {
        $templates = array();
        $templates[self::TEMPLATE_SOURCE_EMAIL] = Mage::helper('email')->__('Email Templates');

        $templateArray = Mage::getResourceSingleton('core/email_template_collection')->toArray();
        foreach ($templateArray['items'] as $value) {
            $key = self::TEMPLATE_SOURCE_EMAIL . self::TEMPLATE_SOURCE_SEPARATOR . $value['template_id'];
            $templates[$key] = $value['template_code'];
        }

        $templates[self::TEMPLATE_SOURCE_NEWSLETTER] = Mage::helper('email')->__('Newsletter Templates');
        $templateArray = Mage::getResourceModel('newsletter/template_collection')->load();
        foreach ($templateArray as $item) {
            $key = self::TEMPLATE_SOURCE_NEWSLETTER . self::TEMPLATE_SOURCE_SEPARATOR . $item->getData('template_id');
            $templates[$key] = $item->getData('template_code');
        }

        return $templates;
    }

}