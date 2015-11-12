<?php

class Bc_Email_Block_Adminhtml_Rule_Edit_Tab_Ga extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('ga', array('legend' => $this->__('Google Analytics Tracking Code')));

        if (Mage::helper('email')->checkExtensionVersion('Mage_Core', '0.8.27')) { // >= 1420
            if (!Mage::helper('googleanalytics')->isGoogleAnalyticsAvailable()) {
                $fieldset->addField(
                    'ga_warning', 'note',
                    array(
                        'text' => '<p style="color:#E02525;">'
                            . $this->__('Google Analytics should be configured and activated to use this feature')
                            . '</p>'
                    )
                );
            }
        } else {
            $fieldset->addField(
                'ga_warning', 'note',
                array(
                    'text' => '<p style="color:#009e00;">'
                        . $this->__('Note that Google Analytics should be configured and activated to use this feature')
                        . '</p>'
                )
            );
        }

        $fieldset->addField(
            'ga_source', 'text',
            array(
                'label' => $this->__('Campaign Source'),
                'name'  => 'ga_source',
                'note'  => $this->__('(referrer: google, citysearch, newsletter4)'),
            )
        );

        $fieldset->addField(
            'ga_medium', 'text',
            array(
                'label' => $this->__('Campaign Medium'),
                'name'  => 'ga_medium',
                'note'  => $this->__('(marketing medium: cpc, banner, email)'),
            )
        );

        $fieldset->addField(
            'ga_term', 'text',
            array(
                'label' => $this->__('Campaign Term'),
                'name'  => 'ga_term',
                'note'  => $this->__('(identify the paid keywords)'),
            )
        );

        $fieldset->addField(
            'ga_content', 'text',
            array(
                'label' => $this->__('Campaign Content'),
                'name'  => 'ga_content',
                'note'  => $this->__('(use to differentiate ads)'),
            )
        );

        $fieldset->addField(
            'ga_name', 'text',
            array(
                'label' => $this->__('Campaign Name'),
                'name'  => 'ga_name',
                'note'  => $this->__('(product, promo code, or slogan)'),
            )
        );

        if ($data = Mage::registry('email_data')) {
            $form->setValues($data);
        }
        return parent::_prepareForm();
    }
}