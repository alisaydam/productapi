<?php

namespace App\Controllers;

use App\Models\Product; 
use Database\DBConnection; 
 
class ProductsController  {

    public function __construct(DBConnection $db)
    { 
        $this->db = $db;
    }

    public function welcome()
    { 
        echo "Wellcome to the product api";
    }
  
    public function index()
    { 
        $products = (new Product($this->getDB()))->all(); 
    }
  
    public function create()
    { 
        $request =  file_get_contents("php://input"); 
        $decodedArray = json_decode($request, true);  
        $product = $this->model(ucfirst($decodedArray['productType'])); 
        $withAttribute = $product->add($decodedArray); 
         $product->create($withAttribute);
        
    }

    
    public function delete()
    { 
        $request =  file_get_contents("php://input"); 
        $assocArray = json_decode($request); 
        $product = new Product($this->getDB());
        $product->delete($assocArray->ids);
 
    }
    protected function getDB()
    {
        return $this->db;
    }

     public function model(string $modelName)
    {
        $model = 'App\\Models\\' . $modelName; 
 
        return new $model($this->getDB());
    }
   
 
}
