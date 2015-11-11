<?php


class Bc_Email_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $orderStatuses = Mage::getSingleton('sales/order_config')->getStatuses();
        $productTypesArray = Mage::getConfig()->getNode('global/catalog/product/type')->asArray();

        $res = Mage::helper('customer')->getGroups()->toOptionArray();

        Mage::getSingleton('adminhtml/session')->setEmailData('123');

        $data = Mage::getModel('email/rule')->getCollection()->getFirstItem()->getData();

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