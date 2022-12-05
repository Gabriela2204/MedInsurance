<?php
namespace App\Repository;

class User extends BaseRepository
{
   public function searchEmail(string $email)
   {
      return $this->queryAndFetch("Select count(*) as number from user where mail = '".$email."'");
   }

   public function searchEmailPassword(string $email)
   {
      return $this->queryAndFetch("Select password from user where mail = '".$email."'");
   }
}

?>