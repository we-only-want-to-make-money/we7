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
        $params=array('uid' => $_SESSION['uid']);
        $result = pdo_get('fans_redbook_vip', $params);
        if (!empty($result)) {
            $type=$result['type'];
            $freetimes=$result['freetimes'];
            $exprietime=$result['exprietime'];
            if($type==1){
                if($exprietime>strtotime(date("Y-m-d"),time())){
                    logging_run('check:'."1".strtotime(date("Y-m-d"),time()));
                    $this->result(0, '', array('status'=>'success')); //  响应json串
                }elseif($freetimes<5){
                    logging_run('check:'."2");
                    $fans_redbook_vip_update=['freetimes'=>$freetimes+1];
                    pdo_update('fans_redbook_vip', $fans_redbook_vip_update, array('uid' => $_SESSION['uid']));
                    $this->result(0, '', array('status'=>'success')); //  响应json串
                }else{
                    logging_run('check:'."3");
                    $this->result(0, '', array('status'=>'error')); //  响应json串
                }
            }else if($type==2){
                if($freetimes<5){
                    logging_run('check:'."4");
                    $fans_redbook_vip_update=['freetimes'=>$freetimes+1];
                    pdo_update('fans_redbook_vip', $fans_redbook_vip_update, array('uid' => $_SESSION['uid']));

                    $this->result(0, '', array('status'=>'success')); //  响应json串
                }else{
                    logging_run('check:'."5");

                    $this->result(0, '', array('status'=>'error')); //  响应json串

                }
            }
        }
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
                    if($type==1){
                        $mes=$exprieDate;
                    }else if($type==2){
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
    public function doPageKefu(){
        global  $_GPC,$_W;
        $content='<p style=\"text-align: center;\"><span style=\"background-color: rgb(238, 236, 225); color: rgb(255, 0, 0);\">\u7b2c\u4e00\u6b65\u3002\u5728\u5c0f\u7ea2\u4e66app\u70b9\u51fb\u53f3\u4e0a\u89d2\u4e09\u4e2a\u70b9\uff0c\u7136\u540e\u70b9\u590d\u5236\u94fe\u63a5<\/span><\/p><p style=\"text-align: center;\"><img src=\"http:\/\/honghui.noeon.cn\/attachment\/images\/3\/2018\/08\/BbmmQkkgkbvR9kprV6CgkV9pGzXxQo.jpg\" width=\"231\" alt=\"\u5fae\u4fe1\u56fe\u7247_20180801151148.jpg\" height=\"411\" style=\"width: 231px; height: 411px;\"\/><\/p><p style=\"text-align: center;\"><span style=\"color: rgb(255, 0, 0); background-color: rgb(238, 236, 225);\">\u7b2c\u4e8c\u6b65\u3002\u8fdb\u5165\u7ea2\u85af\u5e93\u5c0f\u7a0b\u5e8f\uff0c\u70b9\u51fb\u786e\u5b9a\u590d\u5236\u94fe\u63a5<\/span><\/p><p style=\"text-align: center;\"><img src=\"http:\/\/honghui.noeon.cn\/attachment\/images\/3\/2018\/08\/aFicIKwItofpiVK9oiVPIooPFfOVW9.jpg\" width=\"225\" alt=\"\u5fae\u4fe1\u56fe\u7247_20180801151203.jpg\" height=\"381\" style=\"width: 225px; height: 381px;\"\/><\/p><p style=\"text-align: center;\"><span style=\"color: rgb(255, 0, 0); background-color: rgb(238, 236, 225);\">\u7b2c\u4e09\u6b65 \u70b9\u51fb\u83b7\u53d6\u56fe\u7247<\/span><\/p><p style=\"text-align: center;\"><img src=\"http:\/\/honghui.noeon.cn\/attachment\/images\/3\/2018\/08\/VN3RbhVm096M330md8381u59h3f3RM.png\" width=\"246\" alt=\"\u5fae\u4fe1\u56fe\u7247_20180801151207.png\" height=\"479\" style=\"width: 246px; height: 479px;\"\/><\/p><p style=\"text-align: center;\"><span style=\"color: rgb(255, 0, 0); background-color: rgb(238, 236, 225);\">\u7b2c\u56db\u6b65 \u70b9\u51fb\u4fdd\u5b58\u56fe\u7247\u81f3\u76f8\u518c<\/span><\/p><p style=\"text-align: center;\"><img src=\"http:\/\/honghui.noeon.cn\/attachment\/images\/3\/2018\/08\/RFFgVihi2NllgVc44Z3ZCgXCFfHCcg.jpg\" width=\"299\" alt=\"\u5fae\u4fe1\u56fe\u7247_20180801151214.jpg\" height=\"511\" style=\"width: 299px; height: 511px;\"\/><\/p><p style=\"text-align: center;\"><span style=\"color: rgb(255, 0, 0); background-color: rgb(238, 236, 225);\">\u7b2c\u4e94\u6b65&nbsp; \u5728\u76f8\u518c\u4e2d\u67e5\u770b<\/span><\/p><p style=\"text-align: center;\"><img src=\"http:\/\/honghui.noeon.cn\/attachment\/images\/3\/2018\/08\/KDpZr4CGVZ7v5CBJPVVmJ5mGqQ76U7.jpg\" width=\"289\" alt=\"\u5fae\u4fe1\u56fe\u7247_20180801151218.jpg\" height=\"497\" style=\"width: 289px; height: 497px;\"\/><\/p><p><br\/><\/p>","uniacid":"3","content1":"&lt;p&gt;&lt;span style=&quot;background-color: rgb(255, 255, 255); color: rgb(255, 0, 0);&quot;&gt;&lt;strong&gt;\u56e0\u4e3a\u5c0f\u7a0b\u5e8f\u5e73\u53f0\u517c\u5bb9\u95ee\u9898\uff0c\u53d1\u73b0\u9b45\u65cf\u548coppo\u90e8\u5206\u624b\u673a\u673a\u578b\u4e0d\u80fd\u4fdd\u5b58\u56fe\u7247\uff0c\u7279\u6b64\u6211\u4eec\u5f00\u901a\u4e86\u516c\u4f17\u53f7\u4e0b\u8f7d\u56fe\u7247\u529f\u80fd\uff0c\u5c0f\u7a0b\u5e8f\u4ed8\u8d39vip\u7528\u6237\u53ef\u4ee5\u514d\u8d39\u7ed1\u5b9a\u516c\u4f17\u53f7\u4e0b\u8f7d\u529f\u80fd\uff0c\u4e0b\u9762\u8bf4\u4e0b\u6559\u7a0b\u3002&lt;\/strong&gt;&lt;\/span&gt;&lt;\/p&gt;&lt;p&gt;&lt;br\/&gt;&lt;\/p&gt;&lt;p&gt;&lt;span style=&quot;background-color: rgb(255, 255, 255); color: rgb(255, 0, 0);&quot;&gt;&lt;strong&gt;\u9996\u5148\u5173\u6ce8\u516c\u4f17\u53f7\u201c\u95fa\u871c\u7c89\u201d\u53d1\u9001\u4e00\u6761\u5c0f\u7ea2\u4e66\u7684\u94fe\u63a5\u7ed9\u516c\u4f17\u53f7\uff0c\u4f60\u4f1a\u83b7\u53d6\u4e00\u4e2aID\u53f7 \u6211\u7684ID\u53f7\u662f7\u53f7&lt;\/strong&gt;&lt;\/span&gt;&lt;\/p&gt;&lt;p&gt;&lt;img src=&quot;http:\/\/honghui.noeon.cn\/attachment\/images\/3\/2018\/04\/de719OTk9o41sgESxmo71CSOX992sC.jpg&quot; width=&quot;100%&quot; alt=&quot;\u5fae\u4fe1\u56fe\u7247_20180416233619.jpg&quot;\/&gt;&lt;\/p&gt;&lt;p&gt;&lt;br\/&gt;&lt;\/p&gt;&lt;p&gt;&lt;br\/&gt;&lt;\/p&gt;&lt;p&gt;&lt;span style=&quot;background-color: rgb(255, 255, 255);&quot;&gt;&lt;strong&gt;&lt;span style=&quot;background-color: rgb(255, 255, 255); color: rgb(255, 0, 0);&quot;&gt;\u8bb0\u4f4f\u81ea\u5df1\u7684ID\u53f7\u540e \u6253\u5f00\u5c0f\u7a0b\u5e8f \u8f93\u5165\u81ea\u5df1\u7684ID\u53f7 \u70b9\u51fb\u201c\u540c\u6b65\u516c\u4f17\u53f7vip\u5e10\u53f7\u201d\u8fd9\u6837\u5c31\u597d\u4e86\uff0c\u7136\u540e\u53bb\u516c\u4f17\u53f7\u6d4b\u8bd5\u4e0b\uff0c&lt;\/span&gt;&lt;\/strong&gt;&lt;\/span&gt;&lt;\/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;color: rgb(255, 0, 0);&quot;&gt;&lt;br\/&gt;&lt;\/span&gt;&lt;\/strong&gt;&lt;\/p&gt;&lt;p&gt;&lt;img src=&quot;http:\/\/honghui.noeon.cn\/attachment\/images\/3\/2018\/04\/LAQaahDaaShDbRqbqaptPARQDARCrx.jpg&quot; width=&quot;100%&quot; alt=&quot;\u5fae\u4fe1\u56fe\u7247_20180416233624.jpg&quot;\/&gt;&lt;\/p&gt;&lt;p&gt;&lt;br\/&gt;&lt;\/p&gt;&lt;p&gt;&lt;br\/&gt;&lt;\/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;color: rgb(255, 0, 0);&quot;&gt;&lt;br\/&gt;&lt;\/span&gt;&lt;\/strong&gt;&lt;\/p&gt;&lt;p&gt;&lt;span style=&quot;background-color: rgb(255, 255, 255);&quot;&gt;&lt;strong&gt;&lt;span style=&quot;background-color: rgb(255, 255, 255); color: rgb(255, 0, 0);&quot;&gt;\u6d4b\u8bd5\u4e00\u4e0b\uff0c\u53d1\u9001\u4e00\u4e2a\u5c0f\u7ea2\u4e66\u7684\u94fe\u63a5\u7ed9\u516c\u4f17\u53f7&lt;\/span&gt;&lt;\/strong&gt;&lt;\/span&gt;&lt;\/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;color: rgb(255, 0, 0);&quot;&gt;&lt;br\/&gt;&lt;\/span&gt;&lt;\/strong&gt;&lt;\/p&gt;&lt;p&gt;&lt;br\/&gt;&lt;\/p&gt;&lt;p&gt;&lt;img src=&quot;http:\/\/honghui.noeon.cn\/attachment\/images\/3\/2018\/04\/ubj4dfUjf7zkU4KBMA4j4UqWjS4kzY.png&quot; width=&quot;100%&quot; alt=&quot;\u5fae\u4fe1\u56fe\u7247_20180416233630.png&quot;\/&gt;&lt;\/p&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(255, 0, 0); background-color: rgb(255, 255, 255);&quot;&gt;&lt;strong&gt;\u597d\u4e86\uff0c\u516c\u4f17\u53f7\u4e0b\u8f7d\u670d\u52a1\u5df2\u7ecf\u540c\u6b65\u6210\u529f\uff0cvip\u7528\u6237\u968f\u610f\u9009\u62e9\uff0c\u5c0f\u7a0b\u5e8f\u548c\u516c\u4f17\u53f7\u4e0b\u8f7d\u529f\u80fd\u90fd\u53ef\u4ee5\u4f7f\u7528\u3002&lt;\/strong&gt;&lt;\/span&gt;&lt;\/p&gt;';
        $this->result(0, '', array('wx'=>'18767135653','content'=>$content)); //  响应json串

    }
}
