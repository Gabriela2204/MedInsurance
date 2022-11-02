<?php

namespace App\Repository;
use  App\DatabaseConnection;


class BaseRepository{

    private string $tableName;

    public function __construct()
    {
        $this->tableName = strtolower(ltrim(get_called_class(),"App\Repository"));
    }

    public function queryAndFetch(string $sql): ?array
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

    public function getClassProperties():string {
        echo $this->tableName;
        $reflect = new \ReflectionClass("App\Entity\\".ucfirst($this->tableName));
        $props = $reflect->getProperties();
        $string="";
        foreach ($props as $prop) {
            $string = $string.$prop->getName().',';
        }
        
        return rtrim($string,',');
    }

    public function getClassValues($object):string {
        $reflect = new \ReflectionClass($object);
        $props = $reflect->getProperties();
        $string="";
        foreach ($props as $prop) {   
            if(gettype($prop->getValue($object)) === "string")    
            $string=$string."\"".$prop->getValue($object)."\"".',';
            else
            $string=$string.$prop->getValue($object).',';
        }
        
        return rtrim($string,',');
    } 

    public function findAll(): ?array{
        
        return $this->queryAndFetch('select * from '.$this->tableName);
 
     }

     public function findBy(int $id): ?array{

        return $this->queryAndFetch('select * from '.$this->tableName.'where id=:'.$id);
    }

    public function delete(int $id): ?array{
       
        
        return $this->queryAndFetch('delete from '.$this->tableName.' where id=:'.$id);
    }


    public function insert($object): ?array{

        $properties = $this->getClassProperties();
        $values = $this->getClassValues($object);
       
         
        return $this->queryAndFetch('insert into '.$this->tableName.'('.$properties.') values ('.$values.')');
    }
}

?>