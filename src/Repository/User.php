<?php
namespace App\Repository;

class User extends BaseRepository
{
   public function verifyEmail(string $email)
   {
      return $this->queryAndFetch("SELECT count(*) AS number FROM user WHERE mail = ?",[$email]);
   }

   public function getPassword(string $email)
   {
      return $this->queryAndFetchForOne("SELECT password FROM user WHERE mail = ?",[$email]);
   }
   public function getUserByEmail(string $email)
   {
      return $this->queryAndFetchForOne("SELECT id_insurer,name,is_admin,mail FROM user WHERE mail = ?",[$email]);
   }
}

?>