<?php

namespace App\Repository;
use  App\DatabaseConnection;
use ReflectionClass;

class BaseRepository{

    private $tableName;

    public function __construct()
    {
        $this->tableName = strtolower(ltrim(get_called_class(),"App\Repository"));
    }

    public function queryAndFetch($sql)
    {

        $db = DatabaseConnection::getInstance();
        if($db != null)
       { 
        $result = $db->prepare($sql);
        $result -> execute();
        $response= $result->fetchAll(\PDO::FETCH_CLASS,"App\Entity\\".ucfirst($this->tableName));
        return $response;
    }
 
    }

    public function getClassProperties(){
        $reflect = new ReflectionClass("App\Entity\\".ucfirst($this->tableName));
        $props = $reflect->getProperties();
        $string="";
        foreach ($props as $prop) {
            $string = $string.$prop->getName().',';
        }
        
        return rtrim($string,',');
    }

    public function findAll(){
        
        return $this->queryAndFetch('select * from '.$this->tableName);
 
     }

     public function find($id){

        return $this->queryAndFetch('select * from '.$this->tableName.'where id=:'.$id);
    }

    public function delete($id){
       
        
        return $this->queryAndFetch('delete from '.$this->tableName.' where id=:'.$id);
    }


    public function insert($object){

        $properties = $this->getClassProperties();
        echo $properties;
        
        // return $this->queryAndFetch('insert into'.$this->tableName.'('.$string.') values ('.$object->getId().','.$object->getId_Type().')');
    }
}

?>