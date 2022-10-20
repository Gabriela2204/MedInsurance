<?php

namespace App\Repository;
use  App\DatabaseConnection;

trait BaseRepository{

    public function queryAndFetch($sql)
    {
        $db = DatabaseConnection::getInstance();
        if($db != null)
       { $result = $db->prepare($sql);
        $result -> execute();
        $response= $result->fetchAll(\PDO::FETCH_ASSOC);
        return $response;}

        
    }

    public function findAll($table){
        return $this->queryAndFetch('select * from '.$table);
 
     }

     public function find($id, $table){

        return $this->queryAndFetch('select * from '.$table.'where id='.$id);
    }

    public function delete($id, $table){
       
        
        return $this->queryAndFetch('delete from '.$table.' where id='.$id);
    }
}

?>