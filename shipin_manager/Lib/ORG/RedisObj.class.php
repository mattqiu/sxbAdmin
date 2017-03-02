<?php
// +----------------------------------------------------------------------
// | 上海时品信息科技有限公司
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.shipinmmm.com/ All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Chris.Ying <christhink@qq.com>
// +----------------------------------------------------------------------
// | @version: $Id: Orders.class.php 1326 2014-10-09 06:14:10Z yihua.ying $ 


/**
 * Class RedisObj
 *  redis
 */
class RedisObj {
    public $handler;
    public $options;
    public function __construct($options=array()) {
        if ( !extension_loaded('redis') ) {
            throw_exception(L('_NOT_SUPPERT_').':redis');
        }
        if(empty($options)) {
            $options = array (
                'host'          => C('REDIS_HOST') ? C('REDIS_HOST') : '127.0.0.1',
                'port'          => C('REDIS_PORT') ? C('REDIS_PORT') : 6379,
                'timeout'       => C('DATA_CACHE_TIMEOUT') ? C('DATA_CACHE_TIMEOUT') : false,
                'persistent'    => false,
            );
        }
        $this->options =  $options;
        $this->options['expire'] =  isset($options['expire'])?  $options['expire']  :   C('DATA_CACHE_TIME');
        $this->options['prefix'] =  isset($options['prefix'])?  $options['prefix']  :   C('DATA_CACHE_PREFIX');
        $this->options['length'] =  isset($options['length'])?  $options['length']  :   0;
        $func = $options['persistent'] ? 'pconnect' : 'connect';
        $this->handler  = new Redis;
        $options['timeout'] === false ?
            $this->handler->$func($options['host'], $options['port']) :
            $this->handler->$func($options['host'], $options['port'], $options['timeout']);
//        $this->handler->auth(C('REDIS_AUTH'));
    }

    /**
     *  添加某个合集的元素
     * @param $key
     * @param $value
     * @return int
     */
    public function sAdd($key, $value){
        $key = C('DATA_CACHE_PREFIX') . $key;
        return $this->handler->sAdd($key , $value);
    }

    /**
     *  不加key前缀删除元素
     * @param $key
     * @return int
     */
    public function delNoPrefixKey($key){
        return $this->handler->del($key);
    }

    /**
     *  返回交集, 目前最多支持4个集合运算
     * @param $key1
     * @param $key2
     * @param string $key3
     * @param string $key4
     * @return array
     */
    public function sInter($key1, $key2, $key3 = '', $key4=''){
        $key1 = C('DATA_CACHE_PREFIX') . $key1;
        $key2 = C('DATA_CACHE_PREFIX') . $key2;
        $result = array();
        if(!empty($key4)){
            $key3 = C('DATA_CACHE_PREFIX') . $key3;
            $key4 = C('DATA_CACHE_PREFIX') . $key4;
            $result = $this->handler->sInter($key1, $key2, $key3, $key4);
        } elseif(!empty($key3)){
            $key3 = C('DATA_CACHE_PREFIX') . $key3;
            $result = $this->handler->sInter($key1, $key2, $key3);
        } else {
            $result = $this->handler->sInter($key1, $key2);
        }

        return $result;
    }

    /**
     *  对指定的key 值自增$value指定的值
     * @param $key
     * @param int $value
     */
    public function incr($key, $value=1){
        $key = C('DATA_CACHE_PREFIX') . $key;
        $this->handler->incr($key, $value);
    }

    public function get($key){
        $key = C('DATA_CACHE_PREFIX') . $key;
        $result = $this->handler->get($key);
        $jsonResult = json_decode($result, true);
        if(!empty($jsonResult)){
            $result = $jsonResult;
        }

        return $result;
    }

    public function set($key, $value){
        if(is_array($value)){
            $value = json_encode($value);
        }
        $key = C('DATA_CACHE_PREFIX') . $key;
        return $this->handler->set($key, $value);
    }

    public function sIsMember($key, $value){
        $key = C('DATA_CACHE_PREFIX') . $key;
        return $this->handler->sIsMember($key, $value);
    }

    /**
     *  返回key对应的有序集合中指定区间的所有元素。这些元素按照score从高到低的顺序进行排列。
     *  对于具有相同的score的元素而言，将会按照递减的字典顺序进行排列。
     *  该命令与ZRANGE类似，只是该命令中元素的排列顺序与前者不同。
     * @param $key
     * @param $start
     * @param $end
     * @param bool|false $withScores
     * @return array
     */
    public function zRevRange($key, $start, $end, $withScores = false){
        $key = C('DATA_CACHE_PREFIX') . $key;
        return $this->handler->zRevRange($key, $start, $end, $withScores);
    }

    public function zAdd($key, $score, $value){
        $key = C('DATA_CACHE_PREFIX') . $key;
        return $this->handler->zAdd($key, $score, $value);
    }

    /**
     * 返回一个集合中的成员数
     * @param $key
     * @return int
     */
    public function sCard($key){
        $key = C('DATA_CACHE_PREFIX') . $key;
//        return $this->handler->sCard($key);
    }

    /**
     *  返回队列的长度
     * @param $key
     */
    public function lSize($key){
        $key = C('DATA_CACHE_PREFIX') . $key;
        return $this->handler->lSize($key);
    }

    /***
     *  返回LIST底部（右侧）的VALUE，并且从LIST中把该VALUE弹出
     * @param $key
     * @return string
     */
    public function rPop($key){
        $key = C('DATA_CACHE_PREFIX') . $key;
        return $this->handler->rPop($key);
    }
}