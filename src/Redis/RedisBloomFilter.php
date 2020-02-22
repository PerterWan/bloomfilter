<?php


namespace Bloomfilter\Redis;


use Bloomfilter\config\Constants;

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
        return RedisClient::getInstance($this->redis['host'], $this->redis['port'], $this->redis['password'], $this->redis['db'], $this->redis['timeout']);
    }


    public function setBloomFilter($ram = Constants::SCENES_REDIS_BITMAP_128)
    {
        $redis = $this->getRedis();
        switch ($ram) {
            case Constants::SCENES_REDIS_BITMAP_256:
                $ramOffset = pow(2, 31);
                break;
            case Constants::SCENES_REDIS_BITMAP_512:
                $ramOffset = pow(2, 32);
                break;
            case Constants::SCENES_REDIS_BITMAP_128:
            default:
                $ramOffset = pow(2, 30);
                break;
        }
        foreach ($this->init->getParams("bloomValues") as $param) {
            foreach ($param['value'] as $item) {
                $offset = $item % $ramOffset;
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