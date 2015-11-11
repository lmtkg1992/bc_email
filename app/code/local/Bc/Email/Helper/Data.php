<?php
class Bc_Email_Helper_Data extends Mage_Core_Helper_Abstract{
    public function checkVersion($version)
    {
        return version_compare(Mage::getVersion(), $version, '>=');
    }
}