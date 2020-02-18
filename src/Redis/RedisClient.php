<?php


namespace Bloomfilter\Redis;


class RedisClient extends \Redis
{

    public static function getInstance($host = "127.0.0.1", $port = 6379, $password = "", $database = 0, $timeout = 0)
    {
        static $instance = null;
        if (!class_exists('Redis')) {
            return false;
        }
        if (!is_object($instance)) {
            $instance = new RedisClient();

            try {
                if ($instance->connect($host, $port, $timeout) == false) {
                    return false;
                }
                if (!empty($password)) {
                    if ($instance->auth($password) == false) {
                        return false;
                    }
                }
                $instance->select($database);
            } catch (\Exception $exception) {
                return false;
            }
        }
        return $instance;
    }
}