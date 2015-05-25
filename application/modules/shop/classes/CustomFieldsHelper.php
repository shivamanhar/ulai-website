<?php

/**
 * CustomFieldsHelper
 *
 * @package ImageCMS.Shop.CustomFields
 * @version 0.2
 * @copyright ImageCMS©
 * @author koloda, <dev
 * @license
 */
class CustomFieldsHelper
{

    protected static $_BehaviorInstance;
    private $customData = false;
    private $entities = array('user', 'order', 'product');
    private $entities_locale = array('product');
    private $baseWidgetName = 'custom_field';
    private $formWidgetPattern = '<label for="{$inputId}">{$label}</label>{$input}';
    private $patternVariables = array('{$input}', '{$label}', '{$inputId}');
    public $requiredHtml = '<span class="must">*</span>';
    private $adminPattern = '<div class="control-group">
                                            <label class="control-label" for="{$inputId}"> {$label}: </label>
                                            <div class="controls">{$input}</div>
                                        </div>';
    private $adminPatternDesc = '<div class="control-group">
                                            <label class="control-label" for="{$inputId}">
                                                {$description}
                                                {$label}:
                                                </label>
                                            <div class="controls">
                                            {btn_elfinder}
                                            <div class="o_h">{$input}</div>
                                        </div></div>';

    private $descHTML = '<span class="popover_ref" data-original-title="">
                                                    <i class="icon-info-sign"></i>
                                                </span>
                                                <div class="d_n">
                                                    {$description}
                                    </div>';

    private $btn_elfinder = '<div class="group_icon pull-right">
                                            <button class="btn btn-small" onclick="elFinderPopup(&apos;file&apos;, &apos;{Id}&apos;);return false;"> <i class="icon-folder-open"></i> Выберите файл</button>
                                            </div>';

    //public methods

    /**
     * Collect custom fields of entity and return \CustomFieldsHelper object
     * @param string $entity Name of entity type - now support 'order' and 'user'
     * @param integer $entityId Id of entity, related wit custom field
     * @return \CustomFieldsHelper
     */
    public function getCustomFields($entity, $entityId = -1, $lookup = null)
    {


        return $this->_getCustomFields($entity, $entityId, $lookup)->prepareOptions();
    }

    /**
     * Collect custom fields of entity and return \CustomFieldsHelper object
     * @param string $entity Name of entity type - now support 'order' and 'user'
     * @param integer $entityId Id of entity, related wit custom field
     * @return object CustomFields
     */
    public function _getCustomFields($entity, $entityId = -1, $lookup = null)
    {

        $CI = &get_instance();
        //$locale = chose_language();
        $locale = $CI->config->item('language');
        switch ($locale) {
            case 'en_US' :
                $locale = 'en';
                break;
            case 'uk_UA' :
                $locale = 'ua';
                break;
            default :
                $locale = 'ru';
        }

        $entityId = (int)$entityId;
        if ($lookup === null)
            $lookup = $entity;

        if (!in_array($entity, $this->entities) || !is_numeric($entityId))
            return $this;

        if ($entityId > 0) {
            try {
                $sql = "SELECT
                    `custom_fields`.*, null as field_data,
                    custom_fields_i18n.field_label as field_label,
                    custom_fields_i18n.field_description as field_description,
                    custom_fields_i18n.possible_values as possible_values
                    FROM custom_fields
                    left join `custom_fields_i18n` on custom_fields_i18n.id = custom_fields.id
                    WHERE `custom_fields`.`entity` = '" . $entity . "'
                    and custom_fields_i18n.locale = '$locale' ORDER BY position";

                $fields = $CI->db->query($sql)->result_array();

                if (!in_array($entity, $this->entities_locale))
                    $locale = 'ru';

                $locale_def = MY_Controller::defaultLocale();
                $custom_aux = $CI->db->select("*")
                    ->distinct()
                    ->join('custom_fields_data', 'custom_fields_data.field_id = custom_fields.id', 'left')
                    ->where("`custom_fields.entity` = '" . $lookup . "' ")
                    ->where("`custom_fields_data.entity_id` = '$entityId'")
                    ->where("`custom_fields_data.locale` = '$locale_def'")
                    ->get('custom_fields')
                    ->result_array();


                foreach ($fields as $key => $val)
                    foreach ($custom_aux as $custom_one)
                        if ($custom_one['field_name'] == $val['field_name'])
                            if (!empty($custom_one['field_data']))
                                $fields[$key]['field_data'] = $custom_one['field_data'];
                            else
                                $fields[$key]['field_data'] = '';
            } catch (Exception $exc) {

                $fields = $CI->db->select("*")
                    ->join('custom_fields_i18n', 'custom_fields_i18n.id = custom_fields.id', 'left')
                    ->where("`custom_fields.entity` = '$entity' ")
                    ->where("`custom_fields_i18n.locale` = '$locale'")
                    ->get('custom_fields')->result_array();
            }

            $this->customData = $fields;
        } else {
            $this->customData = $CI->db->select("*")
                ->join('custom_fields_i18n', 'custom_fields_i18n.id = custom_fields.id', 'left')
                ->where("`custom_fields.entity` = '$entity' ")
                ->where("`custom_fields_i18n.locale` = '$locale'")
                ->get('custom_fields')
                ->result_array();
        }

        return $this;
    }

