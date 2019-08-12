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
        load()->func('logging');
        logging_run('doPageImage');
        $lunimg=['http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',];
        $wenimg=['http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',
            'http://ci.xiaohongshu.com/daeb8bca-40d6-5dee-8fe9-54e8dec0a9d6?imageView2/2/w/1080/format/jpg',];
        $this->result(0, '', array('lunimg'=>$lunimg,'wenimg'=>$wenimg)); //  响应json串

    }
}
