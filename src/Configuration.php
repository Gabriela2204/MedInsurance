<?php

namespace App;


class Configuration{


    public static function getConstantByKey(string $key): string
    {
        $const = json_decode(file_get_contents('src\Constants.json'), true);
         return $const[$key];
        
    }


}

?>