<?php
//by hkieckbusch@redstage.com
//run this in magento main directory

require_once('app/Mage.php');
ini_set('display_errors', 1);
Mage::app('admin');

$headers = [
    'code',
    'label-en_US',
    'allowed_extensions',
    'auto_option_sorting',
    'available_locales',
    'date_max',
    'date_min',
    'decimals_allowed',
    'default_metric_unit',
    'group;localizable',
    'max_characters',
    'max_file_size',
    'metric_family',
    'minimum_input_length',
    'negative_allowed',
    'number_max',
    'number_min',
    'reference_data_name',
    'scopable',
    'sort_order',
    'type',
    'unique',
    'useable_as_grid_filter',
    'validation_regexp',
    'validation_rule',
    'wysiwyg_enabled'
];

$file = new SplFileObject('2_akeneo_attribute_import.csv', 'w');
$file->fputcsv($headers, ';', '"', '"');

/** @var Mage_Eav_Model_Entity_Attribute $model */
$model = Mage::getModel('eav/entity_attribute');

/** @var Mage_Eav_Model_Resource_Entity_Attribute_Collection $collection */
$collection = $model->getCollection()->addFieldToFilter('entity_type_id', 4 );

$sql = $collection->getSelect();
$connection = $collection->getConnection();

$statement = $connection->query($sql);

foreach ($statement as $item) {
    $model->load($item['attribute_id']);

    $line = [];
    foreach ($headers as $header) {
        switch ($header) {
            case 'type':
                switch($data['frontend_input']){
                    case 'text':
                        $line[$header] = null;
                        break;
                        
                    case 'textarea':
                        $line[$header] = 'pim_catalog_textarea';
                        break;
                        
                    case 'price':
                        $line[$header] = 'pim_catalog_number';
                        break;
                        
                    case 'date':
                        $line[$header] = 'pim_catalog_date';
                        break;
                        
                    case 'weight':
                        $line[$header] = 'pim_catalog_number';
                        break;
                    case 'select':
                        $line[$header] = 'pim_catalog_simpleselect';
                        break;
                        
                    case 'media_image':
                        $line[$header] = 'pim_catalog_image';
                        break;
                        
                    case 'gallery':
                        $line[$header] = 'pim_catalog_image';
                        break;
                        
                    case 'boolean':
                        $line[$header] = 'pim_catalog_boolean';
                        break;
                        
                    case 'multiselect':
                        $line[$header] = 'pim_catalog_multiselect';
                        break;
                        
                    case '':
                        $line[$header] = null;
                        break;
                        
                    default:
                        die('ERROR: '.$data['frontend_input'].' CHECK LINE: '.__LINE__);
                        break;
                }
                break;
                
            case 'code':
                $line[$header] = $data['attribute_code'];
                break;
                
            case 'label-en_US':
                $line[$header] = $data['frontend_label'];
                break;
                
            case 'useable_as_grid_filter':
                $line[$header] = $data['attribute_code'] == 'sku' ? '1' : '0';
                break;
                
            default:
                $line[$header] = null;
                break;
        }
    }

    $file->fputcsv(array_values($line), ';', '"', '"');
}
