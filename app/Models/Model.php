<?php

namespace App\Models;

use PDO;
use Database\DBConnection;

abstract class Model {
 
    protected $db;
    protected $table;

    public function __construct(DBConnection $db)
    {
        $this->db = $db;
    }
    public function all(): array
    {
        $products = $this->db->getPDO()->prepare("SELECT * FROM {$this->table} ORDER BY sku DESC"); 
        $products->execute();  
        $all = $products->fetchAll();
        echo json_encode($all);
        return $all; 
    }
 
    public function create(array $request) 
    { 
       //* Create query
       $query = "INSERT INTO " . $this->table . " SET sku = :sku, name = :name, price = :price, 
        attribute = :attribute, productType = :productType";
     
       //* Prepare Statement
       $stmt = $this->db->getPDO()->prepare($query);
     
       //* Bind data
       $stmt->bindParam(":sku", $request['sku']);
       $stmt->bindParam(":name", $request['name']);
       $stmt->bindParam(":price", $request['price']);
       $stmt->bindParam(":productType", $request['productType']);
       $stmt->bindParam(":attribute", $request['attribute']);
     
     
      //* Check if success 
      try { 
        $stmt->execute();
        echo json_encode(
            array("success" => true, "message" => "created")
        ); 
      } catch (\Throwable $th) {
        echo json_encode(
            array("success" => false, "message" => "Err: SKUs must be uniqe")
        ); 
      } 
    }
 
    public function delete(array $request)
    {  
        //* Prepare query
        $ids = implode(',', $request);
        $query = ("DELETE FROM {$this->table} WHERE id IN ($ids)");
        $stmt = $this->db->getPDO()->prepare($query); 

        //* Execute
        if ($stmt->execute()) {
            echo json_encode(
                array("success" => true, "message" => "Deleted")
            ); 
            return true;
        }
        echo json_encode(
            array("success" => false, "message" => "Could not deleted")
        ); 
        return false;
    }  
}
