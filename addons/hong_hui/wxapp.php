<?php
/**
 * 小程序入口
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
include_once('wxBizDataCrypt.php');
include_once('errorCode.php');

class Hong_huiModuleWxapp extends WeModuleWxapp {
    //public $token = 'we7_testhooktoken'; //接口通信token
    public function doPageIndex() { // 接口一个名为"index"的接口
        $this->result(0, '', array('test' => 1235)); //  响应json串
    }
    public function doPageTest() {
    }
    public function doPageImage(){
        global  $_GPC,$_W;
        load()->func('logging');
        logging_run('doPageImage:'.json_encode($_GPC));
        logging_run('doPageImage:'.json_encode($_W));

        $url=substr($_GPC['url'],strpos($_GPC['url'], 'http'));
        $session_id=$_W['session_id'];//round(microtime(true) * 1000);
        exec('php /home/wwwroot/default/redbook/yii redbook start '.$session_id.' '.$url.' 0',$array);
        logging_run("command:".'php /home/wwwroot/default/redbook/yii redbook start '.$session_id.' '.$url.' 2');

        $isExist=file_exists("/home/wwwroot/default/downloads/".$session_id.".txt");
        if($isExist){
            $myfile = fopen("/home/wwwroot/default/downloads/".$session_id.".txt", "r");
            $txt= fread($myfile,filesize("/home/wwwroot/default/downloads/".$session_id.".txt"));
            fclose($myfile);
        }
        logging_run('txt:'.json_encode($txt));
        $this->result(0, '', array('lunimg'=>json_decode($txt),'wenimg'=>[])); //  响应json串

    }
    public function doPageYunimage(){
        global  $_GPC,$_W;
        load()->func('logging');
        logging_run('doPageYunimage:'.json_encode($_GPC));
        $url=substr($_GPC['url'],strpos($_GPC['url'], 'http'));
        $session_id=$_W['session_id'];//round(microtime(true) * 1000);
        exec('php /home/wwwroot/default/redbook/yii redbook start '.$session_id.' '.$url.' 0',$array);
        $isExist=file_exists("/home/wwwroot/default/downloads/".$session_id.".txt");
        if($isExist){
            $myfile = fopen("/home/wwwroot/default/downloads/".$session_id.".txt", "r");
            $txt= fread($myfile,filesize("/home/wwwroot/default/downloads/".$session_id.".txt"));
            fclose($myfile);
        }
        logging_run('txt:'.json_encode($txt));
        $this->result(0, '', array('lunimg'=>json_decode($txt),'wenimg'=>[])); //  响应json串
    }
    public function doPageVideo(){
        global  $_GPC,$_W;
        load()->func('logging');
        logging_run('doPageVideo:'.json_encode($_GPC));
        $url=substr($_GPC['url'],strpos($_GPC['url'], 'http'));
        $session_id=$_W['session_id'];//round(microtime(true) * 1000);
        exec('php /home/wwwroot/default/redbook/yii redbook start '.$session_id.' '.$url.' 2',$array);
        logging_run("command:".'php /home/wwwroot/default/redbook/yii redbook start '.$session_id.' '.$url.' 2');
        $isExist=file_exists("/home/wwwroot/default/downloads/".$session_id.".txt");
        if($isExist){
            $myfile = fopen("/home/wwwroot/default/downloads/".$session_id.".txt", "r");
            $txt= fread($myfile,filesize("/home/wwwroot/default/downloads/".$session_id.".txt"));
            fclose($myfile);
        }
        logging_run('txt:'.json_encode($txt));
        $this->result(0, '', json_decode($txt)); //  响应json串
    }
    public function doPageYunvideo(){
        $this->result(0, '', array('lunimg'=>'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'video'=>'https://v.xiaohongshu.com/23237a577db9f8c168c49652da23b68b06656cfa?sign=35424ab0553a467a449508a013dc69d7&t=5d52de80','size'=>'9')); //  响应json串
    }
    public function doPageArt(){
        global  $_GPC,$_W;
        load()->func('logging');
        logging_run('doPageArt:'.json_encode($_GPC));
        $url=substr($_GPC['url'],strpos($_GPC['url'], 'http'));
        $session_id=$_W['session_id'];//round(microtime(true) * 1000);
        exec('php /home/wwwroot/default/redbook/yii redbook start '.$session_id.' '.$url.' 1',$array);
        $isExist=file_exists("/home/wwwroot/default/downloads/".$session_id.".txt");
        if($isExist){
            $myfile = fopen("/home/wwwroot/default/downloads/".$session_id.".txt", "r");
            $txt= fread($myfile,filesize("/home/wwwroot/default/downloads/".$session_id.".txt"));
            fclose($myfile);
        }
        $art="";
        $artlist=json_decode($txt);
        logging_run('artlist:'.$artlist);

        if(is_string($artlist)){
            $art=$artlist;
            $artlist=[$art];
        }else{
            foreach ($artlist as $item){
                $art.=$item.PHP_EOL;
            }
        }
        logging_run('art:'.$art);

        $this->result(0, '', array('art'=>$art,'artlist'=>$artlist)); //  响应json串
    }
    public function doPageCheck(){
        load()->func('logging');
        logging_run('openid:'.$_SESSION['openid']);
        $this->result(0, '', array('status'=>'success')); //  响应json串

    }
    public function doPageunionid(){
        global  $_GPC,$_W;
        $type=2;
        $mes=0;
        load()->func('logging');
        logging_run('doPageunionid');
        $encryptedData=$_GPC['encryptedData'];
        $iv=$_GPC['iv'];
        $appid=$_W['account']['key'];
        logging_run('appid:'.$appid);
        $account_api = WeAccount::createByUniacid();
        $oauth = $account_api->getOauthInfo($_GPC['code']);
        if (!empty($oauth) && !is_error($oauth)) {
            $_SESSION['openid'] = $oauth['openid'];
            $_SESSION['session_key'] = $oauth['session_key'];
            $fans = mc_fansinfo($oauth['openid']);
            $pc = new WXBizDataCrypt($appid, $oauth['session_key']);
            $errCode = $pc->decryptData($encryptedData, $iv, $data );
            if ($errCode == 0) {
                $userinfo=json_decode($data,true);
                $fans_update = array(
                    'nickname' => $userinfo['nickName'],
                    'unionid' => $userinfo['unionId'],
                    'tag' => base64_encode(iserializer(array(
                        'subscribe' => 1,
                        'openid' => $userinfo['openId'],
                        'nickname' => $userinfo['nickName'],
                        'sex' => $userinfo['gender'],
                        'language' => $userinfo['language'],
                        'city' => $userinfo['city'],
                        'province' => $userinfo['province'],
                        'country' => $userinfo['country'],
                        'headimgurl' => $userinfo['avatarUrl'],
                    ))),
                );
                $member = mc_fetch($fans['uid']);
                if (!empty($member)) {
                    pdo_update('mc_members', array('nickname' => $userinfo['nickName'], 'avatar' => $userinfo['avatarUrl'], 'gender' => $userinfo['gender']), array('uid' => $fans['uid']));
                } else {
                    $default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' .tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(':uniacid' => $_W['uniacid']));
                    $member = array(
                        'uniacid' => $_W['uniacid'],
                        'email' => md5($_SESSION['openid']).'@we7.cc',
                        'salt' => random(8),
                        'groupid' => $default_groupid,
                        'createtime' => TIMESTAMP,
                        'password' => md5($userinfo['openId'] . $member['salt'] . $_W['config']['setting']['authkey']),
                        'nickname' => $userinfo['nickName'],
                        'avatar' => $userinfo['avatarUrl'],
                        'gender' => $userinfo['gender'],
                        'nationality' => '',
                        'resideprovince' => '',
                        'residecity' => '',
                    );
                    pdo_insert('mc_members', $member);
                    $fans_update['uid'] = pdo_insertid();
                }
                $params=array('uid' => $fans['uid']);
                $result = pdo_get('fans_redbook_vip', $params);
                if (!empty($result)) {
                    $type=$result['type'];
                    $freetimes=$result['freetimes'];
                    $exprietime=$result['exprietime'];
                    $exprieDate=date("Y-m-d ", $exprietime);
                    if($type==2){
                        $mes=$exprieDate;
                    }else if($type==1){
                        $mes=$freetimes;
                    }
                }
                pdo_update('mc_mapping_fans', $fans_update, array('fanid' => $fans['fanid']));
                logging_run('decryptData:'.$data.PHP_EOL);
                $this->result(0, '', array('show'=>2,'show4'=>4,'type'=>$type,'mes'=>$mes,'name'=>$userinfo['nickName'],'mes1'=>'联系客服回复：1','mes2'=>'全天客服回复：2')); //  响应json串
            } else {
                logging_run('decryptData:'.$errCode.PHP_EOL);
            }
        }
    }
}
