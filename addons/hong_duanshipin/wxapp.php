<?php
/**
 * 小程序入口
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');


class Hong_duanshipinModuleWxapp extends WeModuleWxapp {
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
        logging_run("command:".'php /home/wwwroot/default/redbook/yii redbook start '.$session_id.' '.$url.' 0');

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
                    $fans_redbook_vip_update=['freetimes'=>$freetimes+1,'updatetime'=>strtotime(date("Y-m-d"),time())];
                    pdo_update('fans_redbook_vip', $fans_redbook_vip_update, array('uid' => $_SESSION['uid']));
                    $this->result(0, '', array('status'=>'success')); //  响应json串
                }else{
                    logging_run('check:'."3");
                    $this->result(0, '', array('status'=>'error')); //  响应json串
                }
            }else if($type==2){
                //if($freetimes<5){
                    logging_run('check:'."4"."  uid:".$_SESSION['uid']);
                    $fans_redbook_vip_update=['freetimes'=>$freetimes+1,'updatetime'=>round(microtime(true))];
                    pdo_update('fans_redbook_vip', $fans_redbook_vip_update, array('uid' => $_SESSION['uid']));

                    $this->result(0, '', array('status'=>'success')); //  响应json串
                /*}else{
                    logging_run('check:'."5");

                    $this->result(0, '', array('status'=>'error')); //  响应json串

                }*/
            }
        }
        $this->result(0, '', array('status'=>'success')); //  响应json串

    }
    public function doPageInvite(){
        global  $_GPC,$_W;
        load()->func('logging');
        logging_run('doPageInvite');
        $fans_redbook_vip_update=['inviteuid'=>$_GPC['inviteCode']];
        pdo_update('fans_redbook_vip', $fans_redbook_vip_update, array('uid' => $_SESSION['uid']));
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
        $content='"<p style="text-align: center;"><span style="background-color: rgb(238, 236, 225); color: rgb(255, 0, 0);">第一步。在小红书app点击右上角三个点，然后点复制链接</span></p><p style="text-align: center;"><img src="https://www.91ye.top/attachment/images/red/1.jpg" width="231" alt="微信图片_20180801151148.jpg" height="411" style="width: 231px; height: 411px;"/></p><p style="text-align: center;"><span style="color: rgb(255, 0, 0); background-color: rgb(238, 236, 225);">第二步。进入红薯库小程序，点击确定复制链接</span></p><p style="text-align: center;"><img src="https://www.91ye.top/attachment/images/red/2.png" width="225" alt="微信图片_20180801151203.jpg" height="381" style="width: 225px; height: 381px;"/></p><p style="text-align: center;"><span style="color: rgb(255, 0, 0); background-color: rgb(238, 236, 225);">第三步 点击获取图片</span></p><p style="text-align: center;"><img src="https://www.91ye.top/attachment/images/red/5.png" width="246" alt="微信图片_20180801151207.png" height="479" style="width: 246px; height: 479px;"/></p><p style="text-align: center;"><span style="color: rgb(255, 0, 0); background-color: rgb(238, 236, 225);">第四步 点击保存图片至相册</span></p><p style="text-align: center;"><img src="https://www.91ye.top/attachment/images/red/3.png" width="299" alt="微信图片_20180801151214.jpg" height="511" style="width: 299px; height: 511px;"/></p><p style="text-align: center;"><span style="color: rgb(255, 0, 0); background-color: rgb(238, 236, 225);">第五步  在相册中查看</span></p><p style="text-align: center;"><img src="https://www.91ye.top/attachment/images/red/4.jpg" width="289" alt="微信图片_20180801151218.jpg" height="497" style="width: 289px; height: 497px;"/></p><p><br/></p>"';
        $this->result(0, '', array('wx'=>'18767135653','content'=>$content)); //  响应json串
    }
    public function createPreRecord($table,$params){
        pdo_insert($table, $params);
    }
    public function doPagePay(){
        global  $_GPC,$_W;
        load()->func('logging');
        logging_run('doPagePay');

        $head["appId"]         =appId;//合作方标识
        $head["random"]         =random;//随机数
        $head["merchantCode"]       ="EW_N0244013486";//门店编号
        $head["totalAmount"]            =$_GPC['amount'];//"0.01";//订单总金额，单位为元，精确到小数点后两位，取值范围[0.01至100000000]
        $head["channel"]            = "WXPAY";//支付渠道  支付宝 WXPAY:微信 ALIPAY:支付宝
        $head["tradeType"]            = "MINIAPP"; //支付交易类型 指定该笔支付将使用的第三方支付渠道交易类型： MINIAPP:小程序支付
        $head["notifyUrl"]            = "http://www.baidu.com"; //异步通知地址
        $head["subject"]            = "测试订单1"; //支付凭证商品描述信息，不填写默认为交易订单编号


        /*
        1.支付宝支付时，要求上送用户在支付宝唯一用户号user_id，获取流程:
        https://docs.open.alipay.com/220/105337
        2.微信支付时，要求上送用户在商户subAppid下唯一标识openid，获取流程
        https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1445241432
        3.本接口主要针对商户使用联拓富平台公众账号进行支付的用户，通过该接口获取到支付所需要的openid。
        具体流程和步骤如下：
        http://api.liantuofu.com/open/wechatUserAuth?merchantCode={merchantCode}&redirectUri={redirectUri}
        用户扫码打开链接，跳转微信授权会自动完成获取openId，获取成功后会跳转至redirectUri，并在目标url后方拼接openId
        例如：http://api.liantuofu.com/open/wechatUserAuth?merchantCode=ABC&redirectUri=http://www.qq.com
        获取openId成功后，跳转链接：http://www.qq.com?openId=xxxxxxxxxxx,从而获取openid
         */
        $head["openId"]            = "oC5Ty5MRpxtLWx9Es1Fqr0gMTObE"; //消费者用户标识，openid和appid必须匹配
        $head["subAppId"]            = "wx5de833372345207d"; //微信分配的小程序APPID，仅微信交易有效
        $head["outTradeNo"]            ="XS-".$head["openId"].'-'. round(microtime(true) * 1000); //商户订单号由商户生成的该笔交易的全局唯一ID，商户需确保其唯一性，重新发起一笔支付要使用原订单号，避免重复支付。后续可通过该ID查询对应订单信息。 建议值：公司简称+门店编号+时间戳+序列 支持8-64位数字、英文字母、“-”及“_”，其他字符不支持


        $sign=createSign($head,key);

        $head["sign"]         =$sign;
        $chargedoc = array(
            'uniacid' => $_W['uniacid'],
            'uid' => $_SESSION['uid'],
            'openid'=>$_SESSION['openid'],
            'createtime' => TIMESTAMP,
            'transid' => $head["outTradeNo"],
            'fee' => $head["totalAmount"],
            'type' => 'weixin',
            'status' => 0,
            'updatetime' => TIMESTAMP,
        );
        $this->createPreRecord('mc_vip_recharge',$chargedoc);
        $resp                        = requestAsHttpPOST($head, submit_url_precreate); //发送请求
        logging_run('resp：',json_encode($resp));

        return                 $this->result(0, '', $resp); //  响应json串

    }
    public function doPageNotify(){

    }
}
