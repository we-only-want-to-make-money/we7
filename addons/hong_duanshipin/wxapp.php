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
                'ad_id'=> "",//adunit-d062798d85388a15
                'adimg'=> "images/duanshipin/banner.jpg",
                'adtext'=> "全网最全免费短视频去水印工具！",
                'api_url'=> "https://weixin.gamesxh.com/addons/tommie_duanshiping/down.php?url=",
                'app_name'=> "快抖去水印小助手",
                'copytext'=> "QQ群：12218265",
                'description'=> "支持抖音、快手、头条、皮皮虾、微视、全民小视频、火山、西瓜视频、映客、陌陌等解析去水印。",
                'help_url'=> "",
                'invite_award'=> "3",
                'is_member'=> "1",
                'is_pay'=> "1",
                'isaudit'=> "1",
                'mix_num'=> "3",
                'onpayenter'=> "0",
                'progress'=> "1",
                'qq_group'=> "12218265",
                'qq_num'=> "147373291",
                'share_img'=> "https://weixin.gamesxh.com/attachment/images/2/2019/06/RJ3JkiYVcIX5K73Y4Cr57ZmJ75c5iI.jpg",
                'share_title'=> "上热门秘籍，99.9%的网红都在用！",
                'title'=> "增加次数或升级会员请加Q：147373291",
            ],
            'url'=>'https://www.91ye.top/attachment/'
        ];
        return         $this->result(0, '', $data);
    }
    public function doPageQuery(){
        global  $_GPC,$_W;
        $link=$_GPC['url'];
        $params=array('uid' => $_W['member']['uid']);
        $result = pdo_get('mc_mapping_fans', $params);
        $member=pdo_get('mc_members', $params);
        $num=$member['num'];
        if($num<1){
            return  $this->result(2, '视频解析失败,解析次数已用完', []);
        }

        //return  $this->result(0, '视频解析成功', ['downurl'=>"https://www.91ye.top/attachment/videos/220bbcf37ade188491a8eb533359a44147f1163554a000000fa6bc7580dc"]);

        logging_run('doPageQuery--$link:'.$link);

        load()->func('logging');
        logging_run('doPageQuery:'.json_encode($_GPC));
        //配置信息
        $iiiLabVideoDownloadURL = "http://service.iiilab.com/video/download";   //iiiLab通用视频解析接口
        $client = "7fb57db574e461fb";;   //iiiLab分配的客户ID
        $clientSecretKey = "5e0f03b2ee1405d8b0ed8d99ed962dd9";  //iiiLab分配的客户密钥
        //必要的参数
//        $link = "http://v.douyin.com/DdRo2a/";http://v.douyin.com/PqmYgj/
//        $link = "https://weibo.com/tv/v/EFSNuE1Ky";
        $timestamp = time() * 1000;
        $sign = md5($link . $timestamp . $clientSecretKey);
        $data = $this->file_get_contents_post($iiiLabVideoDownloadURL, array("link" => $link, "timestamp" => $timestamp, "sign" => $sign, "client" => $client));
        logging_run('doPageQuery——$data:'.$data);

        $link_data = json_decode($data,true);
        if ($link_data['retCode'] != 200) {
            $this->result(1, '视频解析失败,请检查视频地址是否正确！', []);
        }else{
            $video=$link_data['data']['video'];
            $path='/home/wwwroot/default/we7/attachment/videos/';
            logging_run('doPageQuery——$video:'.$video);
            $fileName=$this->downFile($video,$path);
            $downurl=$_W['attachurl']."videos/".$fileName;
            logging_run('doPageQuery——$downurl:'.$downurl);
            pdo_update('mc_members', array('num' => $num-1), array('uid' => $_W['member']['uid']));

            $this->result(0, '视频解析成功', ['downurl'=>$downurl]);

        }

    }
    function downFile($url,$path){
        $arr=parse_url($url);
        $fileName=basename($arr['path']);
        $file=file_get_contents($url);
        file_put_contents($path.$fileName,$file);
        return $fileName;
    }
    function file_get_contents_post($url, $post) {
        $options = array(
            "http"=> array(
                "method"=>"POST",
                "header" => "Content-type: application/x-www-form-urlencoded",
                "content"=> http_build_query($post)
            ),
        );
        $result = file_get_contents($url,false, stream_context_create($options));
        return $result;
    }
    public function doPageLogin(){
        global  $_GPC,$_W;
        $inviterOpenid=$_GPC['inviterOpenid'];
        load()->func('logging');
        logging_run('doPageLogin_GPC:'.json_encode($_GPC));
        logging_run('doPageLogin_W:'.json_encode($_W));
        if($inviterOpenid){
            $params=array('openid' => $inviterOpenid);
            $result = pdo_get('mc_mapping_fans', $params);
            if (!empty($result)) {
                pdo_update('mc_mapping_fans', array('inviteruid' => $result['uid']), array('uid' => $_W['member']['uid']));
            }
        }
        $this->result(0, '', $inviterOpenid);
    }
    public function doPageMember(){
        global  $_GPC,$_W;
        load()->func('logging');
        logging_run('doPageMember:'.json_encode($_W));
        $params=array('uid' => $_W['member']['uid']);
        $result = pdo_get('mc_mapping_fans', $params);
        $member=pdo_get('mc_members', $params);
        $data=[
            'user'=>[
                'headimg'=>$member['avatar'],
                'nickname'=>$member['nickname'],
                'maximum'=>$member['num'],
            ],
            'enddate'=>$member['date'],
            'inviteuum'=>$result['inviteuum'],
            'contact'=>[
                'contact'=>'',
                'qq_num'=>'147373291',
                'is_pay'=>'1',
                'isaudit'=>'1',
                'is_member'=>'1',
                'onpayenter'=>'0',
                'invite_award'=>'5',
                'help_url'=>'',
                'qq_group'=>'12218265',
            ]
        ];
        $this->result(0, '', $data);

    }
}
