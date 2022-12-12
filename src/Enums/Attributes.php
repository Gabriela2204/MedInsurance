<?php
namespace App\Enums;

enum Attributes: string 
{
    case OnlyLetters = 'OnlyLetters';
    case Required = 'Required';
    case Email = 'Email';
}

?>