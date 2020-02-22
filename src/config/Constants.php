<?php


namespace Bloomfilter\config;


class Constants
{
    /**
     * 场景：REDIS
     */
    const SCENES_REDIS = 'redis';

    /**
     * 场景：REDIS 默认KEY
     */
    const SCENES_REDIS_KEY = 'BLOOM-FILTER';

    /**
     * 场景：REDIS 默认配置
     */
    const SCENES_REDIS_HOST = '127.0.0.1';
    const SCENES_REDIS_PORT = 6379;
    const SCENES_REDIS_PASSWORD = '';
    const SCENES_REDIS_TIMEOUT = 0;
    const SCENES_REDIS_DB = 0;


    const SCENES_REDIS_BITMAP_128 = "128";
    const SCENES_REDIS_BITMAP_256 = "256";
    const SCENES_REDIS_BITMAP_512 = "512";

    /**
     * 场景：文件
     */
    const SCENES_FILE = 'file';

    /**
     * 加密算法：MD5
     */
    const HASH_FUNCTION_MD5 = 'MD5';

    /**
     * 加密算法：SHA1
     */
    const HASH_FUNCTION_SHA1 = "SHA1";

    /**
     * 加密算法：SHA128
     */
    const HASH_FUNCTION_SHA128 = "SHA128";
}