<?php
class Bc_Email_Block_Adminhtml_Rule_Edit_Tab_Sender extends Mage_Adminhtml_Block_Widget_Form
{
    public function _prepareForm(){
        $data = Mage::registry('email_data');
        if (is_object($data)) {
            $data = $data->getData();
        }

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('email_sender', array('legend' => $this->__('Sender Details')));

        # email_copy_to field
        $fieldset->addField(
            'sender_name', 'text',
            array(
                'label'              => $this->__('Sender Name'),
                'name'               => 'sender_name',
            )
        );

        # email_copy_to field
        $fieldset->addField(
            'sender_email', 'text',
            array(
                'label'              => $this->__('Sender Email'),
                'name'               => 'sender_email',
                'after_element_html' =>
                    '<span class="note"><small>'
                    . $this->__('Redefines sender for this rule. Sender from the general settings is used by default')
                    . '</small></span>',
            )
        );

        $form->setValues($data);
        $this->setForm($form);
        return parent::_prepareForm();

    }
}