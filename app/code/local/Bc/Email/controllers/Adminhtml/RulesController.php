<?php
class Bc_Email_Adminhtml_RulesController extends Mage_Adminhtml_Controller_Action{

    protected function _initAction()
    {
        if (Mage::helper('email')->checkVersion('1.4')) {
            $this->_title('Follow Up Rules Manager');
        }
        return $this->loadLayout()->_setActiveMenu('email/rules');
    }

    public function indexAction()
    {
        $this->_initAction()->renderLayout();
    }

    public function newAction(){
        $this->_forward('edit');
    }


    public function editAction()
    {
        if (Mage::helper('email')->checkVersion('1.4')) {
            $this->_title('Follow Up Rules Manager');
            $this->_title('Rule Edit');
        }
        $session = Mage::getSingleton('adminhtml/session');
        $ruleId = $this->getRequest()->getParam('id');
        $data = Mage::getModel('email/rule')->load($ruleId)->getData();

        if (!empty($data) || $ruleId == 0) {
            $sessionData = Mage::getSingleton('adminhtml/session')->getEmailData(true);

            if (is_array($sessionData)) {
                $data = array_merge($data, $sessionData);
            }
            $session->setEmailData(false);

            if (isset($data['cancel_events'])
                && !is_array($data['cancel_events'])
            ) {
                $data['cancel_events'] = explode(',', $data['cancel_events']);
            } else {
                $data['cancel_events'] = array();
            }

            if (!$ruleId) {
                $data['store_ids'] = array(0);
            }

            if (!isset($data['customer_groups'])
                || !$data['customer_groups']
                || !count(
                    is_array($data['customer_groups']) ? $data['customer_groups']
                        : ($data['customer_groups'] = explode(',', $data['customer_groups']))
                )
                || (in_array(Bc_Email_Model_Source_Customer_Group::CUSTOMER_GROUP_ALL, $data['customer_groups'])
                    && count($data['customer_groups']) > 1)
            ) {
                $data['customer_groups'] = array(Bc_Email_Model_Source_Customer_Group::CUSTOMER_GROUP_ALL);
            }

            if (!isset($data['chain'])) {
                $data['chain'] = array();
            } elseif (!is_array($data['chain'])) {
                $data['chain'] = @unserialize($data['chain']);
            }

            if (!isset($data['product_type_ids']) || !$data['product_type_ids']) {
                $data['product_type_ids'] = array('all');
            } elseif (is_string($data['product_type_ids'])) {
                $data['product_type_ids'] = explode(',', $data['product_type_ids']);
            }

            if (!isset($data['test_objects'])) {
                $data['test'] = array();
            } elseif (!isset($data['test'])) {
                $data['test'] = unserialize($data['test_objects']);
            }

            Mage::register('email_data', $data);

            $this->loadLayout();
            $this->_setActiveMenu('email/rule');


            $this->getLayout()
                ->getBlock('head')
                ->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('email/adminhtml_rule_edit'))->_addLeft($this->getLayout()->createBlock('email/adminhtml_rule_edit_tabs'));
        }
        else{

            Mage::getSingleton('adminhtml/session')->addError($this->__('The rule does not exist'));
            $this->_redirect('*/*/');
        }
    }


    public function saveAction($sendTest = false)
    {

        $session = Mage::getSingleton('adminhtml/session');
        if ($data = $this->getRequest()->getPost()) {


        }
    }


    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('email/rules');
    }
}
