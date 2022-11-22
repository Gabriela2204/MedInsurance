<?php

namespace App;
use App\Enums\Attributes;

class Validater
{
    public function validateLetters(string $var)
    {
        if (ctype_alpha(str_replace(' ', '', $var)) === false) 
           return 1;
        return 0;
    }

    public function validateEmail(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 0;
        }
        return 1;
    }

    public function validate(object $object)
    {
        $reflect = new \ReflectionClass($object);
        $properties = $reflect->getProperties();
        $error =array();
        foreach ($properties as $property) {
            $propertyReflect = new \ReflectionProperty($object,$property->getName());
            $attributes = $propertyReflect->getAttributes();
            $propertyName= $property->getName();
            foreach ($attributes as $attribute) {
                $attr=ltrim($attribute->getName(),"App\Attribute");
                if ($attr == Attributes::Required->value  && $object->$propertyName == null) {
                   array_push($error, 'Fill the '.$propertyName.' box');
                } 
                if($attr == Attributes::OnlyLetters->value && $this->validateLetters($object->$propertyName) == 1){
                array_push($error,'Use just letters for '.$propertyName);        
                } 
                if($attr == Attributes::Email->value && $this->validateEmail($object->$propertyName) == 1){
                    array_push($error,'Format is wrong for '.$propertyName);        
                }
            }
        }
        return $error;
    }

}

?>