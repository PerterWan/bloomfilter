<?php


namespace Bloomfilter\Redis;


class RedisBloomFilter
{
    private $init;
    private $redis = [];

    public function __construct($init, $redis = [])
    {
        $this->init = $init;
        $this->redis = $redis;
    }

    private function getRedis()
    {
        return RedisClient::getInstance($this->redis['host'], $this->redis['port'], $this->redis['password'], $this->redis['database'], $this->redis['timeout']);
    }


    public function setBloomFilter()
    {
        $redis = $this->getRedis();
        foreach ($this->init->getParams("bloomValues") as $param) {
            foreach ($param['value'] as $item) {
                $offset = $item % pow(2, 32);
                $redis->setBit($this->redis['redisKey'], $offset, 1);
            }
        }
    }

    public function isExistsBloomFilter()
    {
        $redis = $this->getRedis();
        $result = [];
        foreach ($this->init->getParams("bloomValues") as $param) {
            $result[$param['data']] = true;
            foreach ($param['value'] as $item) {
                $offset = $item % pow(2, 32);
                if (!$redis->getBit($this->redis['redisKey'], $offset)) {
                    $result[$param['data']] = false;
                }
            }
        }
        return $result;
    }
}