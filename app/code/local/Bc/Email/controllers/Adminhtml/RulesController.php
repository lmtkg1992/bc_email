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

            $this->renderLayout();

        }
        else{

            Mage::getSingleton('adminhtml/session')->addError($this->__('The rule does not exist'));
            $this->_redirect('*/*/');
        }
    }


    public function categoriesAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('email/adminhtml_rule_edit_tab_categories')->toHtml()
        );
    }

    public function categoriesJsonAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('email/adminhtml_rule_edit_tab_categories')->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }
    public function saveAction($sendTest = false)
    {

        $session = Mage::getSingleton('adminhtml/session');
        if ($data = $this->getRequest()->getPost()) {


            if (!isset($data['cancel_events'])) {
                $data['cancel_events'] = '';
            } else {
                $data['cancel_events'] = implode(',', $data['cancel_events']);
            }


            if (isset($data['category_ids'])) {
                $data['category_ids'] = implode(
                    ',', array_unique(explode(' ', trim(str_replace(',', ' ', $data['category_ids']))))
                );
            }

            if (!isset($data['product_type_ids']) || in_array('all', $data['product_type_ids'])) {
                $data['product_type_ids'] = BC_Email_Model_Source_Product_Types::PRODUCT_TYPE_ALL;
            } else {
                $data['product_type_ids'] = implode(',', $data['product_type_ids']);
            }

            if (!isset($data['store_ids'])) {
                $data['store_ids'] = '';
            } elseif (is_array($data['store_ids'])) {
                $data['store_ids'] = implode(',', $data['store_ids']);
            }

            // sku
            if (!isset($data['sku'])) {
                $data['sku'] = array();
            } else {
                $data['sku'] = explode(',', $data['sku']);
            }
            foreach ($data['sku'] as $k => $v) {
                if (!$v = trim($v)) {
                    unset($data['sku'][$k]);
                } else {
                    $data['sku'][$k] = $v;
                }
            }
            $data['sku'] = implode(',', $data['sku']);

            $formatDate = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

            if ($data['active_from']) {

                try {
                    $dateFrom = Mage::app()->getLocale()->utcDate(null, $data['active_from'], true, $formatDate)->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
                } catch (Exception $e) {
                    unset($data['active_from']);
                    throw $e;
                }
                $data['active_from'] = $dateFrom;
            } else {
                $data['active_from'] = null;
            }

            //active to
            if ($data['active_to']) {
                try {
                    $date = Mage::app()->getLocale()->utcDate(null, $data['active_to'], true, $formatDate)->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
                } catch (Exception $e) {
                    unset($data['active_to']);
                    throw $e;
                }
                $data['active_to'] = $date;
            } else {
                $data['active_to'] = null;
            }

            // customer groups
            if (!isset($data['customer_groups'])) {
                $data['customer_groups'] = '';
            }
            if (!is_array($data['customer_groups'])) {
                $data['customer_groups'] = explode(',', $data['customer_groups']);
            }
            if (!count($data['customer_groups'])
                || (in_array(Bc_Email_Model_Source_Customer_Group::CUSTOMER_GROUP_ALL, $data['customer_groups'])
                    && count($data['customer_groups']) > 1)
            ) {
                $data['customer_groups'] = array(Bc_Email_Model_Source_Customer_Group::CUSTOMER_GROUP_ALL);
            }
            if (is_array($data['customer_groups'])) {
                $data['customer_groups'] = implode(',', $data['customer_groups']);
            }

            $data['test_objects'] = serialize($data['test']);

            // chain processing
            if (!isset($data['chain'])) {
                $data['chain'] = array();
            } else {
                foreach ($data['chain'] as $key => $value) {
                    if (isset($value['delete'])) {
                        if ($value['delete']) {
                            unset($data['chain'][$key]);
                        } else {
                            unset($data['chain'][$key]['delete']);
                        }
                    }
                }
                foreach ($data['chain'] as $key => $value) {
                    if (false === strpos($value['TEMPLATE_ID'],Bc_Email_Model_Source_Rule_Template::TEMPLATE_SOURCE_SEPARATOR)
                    ) {
                        $session->addError($this->__('Please select template'));
                        $session->setEmailData($data);
                        $this->_redirect( '*/*/edit', array('id' => $this->getRequest()->getParam('id'), 'tab' => 'details'));
                        return;
                    }
                }

                foreach ($data['chain'] as $k => $v) {
                    $data['chain'][$k]['DAYS'] = trim($data['chain'][$k]['DAYS']);
                    if ($data['chain'][$k]['DAYS'] && !is_numeric($data['chain'][$k]['DAYS'])) {
                        $session->addError($this->__('The quantity of days in the chain is not a number'));
                        $session->setEmailData($data);
                        $this->_redirect(
                            '*/*/edit', array('id' => $this->getRequest()->getParam('id'), 'tab' => 'details')
                        );
                        return;
                    }
                }

                if (count($data['chain']) > 1) {
                    // sorting
                    $chainSorted = array();
                    foreach ($data['chain'] as $k => $v) {
                        $chainSorted[$v['BEFORE'] * ($v['DAYS'] * 1440 + $v['HOURS'] * 60 + $v['MINUTES']) * 10000 + mt_rand(0, 9999)]
                            = $k;
                    }

                    ksort($chainSorted, SORT_NUMERIC);

                    $chain = array();
                    foreach ($chainSorted as $k => $v) {
                        $chain[] = $data['chain'][$v];
                    }

                    $data['chain'] = $chain;
                }
            }


            $data['chain'] = serialize($data['chain']);

            $data['id'] = $this->getRequest()->getParam('id');
            $model = Mage::getModel('email/rule');
            $model->setData($data);

            try {
                $model->save();

                $session->setEmailData(false);
                $session->addSuccess($this->__('Item was successfully saved'));

                if ($this->getRequest()->getParam('sendTest')) {
                    $email = $data['test_recipient'];
                    $validator = new Zend_Validate_EmailAddress();
                    if (!$validator->isValid($email)) {
                        $session->addError($this->__("Incorrect e-mail for 'Test recipient' field"));
                        $this->_redirect(
                            '*/*/edit', array('id' => $model->getId(), 'tab' => 'email_tabs_sendtest')
                        );
                        return;
                    }

                    if (!$data['test_recipient']) {
                        $session->addError(
                            $this->__('To send a test message you have to fill up the \'Test recipient\' field')
                        );
                        $this->_redirect(
                            '*/*/edit', array('id' => $model->getId(), 'tab' => 'email_tabs_sendtest')
                        );
                        return;
                    }
                    $testResult = $model->sendTestEmail($data['test']);
                    if ($testResult) {
                        $mailLogUrl = Mage::getModel('adminhtml/url')->getUrl('email_admin/adminhtml_queue');
                        $session->addSuccess(
                            $this->__(
                                'Test email is scheduled for automatic sending. '
                                . 'Go to <a href="%s">Mail Log</a> to send it manually.',
                                $mailLogUrl
                            )
                        );
                    } else {
                        $session->addError($this->__('Error sending test message'));
                    }
                }

                if ($tab = $this->getRequest()->getParam('tab')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), 'tab' => $sendTest ? $sendTest : $tab));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::log($e->getMessage(),null,'bc-email-error.log');
                $session->addError($e->getMessage());
                $session->setEmailData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }

        $session->addError($this->__('Cannot find data to save'));
        $this->_redirect('*/*/');

    }


    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('email/rules');
    }
}
