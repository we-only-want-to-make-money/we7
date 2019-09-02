<?php
defined('IN_IA') or exit('Access Denied');

class Hong_huiModuleReceiver extends WeModuleReceiver {
    public function receive() {
        $type = $this->message['type'];
        //这里定义此模块进行消息订阅时的, 消息到达以后的具体处理过程, 请查看微擎文档来编写你的代码

        $c = '';
        foreach ($this->message as $key => $value) {
            $c .= "$key : $value \r\n";
        }

        file_put_contents('/home/wwwroot/default/receive.txt', $c);
    }
}
