<?php
//by hkieckbusch@redstage.com
//run this in magento main directory

//todo need to fix it

require_once('app/Mage.php');
ini_set('display_errors', 1);
Mage::app('admin');

$content = '';
$line1 = 'code;label-en_US;attributes;sort_order';
$content .= $line1 .'
';

$defaultAttributeSetId = Mage::getModel('eav/entity_attribute_set') //family
            ->getCollection()
            ->setEntityTypeFilter(4)
            ;
foreach($defaultAttributeSetId as $as){
    $dt = $as->getData();
    echo $dt['attribute_set_name'] . '<hr/>';
    //-------
    $groups = Mage::getModel('eav/entity_attribute_group')
                ->getResourceCollection()
                ->setAttributeSetFilter( $dt['attribute_set_id'] )
                ->setSortOrder()
                ->load();

    foreach ($groups as $node) {
        $dt2 = $node->getData();
        /*
  'attribute_group_id' => string '148' (length=3)
  'attribute_set_id' => string '19' (length=2)
  'attribute_group_name' => string 'General' (length=7)
  'sort_order' => string '1' (length=1)
  'default_id' => string '0' (length=1)
        */
        echo $dt2['attribute_group_name'].'['.$dt2['attribute_group_id'].'] ,';
        
    }
    echo '<hr/>';

}


die();


