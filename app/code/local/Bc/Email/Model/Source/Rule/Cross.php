<?php

class Bc_Email_Model_Source_Rule_Cross
{
    const MAGENTO_CROSS = 'magento_cross';
    const MAGENTO_RELATED = 'magento_related';
    const MAGENTO_UPSELLS = 'magento_upsells';
    const BC_WBTAB = 'bc_wbtab';
    const BC_ARP2 = 'bc_arp2';

    public static function toOptionArray()
    {
        $helper = Mage::helper('email');
        $options = array(
            array('value' => self::MAGENTO_CROSS, 'label' => $helper->__('Magento Cross-sell products')),
            array('value' => self::MAGENTO_RELATED, 'label' => $helper->__('Magento Related products')),
            array('value' => self::MAGENTO_UPSELLS, 'label' => $helper->__('Magento Upsell products')),
            array('value' => self::BC_WBTAB, 'label' => $helper->__('BC Who bought this also bought')),
            array('value' => self::BC_ARP2, 'label' => $helper->__('BC Autorelated products 2')),
        );
        return $options;
    }

}
