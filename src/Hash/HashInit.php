<?php


namespace Bloomfilter\Hash;


class HashInit
{
    private $init;

    public function __construct($init)
    {
        $this->init = $init;
    }

    public function getBloomValues()
    {
        if (strtolower($this->init->getParams('hashFunction')) == 'md5') {
            return $this->getMD5();
        }
    }

    private function getMD5()
    {
        $data = $this->init->getParams('data');
        $result = [];
        if (is_array($data)) {
            foreach ($data as $datum) {
                $result[] = [
                    'data' => $datum,
                    'value' => new Md5($datum, $this->init->getParams('salts'))
                ];
            }
        } else {
            $result[] = [
                'data' => $data,
                'value' => new Md5($data, $this->init->getParams('salts'))
            ];
        }
        return $result;
    }
}