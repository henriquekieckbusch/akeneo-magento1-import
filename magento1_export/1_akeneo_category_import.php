<?php
//by hkieckbusch@redstage.com
//run this in magento main directory
require("app/Mage.php"); 
Mage::app();   

$categories = Mage::getModel('catalog/category')
              ->getCollection()
              ->addAttributeToSelect('*')
              ->addIsActiveFilter();

 $export_file = "1_akeneo_category_import.csv"; 
 $export = fopen($export_file, 'w') or die("Permissions error."); 
 $output = "";
 $output = "code;label-en_US;parent\r\n"; 
 fwrite($export, $output);

 foreach ($categories as $category) {
     $output = ""; 
     $output .= $category->getId().';'; 
     $output .= '"'.$category->getName().'";';

    $_parent = '';
    foreach ($category->getParentCategories() as $parent) 
       if($_parent == '' && $parent->getId() != $category->getId()) 
        $_parent = $parent->getId();
    
$output .= $_parent;
     
     $output .= "\r\n"; 
     fwrite($export, $output); 
 }
 fclose($export); 
 
 echo  $export_file . ' generated.';
