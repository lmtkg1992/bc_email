<?php
class Bc_Email_Helper_Data extends Mage_Core_Helper_Abstract{
    public function checkVersion($version)
    {
        return version_compare(Mage::getVersion(), $version, '>=');
    }

    public function checkExtensionVersion($extensionName, $extVersion, $operator = '>=')
    {
        if ($this->isExtensionInstalled($extensionName)
            && ($version = Mage::getConfig()->getModuleConfig($extensionName)->version)
        ) {
            return version_compare($version, $extVersion, $operator);
        }
        return false;
    }

    public function isExtensionInstalled($name)
    {
        $modules = (array)Mage::getConfig()->getNode('modules')->children();
        return array_key_exists($name, $modules)
        && 'true' == (string)$modules[$name]->active
        && !(bool)Mage::getStoreConfig('advanced/modules_disable_output/' . $name)
            ;
    }
}