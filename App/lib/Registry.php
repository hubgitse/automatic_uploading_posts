<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 19.08.2017
 * Time: 20:52
 */

namespace App\lib;


class Registry
{
    /**
     * @var array
     */
    private static $services = [];

    /**
     * @var bool
     */
    private static $readOnly = false;

    public static function setServiceOrParam($name, $obj)
    {

        if (self::$readOnly === true){
            throw new \RuntimeException('Registry for read only');
        }
        self::$services[$name] = $obj;
    }

    public static function getServiceOrParam($name)
    {

        if (!array_key_exists($name, self::$services)) {
            throw new \InvalidArgumentException();
        }
        return self::$services[$name];
    }

    public static function readOnly()
    {
        self::$readOnly = true;
    }

}