<?php

class Bc_Email_Block_Adminhtml_Rule extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_rule';
        $this->_blockGroup = 'email';
        $this->_headerText = $this->__('Follow Up Rules Manager');
        $this->_addButtonLabel = $this->__('Add Rule');
        parent::__construct();
    }
}