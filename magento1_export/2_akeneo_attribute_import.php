<?php
//by hkieckbusch@redstage.com
//run this in magento main directory

require_once('app/Mage.php');
ini_set('display_errors', 1);
Mage::app('admin');

$content = '';
$line1 = 'code;label-en_US;allowed_extensions;auto_option_sorting;available_locales;date_max;date_min;decimals_allowed;default_metric_unit;group;localizable;max_characters;max_file_size;metric_family;minimum_input_length;negative_allowed;number_max;number_min;reference_data_name;scopable;sort_order;type;unique;useable_as_grid_filter;validation_regexp;validation_rule;wysiwyg_enabled';
$content .= $line1 .'
';

$types = explode(';',$line1);
$collection = Mage::getModel('eav/entity_attribute')->getCollection()->addFieldToFilter('entity_type_id', 4 );

foreach ($collection as $item){
    $data = $item->getData();
    
    foreach($types as $i){
    	switch($i){
    		case 'type':
    			switch($data['frontend_input']){
    				case 'text':
    				break;
    				case 'textarea':
    					$content .= 'pim_catalog_textarea';
    				break;
    				case 'price':
    					$content .= 'pim_catalog_number';
    				break;
    				case 'date':
    					$content .= 'pim_catalog_date';
    				break;
    				case 'weight':
    					$content .= 'pim_catalog_number';
    				break;
    				case 'select':
    					$content .= 'pim_catalog_simpleselect';
    				break;
    				case 'media_image':
    					$content .= 'pim_catalog_image';
    				break;
    				case 'gallery':
    					$content .= 'pim_catalog_image';
    				break;
    				case 'boolean':
    					$content .= 'pim_catalog_boolean';
    				break;
    				case 'multiselect':
    					$content .= 'pim_catalog_multiselect';
    				break;
    				case '':
    				break;
    				default:
    				die('ERROR: '.$data['frontend_input'].' CHECK LINE: '.__LINE__);
    				break;
    			}
    			
    		break;
    		case 'code':
    			$content .= $data['attribute_code'];
    		break;
    		case 'label-en_US':
    			$content .= $data['frontend_label'];
    		break;
    		case 'useable_as_grid_filter':
    			if($data['attribute_code'] == 'sku'){
    				$content .= 1;
    			}else{
					$content .= 0;
    			}
    		break;
    		default:
    		break;
    	}
    	$content .= ';';
    }
    $content .= '
';

}

$file = '2_akeneo_attribute_import.csv';
file_put_contents($file,$content);
echo $file .' generated';
