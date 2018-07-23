<?php
//by hkieckbusch@redstage.com
//run this in magento main directory

//todo: not 100% yet

require_once('app/Mage.php');
ini_set('display_errors', 1);
Mage::app('admin');

$content = '';
$line1 = 'code;label-en_GB;attributes;attribute_as_image;attribute_as_label;requirements-ecommerce';
/*
$content .= $line1 .'
';
*/


$defaultAttributeSetId = Mage::getModel('eav/entity_attribute_set') //family
            ->getCollection()
            ->setEntityTypeFilter(4)
            //->addFieldToFilter('attribute_set_name', $attributeSetName)
            ;
foreach($defaultAttributeSetId as $as){
    var_dump(
        $as->getData()   
    );
}
die();
