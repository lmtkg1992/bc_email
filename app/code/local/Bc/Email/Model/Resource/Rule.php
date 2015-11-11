<?php
class Bc_Email_Model_Resource_Rule extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('email/rule', 'id');
    }
}
