<?php

require_once 'Product.Class.php';


class ProductController{

	public function create(){
		sleep(1);


		echo '{"code":1}';
	}

	public function read(){

		sleep(1);


		echo '{"code":1,"name":"Aparador de grama 123","price": 23.99,"description":"fdasfdfd fdasfdfdsfdas fadsfasdfadsfasdf asfsdfadsfads fdasfdsfds"}';
		
	}

	public function search(){

		sleep(1);

		echo '{"totalItems":2, "products":[{"code":1, "name":"Aparador de grama 123"}, {"code":2, "name":"Gel para barbear"}]}';
		
	}

	public function update(){
		sleep(1);


		echo '{"code":1}';
		
	}

	public function delete(){
		
	}

}