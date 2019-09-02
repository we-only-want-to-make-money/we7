<?php
/**
 * 小程序入口
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');


class Hong_duanshipinModuleWxapp extends WeModuleWxapp {
    //public $token = 'we7_testhooktoken'; //接口通信token
    public function doPageIndex() { // 接口一个名为"index"的接口
        $data=[
            'index'=>[
                'ad_id'=> "adunit-d062798d85388a15",
                'adimg'=> "images/2/2019/06/Ne30FUaF3AEESfYSFG0yeeuoos3o48.jpg",
                'adtext'=> "加入Q群或分享好友可获得更多次数！",
                'api_url'=> "https://weixin.gamesxh.com/addons/tommie_duanshiping/down.php?url=",
                'app_name'=> "抖去水印",
                'copytext'=> "QQ群：760880531",
                'description'=> "抖去支持抖音、快手、头条、皮皮虾、微视、全民小视频、火山、西瓜视频、映客、陌陌等解析。",
                'help_url'=> "",
                'invite_award'=> "3",
                'is_member'=> "1",
                'is_pay'=> "1",
                'isaudit'=> "1",
                'mix_num'=> "3",
                'onpayenter'=> "0",
                'progress'=> "1",
                'qq_group'=> "760880531",
                'qq_num'=> "20370266",
                'share_img'=> "https://weixin.gamesxh.com/attachment/images/2/2019/06/RJ3JkiYVcIX5K73Y4Cr57ZmJ75c5iI.jpg",
                'share_title'=> "上热门秘籍，99.9%的网红都在用！",
                'title'=> "增加次数或升级会员请加Q：20370266",
            ],
            'url'=>'https://weixin.gamesxh.com/attachment/'
        ];
        return         $this->result(0, '', $data);

    }

}
