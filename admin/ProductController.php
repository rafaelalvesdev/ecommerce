<?php

require_once 'Product.Class.php';
require_once 'Connection.Class.php';


class ProductController{

	public function create(){

		$product = new Product(Connection::getConn());

		$objProduct = json_decode(file_get_contents("php://input")); 

		if(property_exists($objProduct, 'name'))
			$product->name = $objProduct->name;

		if(property_exists($objProduct, 'price'))
			$product->price = $objProduct->price;

		if(property_exists($objProduct, 'stock'))
			$product->stock = $objProduct->stock;

		if(property_exists($objProduct, 'description'))
			$product->description = $objProduct->description;

		if($product->create()){
			echo json_encode($product);
		} else {
			echo '{"error":' . json_encode($product->getError()) . '}';
		}

	}

	public function read(){

		$product = new Product(Connection::getConn());

		if(isset($_REQUEST['id']))
			$product->id = (int)$_REQUEST['id'];

		if($product->read()){
			echo json_encode($product);
		} else {
			echo '{"error":' . json_encode($product->getError()) . '}';
		}
		
	}

	public function search(){

		$id = 0;
		$name = '';
		$page = 1;

		$product = new Product(Connection::getConn());

		if(isset($_REQUEST['id']))
			$id = (int)$_REQUEST['id'];

		if(isset($_REQUEST['name']))
			$name = $_REQUEST['name'];

		if(isset($_REQUEST['page']))
			$page = (int)$_REQUEST['page'];

		$searchResult = $product->readByContext($id, $name, $page);

		if($searchResult !== false){
			echo json_encode($searchResult);
		} else {
			echo '{"error":"Ocorreu um erro ao pesquisar os produtos."}';
		}
		
	}

	public function update(){

		$product = new Product(Connection::getConn());

		$objProduct = json_decode(file_get_contents("php://input")); 
		
		if(property_exists($objProduct, 'id'))
			$product->id = $objProduct->id;

		if($product->id <= 0){
			echo '{"error":"Produto não informado."}';
		}
		
		if(property_exists($objProduct, 'name'))
			$product->name = $objProduct->name;

		if(property_exists($objProduct, 'price'))
			$product->price = $objProduct->price;

		if(property_exists($objProduct, 'stock'))
			$product->stock = $objProduct->stock;

		if(property_exists($objProduct, 'description'))
			$product->description = $objProduct->description;

		if($product->update()){
			echo json_encode($product);
		} else {
			echo '{"error":' . json_encode($product->getError()) . '}';
		}
		
	}

	public function delete(){
		
	}

}