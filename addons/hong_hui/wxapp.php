<?php
/**
 * 小程序入口
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
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
        $url=$_GPC['url'];
        $session_id=$_W['session_id'];//round(microtime(true) * 1000);

        //exec('cd /home/wwwroot/default/redbook');
        exec('php /home/wwwroot/default/redbook/yii redbook start '.$session_id.' '.$url.' 0',$array);
        //logging_run('exec:'.'php /home/wwwroot/default/redbook/yii redbook start '.$session_id.' '.$url.' 0');
        //logging_run('exec:'.json_encode($array));
        $sleep_time = 50000;//多长时间执行一次
        $isExist=file_exists("/home/wwwroot/default/downloads/".$session_id.".txt");
        if($isExist){
            $myfile = fopen("/home/wwwroot/default/downloads/".$session_id.".txt", "r");
            $txt= fread($myfile,filesize("/home/wwwroot/default/downloads/".$session_id.".txt"));
            fclose($myfile);
        }
        /*while(!$isExist){
            logging_run('isExist:'.$isExist);
            $isExist=file_exists("/home/wwwroot/default/downloads/".$session_id.".txt");
            if($isExist){
                $myfile = fopen("/home/wwwroot/default/downloads/".$session_id.".txt", "r");
                $txt= fread($myfile,filesize("/home/wwwroot/default/downloads/".$session_id.".txt"));
                fclose($myfile);
            }
            usleep($sleep_time);//等待时间，进行下一次操作。
        }*/
        logging_run('txt:'.json_encode($txt));

        $lunimg=['https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',];
        $wenimg=['https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',];
        $this->result(0, '', array('lunimg'=>json_decode($txt),'wenimg'=>json_decode($txt))); //  响应json串

    }
    public function doPageYunimage(){
        load()->func('logging');
        logging_run('doPageYunimage');
        $lunimg=['https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',];
        $wenimg=['https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',];
        $this->result(0, '', array('lunimg'=>$lunimg,'wenimg'=>$wenimg)); //  响应json串
    }
    public function doPageVideo(){
        $this->result(0, '', array('lunimg'=>'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'video'=>'https://v.xiaohongshu.com/23237a577db9f8c168c49652da23b68b06656cfa?sign=35424ab0553a467a449508a013dc69d7&t=5d52de80','size'=>'9')); //  响应json串
    }
    public function doPageYunvideo(){
        $this->result(0, '', array('lunimg'=>'https://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'video'=>'https://v.xiaohongshu.com/23237a577db9f8c168c49652da23b68b06656cfa?sign=35424ab0553a467a449508a013dc69d7&t=5d52de80','size'=>'9')); //  响应json串
    }
    public function doPageArt(){
        load()->func('logging');
        $this->result(0, '', array('art'=>'哈哈哈哈哈','artlist'=>['1','2','3'])); //  响应json串
    }
    public function doPageCheck(){
        load()->func('logging');
        $this->result(0, '', array('status'=>'success')); //  响应json串
    }
    public function doPageunionid(){
        load()->func('logging');
        logging_run('doPageunionid');

        $this->result(0, '', array('show'=>2,'show4'=>4,'type'=>1,'mes'=>'2010:10:10','name'=>'Hongch','mes1'=>'联系客服回复：1','mes2'=>'全天客服回复：2')); //  响应json串
    }
}
