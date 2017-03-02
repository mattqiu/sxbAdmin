<?php
// +----------------------------------------------------------------------
// | 时品
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://m.shipinmmm.com/ All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Chris.Ying <christhink@qq.com>
// +----------------------------------------------------------------------
// | @version: $Id$ 


/**
 * 微信素材管理
 * Class WxMaterialAction
 */
class WxMaterialAction extends CommonAction{

    /**
     *  1.获取素材列表,取到media_id
     */
    public function getMaterialList(){
        $accessToken = S('wx_api_access_token');
        $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=' . $accessToken;

        $params = array();
        //type 	是 	素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）
        $params['type'] = I('type', 'news');
        //offset 	是 	从全部素材的该偏移位置开始返回，0表示从第一个素材 返回
        $params['offset'] = I('type', 0);
        //count 	是 	返回素材的数量，取值在1到20之间
        $params['count'] = I('type', 20);

        $result = getCurlRequest($url, urldecode(json_encode($params)));

        $this->assign('list', $result['item']);

        $this->display('getMaterialList');
    }
} 