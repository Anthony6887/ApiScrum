<?php

class Conexion
{
    public static function Conectar()
    {
        if (!defined('host')) {
            define('host', 'localhost');
            define('bd', 'pruebas');
            define('usuario', 'root');
            define('contrasenia', '');
        }

        $conectar = new PDO('mysql:host=' . host . ";dbname=" . bd, usuario, contrasenia);
        return $conectar;
    }
}
