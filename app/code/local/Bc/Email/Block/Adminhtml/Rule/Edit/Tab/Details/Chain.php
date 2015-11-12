<?php
class Bc_Email_Block_Adminhtml_Rule_Edit_Tab_Details_Chain extends Mage_Adminhtml_Block_Widget implements Varien_Data_Form_Element_Renderer_Interface
{
    public function __construct()
    {
        $this->setTemplate('bcemail/rule/edit/details/chain.phtml');
    }

    public function isMultiWebsites()
    {
        return !Mage::app()->isSingleStoreMode();
    }

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        return $this->toHtml();
    }


    public function getEmailTemplates()
    {
        $result = array(0 => $this->__('--- Select Template ---'));
        $result = array_merge($result, Mage::getModel('email/source_rule_template')->getEmailTemplates());
        return $result;
    }

    public function getValues()
    {
        $data = $this->getElement()->getValue();
        if (!is_array($data)) {
            $data = array();
        }
        return $data;
    }


    protected function _prepareLayout()
    {
        $this->setChild(
            'add_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')->setData(
                array(
                    'label'   => $this->__('Add email'),
                    'onclick' => 'emailsControl.addItem()',
                    'class'   => 'add'
                )
            )
        );
        return parent::_prepareLayout();
    }

    public function getAddButtonHtml()
    {
        return $this->getChildHtml('add_button');
    }


}
