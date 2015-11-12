<?php
libxml_use_internal_errors(true);

try {
    $filename = Mage::getModel('core/config')->getOptions()->getCodeDir() . DS . 'local' . DS . 'Bc'. DS . 'email' . DS . 'sql' . DS . 'bc_email_setup' . DS . 'bc-email-templates.xml';
    $xml = simplexml_load_file($filename, 'SimpleXMLElement', LIBXML_NOCDATA);

    if (!$xml) {
        foreach (libxml_get_errors() as $error) {
            $message = 'Failed to load XML : ' . $error->message;
            $subject = "Failed to load XML";
        }
        return;
    }

    libxml_clear_errors();

    define('TEMPLATE_PREFIX', 'template="nsltr:');

    $templates = array();
    $existingTemplates = array();
    $model = Mage::getModel('newsletter/template');
    foreach ($xml as $template) {
        $data = array();
        foreach ($template as $fieldName => $value) {
            $data[$fieldName] = (string)$template->$fieldName;
        }

        if (!isset($data['template_code']) || $model->loadByCode($data['template_code'])->getId()) {
            continue;
        }
        $templates[] = $data;
    }

    foreach ($templates as $data) {
        foreach ($existingTemplates as $k => $v) {
            $data['template_text'] = str_replace(
                TEMPLATE_PREFIX . $k . '"', TEMPLATE_PREFIX . $k . '_' . $v . '"', $data['template_text']
            );
        }
        $model
            ->setData($data)
            ->setTemplateId(null)
            ->setTemplateType(Mage_Newsletter_Model_Template::TYPE_TEXT)
            ->setTemplateActual(1)
            ->save()
        ;
    }
} catch (Exception $e) {
    Mage::logException($e);
}