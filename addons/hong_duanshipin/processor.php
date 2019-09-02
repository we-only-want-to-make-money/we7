<?php
defined('IN_IA') or exit('Access Denied');

class Hong_duanshipinModuleProcessor extends WeModuleProcessor {
    public function respond() {
        //回复用户一句话
        return $this->respText('您触发了Hong_hui模块');
    }
}
