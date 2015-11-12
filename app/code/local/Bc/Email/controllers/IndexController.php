<?php


class Bc_Email_IndexController extends Mage_Core_Controller_Front_Action
{
    const TEMPLATE_SOURCE_EMAIL = 'email';
    const TEMPLATE_SOURCE_NEWSLETTER = 'nsltr';
    const TEMPLATE_SOURCE_SEPARATOR = ':';
    public function indexAction()
    {
        /*$orderStatuses = Mage::getSingleton('sales/order_config')->getStatuses();
        $productTypesArray = Mage::getConfig()->getNode('global/catalog/product/type')->asArray();

        $res = Mage::helper('customer')->getGroups()->toOptionArray();

        Mage::getSingleton('adminhtml/session')->setEmailData('123');

        $data = Mage::getModel('email/rule')->getCollection()->getFirstItem()->getData();

        $templateArray = Mage::getResourceModel('newsletter/template_collection')->load();

        foreach ($templateArray as $item) {
            $key = self::TEMPLATE_SOURCE_NEWSLETTER . self::TEMPLATE_SOURCE_SEPARATOR . $item->getData('template_id');
            $templates[$key] = $item->getData('template_code');
        }

        $obj = new Bc_Email_Block_Adminhtml_Rule_Edit_Tab_General;
        */
        $formatDate = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);


        echo '<pre>';
        var_dump($formatDate);
        die;
       /* echo '<pre>';
        print_r($data['active_from']);
        $data['active_from'] = Mage::app()->getLocale()->date($data['active_from'], Varien_Date::DATETIME_INTERNAL_FORMAT);
        $outputFormat = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
        echo '<pre>';
        echo '<br>';
        print_r($outputFormat);
        die;*/
    }
}