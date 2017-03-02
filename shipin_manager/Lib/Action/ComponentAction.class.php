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
 * Class ComponentAction
 *  微信第三方平台后台操作功能
 */
class ComponentAction extends CommonAction{

    public $model;

    public function _init(){
//        $this->model = M('appbanner');
    }

    public function index(){
//
//        $data = '{
//             "button":[
//             {
//                 "type":"click",
//                  "name":"今日歌曲",
//                  "key":"V1001_TODAY_MUSIC"
//              },
//              {
//                  "name":"菜单",
//                   "sub_button":[
//                   {
//                       "type":"view",
//                       "name":"搜索",
//                       "url":"http://www.soso.com/"
//                    },
//                    {
//                        "type":"view",
//                       "name":"视频",
//                       "url":"http://v.qq.com/"
//                    },
//                    {
//                        "type":"click",
//                       "name":"赞一下我们",
//                       "key":"V1001_GOOD"
//                    }]
//               }]
//         }';
//        $dataArr = json_decode($data);
//        var_dump($dataArr);

//
//        1、自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。
//2、一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。
//3、创建自定义菜单后，由于微信客户端缓存，需要24小时微信客户端才会展现出来。测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。
//
//自定义菜单接口可实现多种类型按钮，如下：
//
//1、click：点击推事件
//用户点击click类型按钮后，微信服务器会通过消息接口推送消息类型为event	的结构给开发者（参考消息接口指南），并且带上按钮中开发者填写的key值，开发者可以通过自定义的key值与用户进行交互；
//2、view：跳转URL
//用户点击view类型按钮后，微信客户端将会打开开发者在按钮中填写的网页URL，可与网页授权获取用户基本信息接口结合，获得用户基本信息。
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
//10、view_limited：跳转图文消息URL
//用户点击view_limited类型按钮后，微信客户端将打开开发者在按钮中填写的永久素材id对应的图文消息URL，永久素材类型只支持图文消息。请注意：永久素材id必须是在“素材管理/新增永久素材”接口上传后获得的合法id。
//
//请注意，3到8的所有事件，仅支持微信iPhone5.4.1以上版本，和Android5.4以上版本的微信用户，旧版本微信用户点击后将没有回应，开发者也不能正常接收到事件推送。9和10，是专门给第三方平台旗下未微信认证（具体而言，是资质认证未通过）的订阅号准备的事件类型，它们是没有事件推送的，能力相对受限，其他类型的公众号不必使用。
//
//接口调用请求说明
//
//http请求方式：POST（请使用https协议）
//
//click和view的请求示例
//
// {
//     "button":[
//     {
//         "type":"click",
//          "name":"今日歌曲",
//          "key":"V1001_TODAY_MUSIC"
//      },
//      {
//          "name":"菜单",
//           "sub_button":[
//           {
//               "type":"view",
//               "name":"搜索",
//               "url":"http://www.soso.com/"
//            },
//            {
//                "type":"view",
//               "name":"视频",
//               "url":"http://v.qq.com/"
//            },
//            {
//                "type":"click",
//               "name":"赞一下我们",
//               "key":"V1001_GOOD"
//            }]
//       }]
// }
//
//其他新增按钮类型的请求示例
//
//{
//    "button": [
//        {
//            "name": "扫码",
//            "sub_button": [
//                {
//                    "type": "scancode_waitmsg",
//                    "name": "扫码带提示",
//                    "key": "rselfmenu_0_0",
//                    "sub_button": [ ]
//                },
//                {
//                    "type": "scancode_push",
//                    "name": "扫码推事件",
//                    "key": "rselfmenu_0_1",
//                    "sub_button": [ ]
//                }
//            ]
//        },
//        {
//            "name": "发图",
//            "sub_button": [
//                {
//                    "type": "pic_sysphoto",
//                    "name": "系统拍照发图",
//                    "key": "rselfmenu_1_0",
//                   "sub_button": [ ]
//                 },
//                {
//                    "type": "pic_photo_or_album",
//                    "name": "拍照或者相册发图",
//                    "key": "rselfmenu_1_1",
//                    "sub_button": [ ]
//                },
//                {
//                    "type": "pic_weixin",
//                    "name": "微信相册发图",
//                    "key": "rselfmenu_1_2",
//                    "sub_button": [ ]
//                }
//            ]
//        },
//        {
//            "name": "发送位置",
//            "type": "location_select",
//            "key": "rselfmenu_2_0"
//        },
//        {
//            "type": "media_id",
//           "name": "图片",
//           "media_id": "MEDIA_ID1"
//        },
//        {
//            "type": "view_limited",
//           "name": "图文消息",
//           "media_id": "MEDIA_ID2"
//        }
//    ]
//}
//
//参数说明
//参数 	是否必须 	说明
//button 	是 	一级菜单数组，个数应为1~3个
//sub_button 	否 	二级菜单数组，个数应为1~5个
//type 	是 	菜单的响应动作类型
//name 	是 	菜单标题，不超过16个字节，子菜单不超过40个字节
//key 	click等点击类型必须 	菜单KEY值，用于消息接口推送，不超过128字节
//url 	view类型必须 	网页链接，用户点击菜单可打开链接，不超过256字节
//media_id 	media_id类型和view_limited类型必须 	调用新增永久素材接口返回的合法media_id
//
//
//返回结果
//
//正确时的返回JSON数据包如下：
//
//{"errcode":0,"errmsg":"ok"}
//
//错误时的返回JSON数据包如下（示例为无效菜单名长度）：
//
//{"errcode":40018,"errmsg":"invalid button name size"}




    }

    public function menu(){
        //临时修改叔小白的菜单
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=5yNJrqviT9Y92ZIsI1SfJlFm0zRML25Ru2Sm9uCMIeGUh-uhx88ZwKNgBt6sxF5XjGuBx0DAe4JeXkql5bqvBdSmBlql3x0H8iPJ97lWjbqNGSPKIDeTNqQ64J9_6V4COPCgAHDSTG';

        //2、view：跳转URL
        //用户点击view类型按钮后，微信客户端将会打开开发者在按钮中填写的网页URL，可与网页授权获取用户基本信息接口结合，获得用户基本信息。

        $data = array();
        $data['button'] = array();
        $data['button'][] = array('type'=>'view', 'name'=>urlencode('关于叔'), 'url'=>'http://m.shuxiaobai.com/home/aboutus');
        //        $data['button'][] = array('type'=>'view_limited', 'name'=>urlencode('最新活动'), 'media_id'=>'400543183');
        $data['button'][] = array('type'=>'view', 'name'=>urlencode('最新活动'), 'url'=>'http://mp.weixin.qq.com/s?__biz=MzIxNDExNzg1Mg==&mid=400543183&idx=1&sn=294a4f6aeff842c2e619864a63583973&scene=18#wechat_redirect');
        $data['button'][] = array('type'=>'view', 'name'=>urlencode('叔小白商城'), 'url'=>'http://m.shuxiaobai.com');

        $result = getCurlRequest($url, urldecode(json_encode($data)));
        var_dump($result);
    }

    /**
     *  设置自动回复
     */
    public function eventReply(){


    }

    /**
     *  设置所属行业
     */
    public function setIndustry(){

    }
    

} 