    public function asTemplate($template)
    {

        $ci = &get_instance();
        $ci->template->assign('fields', $this->customData);
        $ci->template->display('file:' . ShopCore::$template_path . '../customFields/' . $template);
    }

    /**
     * Get custom Fields by field_id and entity_name
     * @param string $entity Name of entity type - now support 'order' and 'user'
     * @param integer $entityId Id of entity, related wit custom field
     * @return Array of fields
     */
    public function getCustomFielsdAsArray($entity, $entityId = -1, $lookup = null)
    {

        $this->_getCustomFields($entity, $entityId, $lookup);

        return $this->customData;
    }

    public function _getOneCustomFieldsByName($fieldName, $entity, $entityId = -1, $lookup = null)
    {

        $this->_getCustomFields($entity, $entityId, $lookup);

        foreach ($this->customData as $key => $val) {
            if ($val['field_name'] == $fieldName) {
                $field = $this->customData[$key];
                break;
            }
        }
        return $field;
    }

    public function getOneCustomFieldsByName($fieldName, $entity, $entityId = -1, $lookup = null)
    {

        if ($field = $this->_getOneCustomFieldsByName($fieldName, $entity, $entityId, $lookup))
            $this->customData = array($field);
        else
            $this->customData = null;


        return $this->prepareOptions();
    }

    public function getOneCustomFieldsByNameArray($fieldName, $entity, $entityId = -1, $lookup = null)
    {

        return $this->_getOneCustomFieldsByName($fieldName, $entity, $entityId, $lookup);
    }

    /**
     * Return array of collected (using getCustomField() or getCustomFields()) custom fields
     * @param bool $nameKey =false If FALSE, return array, where keys are field_id's, else - field_namme's
     * @return array
     */
    public function asArray($nameKey = false)
    {
//        if (count($this->customData) == 1)
//            return $this->customData[0];

        $result = array();
        foreach ($this->customData as $customField)
            if (!$nameKey)
                $result[$customField['field_name']] = $customField;
            else
                $result[$customField['id']] = $customField;

        return $result;
    }

    /**
     * Return string with rendered collected (using getCustomField() or getCustomFields()) custom field(s)
     * @param bool $usePattern If call after getCustomField() - render field with pattern (if TRUE) or clean widget (if FALSE). For multiple fields (after getCustomFields()) widgets always render with pattern.
     * @return string
     */
    public function asHtml($usePattern = true)
    {
        if (count($this->customData) == 1)
            return $this->renderWidget($this->customData[0], $usePattern);

        $outputHtml = '';
        foreach ($this->customData as $customField)
            $outputHtml .= $this->renderWidget($customField);

        return $outputHtml;
    }

    /**
     * Set up pattern to render widgets and return itself
     * @param string $pattern String pattern
     * @return \CustomFieldsHelper
     */
    public function setPattern($pattern = false)
    {
        if ($pattern)
            $this->formWidgetPattern = $pattern;
        return $this;
    }

    /**
     * Set up pattern from fileto render widgets and return itself
     * @param string $pattern String pattern
     * @return \CustomFieldsHelper
     */
    public function setPatternMain($pattern = false)
    {

        if ($pattern) {
            $ci = &get_instance();
            ob_start();
            include realpath('templates/' . $ci->config->item('template') . '/shop') . '/' . $pattern . '.php';
            $pattern = ob_get_clean();
            $this->adminPatternDesc = $pattern;
        }

        return $this;
    }

    /**
     * Set up html (or text), avaliable while required widget render, and return itself
     * @param type $html
     * @return \CustomFieldsHelper
     */
    public function setRequiredHtml($html = '')
    {
        if ($html)
            $this->requiredHtml = $html;
        return $this;
    }

