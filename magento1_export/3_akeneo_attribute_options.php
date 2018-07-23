<?php
//by hkieckbusch@redstage.com
//run this in magento main directory

require_once('app/Mage.php');
ini_set('display_errors', 1);
Mage::app('admin');

$content = '';
$line1 = 'code;label-en_US;attribute;sort_order';
$content .= $line1 .'
';
$types = explode(';',$line1);
$collection = Mage::getModel('eav/entity_attribute')->getCollection()->addFieldToFilter('entity_type_id', 4 );
$seq = 0;
$t = '';
foreach ($collection as $item){
    if($item->getSourceModel()){
        $data = $item->getData();
        $options = $item->getSource()->getAllOptions();
        
        if($t != $data['attribute_code']){
            $t = $data['attribute_code'];
            $seq = 0;
        }
        foreach($options as $opt){

            $label = str_replace(';','',$opt['label']);
            $label = str_replace('
','',$label);

            $content .= $data['attribute_code'].'_'.$opt['value'].';'.
                $label . ';'.$data['attribute_code'].';'.$seq;
            $content .= '
';
            $seq++;
        }   
    }
}

$file = '3_akeneo_attribute_options.csv';
file_put_contents($file,$content);
echo $file . ' generated.';
die();
