<?php


/**
 *  memcached 缓存管理
 * Class MemcacheManageAction
 */
class MemcacheManageAction extends CommonAction{

//    var $ocs_address = '127.0.0.1';
    var $ocs_address = '121.43.225.46';
    var $ocs_port = '11211';
    var $mem_obj;

    public function _init(){
        $memc = new Memcached('ocs');
        $serverList = $memc->getServerList();
        if (count($memc->getServerList()) == 0){
            $memc->setOption(Memcached::OPT_COMPRESSION, false);
            $memc->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
            $memc->addServer($this->ocs_address, $this->ocs_port);
        }
        $this->mem_obj = $memc;
    }




    public function index(){

        $memc = new Memcached('ocs');
        $serverList = $memc->getServerList();
        if (count($memc->getServerList()) == 0){
            $memc->setOption(Memcached::OPT_COMPRESSION, false);
            $memc->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
            $memc->addServer('127.0.0.1', '11211');
        }
        $this->mem_obj = $memc;


        echo 'memcached缓存管理';
        $wapMemKey = 'all_wap_mem_keys';
        $apiMemKey = 'all_api_mem_keys';

//        $memObj = new Memcache();
//        $memObj->connect($this->ocs_address, $this->ocs_port);


//        $wapKeys2 = $memObj->get($wapMemKey);
        $wapMemKeyStr = $this->mem_obj->get($wapMemKey);
        $reslult = $this->mem_obj->getResultMessage();
        echo $wapMemKeyStr;
        echo '<br/>result==' . $reslult;






    }
}