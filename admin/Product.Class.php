<?php

class Product{
	public $id;
	public $name;
	public $price;
	public $stock;
	public $description;

	private $conn;
	private $error;

	public function __construct($conn){
		$this->conn = $conn;
	}

	public function getError(){
		return $this->error;
	}

	public function create(){

		$query =	"INSERT INTO products (name, price, stock, description) " .
					"VALUES (:name, :price, :stock, :description)";

		$stmt = $this->conn->prepare($query);
	 
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->description = htmlspecialchars(strip_tags($this->description));
	 
		$stmt->bindParam(":name", $this->name);
		$stmt->bindParam(":price", $this->price);
		$stmt->bindParam(":stock", $this->stock);
		$stmt->bindParam(":description", $this->description);
		 
		if($stmt->execute()){
			$this->id = $this->conn->lastInsertId();
			return true;
		}else{
			$this->error = $stmt->errorInfo();	 
			return false;
		}

	}


	public function update(){

		$query =	"UPDATE products " . 
					"SET name = :name, " .
					"price = :price, " . 
					"stock = :stock, " . 
					"description = :description " .
					"WHERE id = :id";

		$stmt = $this->conn->prepare($query);
	 
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->description = htmlspecialchars(strip_tags($this->description));
	 
		$stmt->bindParam(":id", $this->id);
		$stmt->bindParam(":name", $this->name);
		$stmt->bindParam(":price", $this->price);
		$stmt->bindParam(":stock", $this->stock);
		$stmt->bindParam(":description", $this->description);
		 
		if($stmt->execute()){
			return true;
		}else{
			$this->error = $stmt->errorInfo();	 
			return false;
		}

	}


	public function read(){

		$query =	"SELECT * FROM products WHERE id = :id";

		$stmt = $this->conn->prepare($query);
	 
		$stmt->bindParam(":id", $this->id);
		 
		if($stmt->execute()){
			if($row = $stmt->fetch(PDO::FETCH_OBJ)){
				$this->id = $row->id;
				$this->name = $row->name;
				$this->price = $row->price;
				$this->stock = $row->stock;
				$this->description = $row->description;
				return true;
			} else {
				$this->error = 'Produto não encontrado.';
				return false;
			}
		}else{
			$this->error = $stmt->errorInfo();	 
			return false;
		}

	}


	public function readByContext($id, $name, $page){

		$query =	"SELECT SQL_CALC_FOUND_ROWS id, name, price, stock FROM products ";
		$where =	"";
		
		$id = (int)$id;
		if($id > 0){
			$where .= (strlen($where) > 0 ? ' AND ' : '') . "id = :id";
		}

		if($name != null && $name != ''){
			$name = '%' . $name . '%';
			$where .= (strlen($where) > 0 ? ' AND ' : '') . "name = :name";
		}

		define('PRODUCTS_PER_PAGE', 20);
		$page = (int)$page;
		$pageMax = $page * PRODUCTS_PER_PAGE;
		$pageMin = $pageMax - PRODUCTS_PER_PAGE;

		$query .= $where . ' LIMIT ' . $pageMin . ',' . $pageMax . ' ; SELECT FOUND_ROWS() AS total;';

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":id", $id);
		$stmt->bindParam(":name", $this->name);
		 
		if($stmt->execute()){
			$totalItems = 0;
			$products = [];
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$row['price'] = str_replace('.', ',', number_format($row['price'], 2));
				array_push($products, $row);
			}
			if($stmt->nextRowset()){
				if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					$totalItems = (int)$row['total'];
				}
			}

			return json_decode('{"totalItems":' . $totalItems . ',"products":' . json_encode($products) . '}');
		}else{
			$this->error = $stmt->errorInfo();	 
			return false;
		}

	}

}