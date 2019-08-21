<?php
  include_once("Basket.class.php");

	$basket = new Basket;
	$basket->addProduct('B01');
	$basket->addProduct('B01');
	$basket->addProduct('R01');
	$basket->addProduct('R01');
	$basket->addProduct('R01');
	$basket->addProduct('R01');
	echo '<pre>List of products<br>';
	print_r($basket->fetchAllProducts());
	$basket->removeProduct('R01');
	echo '<pre>List of products after removal of one R01<br>';
	print_r($basket->fetchAllProducts());
	echo 'Total: '.$basket->getTotal();

