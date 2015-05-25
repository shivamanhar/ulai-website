<?php 

 use Base\CustomFieldsData as BaseCustomFieldsData;



/**
 * Skeleton subclass for representing a row from the 'custom_fields_data' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Shop
 */
class CustomFieldsData extends BaseCustomFieldsData {
    
    public function renderPartOfFormWithCustomFields($entityId)
    {
        $customFields = CustomFieldsQuery::create()->find();
        
        $customFieldsHtml = '';
        $widgetHelper = new CustomFieldsWidgetHelper();
        foreach ($customFields as $field)
        {
            $customFieldsHtml .= $widgetHelper->renderWidget($entityId, $field->getId());
        }
        
        return $customFieldsHtml;
    }


} // CustomFieldsData
