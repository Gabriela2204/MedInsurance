<?php
namespace App\Entity;

use App\Attribute\Required;
use App\Attribute\Email;

class User
{
    public ?int $id_insurer;
    #[Required]
    public ?string $name;
    #[Required,Email]
    public ?string $mail;
    #[Required]
    public ?string $password;
    public ?int $is_admin;

    public function __construct(int $id_insurer = NULL, string $name = NULL ,string $mail = NULL ,string $password = NULL, int $is_admin = NULL)
    {
      $this->id_insurer = $id_insurer;
      $this->name = $name;
      $this->mail = $mail;
      $this->password = $password;
      $this->is_admin = $is_admin;
    }
}

?>