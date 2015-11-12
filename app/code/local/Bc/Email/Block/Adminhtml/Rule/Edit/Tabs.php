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


        $this->addTab(
            'details',
            array(
                'label'   => $this->__('Stores & Product Types'),
                'title'   => $this->__('Stores & Product Types'),
                'content' => $this->getLayout()->createBlock('email/adminhtml_rule_edit_tab_details')->toHtml()
            )
        );

        $this->addTab(
            'categories',
            array(
                'label' => $this->__('Excluded Categories'),
                'url'   => $this->getUrl('*/*/categories', array('_current' => true)),
                'class' => 'ajax',
            )
        );


        $this->addTab(
            'subscribers',
            array(
                'label'   => $this->__('Newsletter Subscribers'),
                'title'   => $this->__('Newsletter Subscribers'),
                'content' => $this->getLayout()->createBlock('email/adminhtml_rule_edit_tab_subscribers')->toHtml(),
            )
        );


        $this->addTab(
            'sendcopy',
            array(
                'label'   => $this->__('Send Copy'),
                'title'   => $this->__('Send Copy'),
                'content' => $this->getLayout()->createBlock('email/adminhtml_rule_edit_tab_sendcopy')->toHtml(),
            )
        );

        $this->addTab(
            'sender', array(
                'label'   => $this->__('Sender Details'),
                'title'   => $this->__('Sender Details'),
                'content' => $this->getLayout()->createBlock('email/adminhtml_rule_edit_tab_sender')->toHtml(),
            )
        );

        $this->addTab(
            'sendtest',
            array(
                'label'   => $this->__('Send Test Email'),
                'title'   => $this->__('Send Test Email'),
                'content' => $this->getLayout()->createBlock('email/adminhtml_rule_edit_tab_sendtest')->toHtml(),
            )
        );


        $this->addTab(
            'ga',
            array(
                'label'   => $this->__('Google Analytics'),
                'title'   => $this->__('Google Analytics'),
                'content' => $this->getLayout()->createBlock('email/adminhtml_rule_edit_tab_ga')->toHtml(),
            )
        );

        $this->addTab(
            'cross',
            array(
                'label'   => $this->__('Cross-sells'),
                'title'   => $this->__('Cross-sells'),
                'content' => $this->getLayout()->createBlock('email/adminhtml_rule_edit_tab_cross')->toHtml(),
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