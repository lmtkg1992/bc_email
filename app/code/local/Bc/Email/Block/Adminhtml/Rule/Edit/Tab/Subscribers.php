<?php
class Bc_Email_Block_Adminhtml_Rule_Edit_Tab_Subscribers extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm(){
        $data = Mage::registry('email_data');
        if (is_object($data)) {
            $data = $data->getData();
        }

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('subscribers_only', array('legend' => $this->__('Newsletter Subscribers')));

        # send_to_subscribers_only field
        $fieldset->addField(
            'send_to_subscribers_only', 'select',
            array(
                'label'  => $this->__('Send only to newsletter subscribers'),
                'name'   => 'send_to_subscribers_only',
                'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
            )
        );


        $form->setValues($data);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}