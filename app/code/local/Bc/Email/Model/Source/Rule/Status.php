<?php

class Bc_Email_Model_Source_Rule_Status
{
    const RULE_STATUS_DISABLED = 0;
    const RULE_STATUS_ENABLED = 1;

    public static function toOptionArray()
    {
        return array(
            self::RULE_STATUS_ENABLED  => Mage::helper('email')->__('Enabled'),
            self::RULE_STATUS_DISABLED => Mage::helper('email')->__('Disabled'),
        );
    }
}
