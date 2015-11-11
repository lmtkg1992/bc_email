<?php
class Bc_Email_Model_Source_Customer_Group
{
    const CUSTOMER_GROUP_ALL = 'ALL';
    const CUSTOMER_GROUP_NOT_REGISTERED = 'NOT_REGISTERED';

    public static function toOptionArray()
    {
        $res = Mage::helper('customer')->getGroups()->toOptionArray();

        $found = false;
        foreach ($res as $group) {
            if ($group['value'] == 0) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            array_unshift(
                $res,
                array(
                    'value' => self::CUSTOMER_GROUP_NOT_REGISTERED,
                    'label' => Mage::helper('email')->__('Not registered')
                )
            );
        }

        array_unshift(
        $res, array('value' => self::CUSTOMER_GROUP_ALL, 'label' => Mage::helper('email')->__('All groups'))
        );

        return $res;
    }
}