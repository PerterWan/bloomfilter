<?php


namespace Bloomfilter\Hash;


use Bloomfilter\config\BFException;

class Md5
{
    private $data;
    private $salts = [];

    public function __construct($data, $salts = [])
    {
        if (empty($data)) {
            throw new BFException();
        }
        $this->data = $data;

        if (count($salts) < 3) {
            throw new BFException();
        }
        $this->salts = array_values($salts);
    }

    public function getBloomValues()
    {
        $saltsLen = count($this->salts);
        $bloomValues = [];
        for ($i = 0; $i < $saltsLen; $i++) {
            $bloomValues[] = base_convert(md5($this->data, $this->salts[$i]), 16, 10);
        }
        return $bloomValues;
    }
}