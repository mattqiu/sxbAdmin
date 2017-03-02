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
 * 微信自定义菜单接口
 * Class WxMenuAction
 */
class WxMenuAction extends CommonAction{

//1、click：点击推事件
//用户点击click类型按钮后，微信服务器会通过消息接口推送消息类型为event	的结构给开发者（参考消息接口指南），并且带上按钮中开发者填写的key值，开发者可以通过自定义的key值与用户进行交互；

//3、scancode_push：扫码推事件
//用户点击按钮后，微信客户端将调起扫一扫工具，完成扫码操作后显示扫描结果（如果是URL，将进入URL），且会将扫码的结果传给开发者，开发者可以下发消息。
//4、scancode_waitmsg：扫码推事件且弹出“消息接收中”提示框
//用户点击按钮后，微信客户端将调起扫一扫工具，完成扫码操作后，将扫码的结果传给开发者，同时收起扫一扫工具，然后弹出“消息接收中”提示框，随后可能会收到开发者下发的消息。
//5、pic_sysphoto：弹出系统拍照发图
//用户点击按钮后，微信客户端将调起系统相机，完成拍照操作后，会将拍摄的相片发送给开发者，并推送事件给开发者，同时收起系统相机，随后可能会收到开发者下发的消息。
//6、pic_photo_or_album：弹出拍照或者相册发图
//用户点击按钮后，微信客户端将弹出选择器供用户选择“拍照”或者“从手机相册选择”。用户选择后即走其他两种流程。
//7、pic_weixin：弹出微信相册发图器
//用户点击按钮后，微信客户端将调起微信相册，完成选择操作后，将选择的相片发送给开发者的服务器，并推送事件给开发者，同时收起相册，随后可能会收到开发者下发的消息。
//8、location_select：弹出地理位置选择器
//用户点击按钮后，微信客户端将调起地理位置选择工具，完成选择操作后，将选择的地理位置发送给开发者的服务器，同时收起位置选择工具，随后可能会收到开发者下发的消息。
//9、media_id：下发消息（除文本消息）
//用户点击media_id类型按钮后，微信服务器会将开发者填写的永久素材id对应的素材下发给用户，永久素材类型可以是图片、音频、视频、图文消息。请注意：永久素材id必须是在“素材管理/新增永久素材”接口上传后获得的合法id。


    //2、view：跳转URL
    //用户点击view类型按钮后，微信客户端将会打开开发者在按钮中填写的网页URL，可与网页授权获取用户基本信息接口结合，获得用户基本信息。


    //10、view_limited：跳转图文消息URL
    //用户点击view_limited类型按钮后，微信客户端将打开开发者在按钮中填写的永久素材id对应的图文消息URL，永久素材类型只支持图文消息。请注意：永久素材id必须是在“素材管理/新增永久素材”接口上传后获得的合法id。

    public function editMenu(){
        $this->display();
    }

    public function setMenu(){
        $newActiveMenuId = I('new_active', 'yeksvQic-Q1DIErQfwLG81WN9Ag1ZjHVXbLx2KrQfog');
//        return;
        $accessToken = S('wx_api_access_token');
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $accessToken;
        //2、view：跳转URL
        //用户点击view类型按钮后，微信客户端将会打开开发者在按钮中填写的网页URL，可与网页授权获取用户基本信息接口结合，获得用户基本信息。

        $data = array();
        $data['button'] = array();
        $customServerSubBtn = array();
        $customServerSubBtn[] = array('type' => 'media_id', 'name' => urlencode('售前须知'), 'media_id'=>'p5mP4IMsSOlTMzFJYOKkZn8TU6JQH2ctvcKEG9xYvz8');
        $customServerSubBtn[] = array('type' => 'click', 'name' => urlencode('在线客服'), 'key'=>'customer_service');
        $customServerSubBtn[] = array('type' => 'media_id', 'name' => urlencode('我要售后'), 'media_id'=>'MNlLJiGuT5uYR6fy6HiNdVFGTsz3uo0mYuHw-rgTzaI');
        $customServerSubBtn[] = array('type' => 'click', 'name' => urlencode('合作建议'), 'key'=>'cooperate');

        $data['button'][] = array( 'name'=>urlencode('在线客服'), 'sub_button' => $customServerSubBtn);
        $data['button'][] = array('name'=>urlencode('最新活动'), 'type'=>'media_id', 'media_id'=>$newActiveMenuId);
        $data['button'][] = array('type'=>'view', 'name'=>urlencode('小白商城'), 'url'=>'http://m.shuxiaobai.com');

        $result = getCurlRequest($url, urldecode(json_encode($data)));
        var_dump($result);
    }

    public function delMenu(){
        return;
        $accessToken = S('wx_api_access_token');
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=' . $accessToken;

        echo $url;
    }


} 