<?php


namespace Bloomfilter;


use Bloomfilter\config\BFException;
use Bloomfilter\config\Constants;
use Bloomfilter\Hash\HashInit;
use Bloomfilter\Redis\RedisBloomFilter;

class BloomFilter
{


    private $hashFunction;
    private $data;
    private $salts;
    private $bloomValues;

    /**
     * BloomFilter constructor.
     * @param string $hashFunction
     * @param $data
     * @param array $salts
     */
    public function __construct($hashFunction = Constants::HASH_FUNCTION_MD5, $data, array $salts)
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

    /**
     * @param string $redisKey
     * @param string $host
     * @param int $port
     * @param string $password
     * @param int $timeout
     * @param int $db
     * @return RedisBloomFilter
     */
    public function redis($redisKey = Constants::SCENES_REDIS_KEY, $host = Constants::SCENES_REDIS_HOST, $port = Constants::SCENES_REDIS_PORT, $password = Constants::SCENES_REDIS_PASSWORD, $timeout = Constants::SCENES_REDIS_TIMEOUT, $db = Constants::SCENES_REDIS_DB)
    {
        empty($redisKey) ? $redisKey = Constants::SCENES_REDIS_KEY : true;
        $redisConfig = ['host' => $host, 'port' => $port, 'password' => $password, 'timeout' => $timeout, 'db' => $db, 'redisKey' => $redisKey];
        return new RedisBloomFilter($this, $redisConfig);
    }

    /**
     * @param $fileName
     * @param $filePath
     */
    public function file($fileName, $filePath)
    {
        if (!is_dir($filePath))
            mkdir($filePath, 0777, true);

        $fullPath = $filePath . DIRECTORY_SEPARATOR . $fileName;
        if (!file_exists($fullPath))
            touch($fullPath);
    }
}