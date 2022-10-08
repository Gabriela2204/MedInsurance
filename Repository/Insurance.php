<?php
   namespace Repository\Insurance;
   use DatabaseConnection;
   
   define('ROOT', 'C:\xampp\htdocs\MedInsurance\\'); 
   require_once(ROOT.'DatabaseConnection.php');

   class Insurance{

    public function queryAndFetch($sql)
    {
        $db = DatabaseConnection::getInstance();
        $result = $db->prepare($sql);
        $result -> execute();
        $response= $result->fetchAll(\PDO::FETCH_ASSOC);

        return json_encode($response);
    }
    public function find($id){

        return $this->queryAndFetch('select * from insurances  where id='.$id);
    }

    public function findAll(){
       return $this->queryAndFetch('select * from insurances ');

    }
    
    public function insert($id, $id_type){
        
       
        return $this->queryAndFetch('insert into insurances(id, id_type) values ('.$id.','.$id_type.')');

    }

    public function delete($id){
       
        
        return $this->queryAndFetch('delete from insurances where id='.$id);
    }

    public function update($id,$newId_type){
         
        return $this->queryAndFetch('update insurances set id_type = '.$newId_type.'where id='.$id);

    }
 
   }
 
?>