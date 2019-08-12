<?php defined('IN_IA') or exit('Access Denied');?><div class="account-info">
	<!--logo-->
	<img src="<?php  echo tomedia('headimg_'.$_W['account']['acid'].'.jpg')?>?time=<?php  echo time()?>" class="head-logo">
	<!-- 名称-->
	<div class="account-name text-over"><?php  echo $_W['account']['name'];?></div>
	<div class="account-type">
		版本：<?php  echo $version_info['version'];?>
	</div>
	<div class="account-operate">
		<a href="<?php  echo url('miniapp/version/display')?>" class="h">切换版本</a>
		<?php  if(in_array($_W['role'], array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_MANAGER)) || $_W['isfounder']) { ?>
			<a href="<?php  echo url('account/post', array('uniacid' => $_W['account']['uniacid'], 'acid' => $_W['account']['acid'], 'account_type' => $_W['account']['type']))?>" class="h">管理设置</a>
		<?php  } ?>
	</div>
	<a href="<?php  echo url('account/display', array('type' => 'all'))?>" class="btn btn-default accoutn-cut">切换平台</a>
</div>