    /**
     * Render part of form with custom fields for Admin-area
     * @return strng
     */
    public function asAdminHtml()
    {
        $this->formWidgetPattern = &$this->adminPattern;
        return $this->asHtml();
    }

    //private methods

    private function prepareOptions()
    {
        if ($this->customData)
            foreach ($this->customData as $key => $customField)
                if ($customField['field_type_id'] == 2 && $customField['possible_values'] && is_array(unserialize($customField['possible_values']))) {
                    $this->customData[$key]['possible_values'] = array_combine(unserialize($customField['possible_values']), unserialize($customField['possible_values']));
                    if ($customField['options'] != 'multiple')
                        $this->customData[$key]['possible_values'][''] = 'none';
                } else
                    $this->customData[$key]['possible_values'] = array('' => 'none');

        return $this;
    }

    private function renderWidget($widget, $usePattern = true)
    {
        $inputHtml = '';
        switch ($widget['field_type_id']) {
            //render text input
            case 0:
            case 3:
                $inputHtml = form_input(array(
                    'name' => $this->baseWidgetName . '[' . $widget['id'] . ']',
                    'id' => $this->baseWidgetName . '_' . $widget['id'],
                    'value' => $widget['field_data'],
                    'class' => $widget['classes']
                ));
                break;

            //render textarea
            case 1:
                $inputHtml = form_textarea(array(
                    'name' => $this->baseWidgetName . '[' . $widget['id'] . ']',
                    'id' => $this->baseWidgetName . '_' . $widget['id'],
                    'value' => $widget['field_data'],
                    'class' => $widget['classes']
                ));
                break;

            //render select
            case 2:
                if ($widget['options'] == 'multiple')
                    $inputHtml = form_multiselect($this->baseWidgetName . '[' . $widget['id'] . ']', $widget['possible_values'], $widget['field_data'], 'id="' . $this->baseWidgetName . '_' . $widget['id'] . '" class="' . $widget['user_classes'] . '"');
                else
                    $inputHtml = form_dropdown($this->baseWidgetName . '[' . $widget['id'] . ']', $widget['possible_values'], $widget['field_data'] ?: '', 'id="' . $this->baseWidgetName . '_' . $widget['id'] . '" class="' . $widget['user_classes'] . '"');
                break;
        }


        //place input and label into pattern str. (or return clean input html)
        $data = array($inputHtml, $widget['field_label'], $this->baseWidgetName . '_' . $widget['id']);
        if (!$usePattern)
            return $inputHtml;

        if ($widget['field_description']) {
            $this->adminPattern = $this->adminPatternDesc;
            array_push($this->patternVariables, '{$description}');
            $desc = str_replace('{$description}', $widget['field_description'], $this->descHTML);
            array_push($data, $desc);
        }

        if ($widget['is_required']) {
            array_push($data, $this->requiredHtml);
            array_push($this->patternVariables, '{$requiredHtml}');
        } else
            array_push($data, '');


        $inp = str_replace($this->patternVariables, $data, $this->adminPatternDesc);
        // deleting template variables that was not set
        $inp = preg_replace('/\{\$[a-zA-Z]+\}/', '', $inp);
        if ($widget['field_type_id'] == 3)
            return str_replace(array('{btn_elfinder}', '{Id}'), array($this->btn_elfinder, $this->baseWidgetName . '_' . $widget['id']), $inp);
        else
            return str_replace(array('{btn_elfinder}', '{Id}'), array('', $this->baseWidgetName . '_' . $widget['id']), $inp);
    }

    public static function create()
    {
        (null !== self::$_BehaviorInstance) OR self::$_BehaviorInstance = new self();
        return self::$_BehaviorInstance;
    }

    /**
     * Coping custom-fields data from one product to another
     * @param int $productIdSource
     * @param int $productIdDest
     * @return boolean
     */
    public function copyProductCustomFieldsData($productIdSource, $productIdDest)
    {
        $productCSData = \CI::$APP->db
            ->select(array('field_id', 'field_data', 'custom_fields_data.locale'))
            ->join('custom_fields', 'custom_fields.id=custom_fields_data.field_id AND custom_fields.entity="product"')
            ->where(array('custom_fields_data.entity_id' => $productIdSource))
            ->get('custom_fields_data')
            ->result_array();

        if (count($productCSData) == 0) {
            return;
        }

        for ($i = 0; $i < count($productCSData); $i++) {
            $productCSData[$i]['entity_id'] = $productIdDest;
        }

        \CI::$APP->db->insert_batch('custom_fields_data', $productCSData);
        $error = \CI::$APP->db->_error_message();
        return !empty($error) ? false : true;
    }

}
