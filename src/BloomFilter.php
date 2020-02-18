<?php


namespace Bloomfilter;


use Bloomfilter\config\BFException;
use Bloomfilter\config\Scenes;
use Bloomfilter\Hash\HashInit;
use Bloomfilter\Redis\RedisBloomFilter;

class BloomFilter
{


    private $hashFunction;
    private $data;
    private $salts;
    private $bloomValues;

    public function __construct($hashFunction = "MD5", $data, array $salts)
    {
        $this->hashFunction = $hashFunction;
        $this->data = $data;
        $this->salts = $salts;
        $this->getBloomValue();
    }

    /**
     * 获取参数
     * @param $key
     * @return mixed
     */
    public function getParams($key)
    {
        return $this->$key;
    }

    private function getBloomValue()
    {
        $hashInit = new HashInit($this);
        $this->bloomValues = $hashInit->getBloomValues();
    }

    public function getPlat($scenes, $client)
    {
        if (!in_array($scenes, [Scenes::SCENES_REDIS, Scenes::SCENES_FILE])) {
            throw new BFException();
        }
        switch ($scenes) {
            case Scenes::SCENES_REDIS:
                $obj = $this->redisBloomFilter($client);
                break;
            case Scenes::SCENES_FILE:
                $obj = $this->fileBloomFilter();
                break;
            default:
                $obj = "";
                break;
        }
        return $obj;
    }

    private function redisBloomFilter($client)
    {
        return new RedisBloomFilter($this, $client);
    }

    private function fileBloomFilter()
    {
        return "";
    }
}