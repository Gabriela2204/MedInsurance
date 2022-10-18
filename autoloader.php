<?php
spl_autoload_register(function($className) {
    

    include dirname( path: __FILE__).'\\'.$className.'.php';

});