<?php

namespace App;


class Validater{
    
    public function validateLetters(string $var){

        if (ctype_alpha(str_replace(' ', '', $var)) === false) 
           return 1;
        return 0;
      }

    public function validate(object $object) {
 
     
        $reflect = new \ReflectionClass($object);
        $properties = $reflect->getProperties();
        foreach ($properties as $property) {
         
            $propertyReflect = new \ReflectionProperty($object,$property->getName());
            $attributes = $propertyReflect->getAttributes();
            $propertyName= $property->getName();
            foreach($attributes as $attribute){
                
            $attr=ltrim($attribute ->getName(),"App\Attribute");

            if($attr === 'Required' && $object->$propertyName == null)
               {
                   return "Please fill the boxes";
                     
               } 
            if($attr == 'OnlyLetters' && $this->validateLetters($object->$propertyName) == 1)
            {
                return "Use just letters";   
            }

            }
       
        }
    }

}

?>