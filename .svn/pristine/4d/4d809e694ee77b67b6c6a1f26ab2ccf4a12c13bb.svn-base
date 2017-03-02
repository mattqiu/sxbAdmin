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


class UserWxModel extends Model{

    /**
     * 取一条用户的微信信息, 并自动用redis做缓存
     * @param $uid
     * @return mixed|string|void
     */
    public function getUserItem($uid){
        $userWxItemKey = C('DB_PREFIX') . 'user_wx_' . $uid;
        $userWxItem = S($userWxItemKey);
        if(empty($userWxItem)){
            $userWxItem = $this->where('uid = ' . $uid)->find();
            S($userWxItemKey, $userWxItem, 864000);
        }

        return $userWxItem;
    }
} 