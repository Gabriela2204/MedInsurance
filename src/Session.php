<?php
namespace App;

class Session
{
    public function __construct()
    {
        session_start();
    }
    public function setValue(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public function getValue(string $key)
    {
        return $_SESSION[$key];
    }

    public function verifyIfIsset(string $key)
    {
        return isset($_SESSION[$key]);
    }

    public function unsetVariable(string $key)
    {
        unset($_SESSION[$key]);
    }

}

?>