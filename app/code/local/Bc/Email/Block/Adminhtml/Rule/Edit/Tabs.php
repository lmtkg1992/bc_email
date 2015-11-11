<?php

class Bc_Email_Block_Adminhtml_Rule_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('email_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Rule Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab(
            'general',
            array(
                'label'   => $this->__('General'),
                'title'   => $this->__('General'),
                'content' => $this->getLayout()->createBlock('email/adminhtml_rule_edit_tab_general')->toHtml()
            )
        );

        if ($tabName = $this->getRequest()->getParam('tab')) {
            $tabName = (strpos($tabName, 'email_tabs_') !== false)
                ? substr($tabName, strlen('email_tabs_'))
                : $tabName . '_section';

            if (isset($this->_tabs[$tabName])) {
                $this->setActiveTab($tabName);
            }
        }

        return parent::_beforeToHtml();
    }
}