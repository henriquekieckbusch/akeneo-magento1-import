<?php
//by hkieckbusch@redstage.com
//run this in magento main directory

//todo: need to fix

require_once('app/Mage.php');
ini_set('display_errors', 1);
Mage::app('admin');

$collection = Mage::getModel('catalog/product')->getCollection()
->addAttributeToSelect('*')
->setPageSize(10)
->setCurPage(1); 

foreach ($collection as $product) {
  
  var_dump(
	$product->getData()
  );
  die();
  
  foreach ($product->getCategoryIds() as $category_id) {
      $category = Mage::getModel('catalog/category')->load($category_id);
      /*
      echo $category->getName();
      echo $category->getParentCategory()->getName(); 
      */
  }
  
 
}
