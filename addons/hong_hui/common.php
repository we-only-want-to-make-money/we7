<?php

/**
 * 数据签名,验签处理工具类
 */

/**
 * 生成签名
 * $paras 请求参数字符串
 * $key 密钥
 * return 生成的签名
 */
function createSign($paras,$key){
	$sort_array = array_sort(array_filter($paras));				//删除数组中的空值并排序
	$prestr = create_linkstring($sort_array);     				//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	$prestr = $prestr."&key=".$key;										//把拼接后的字符串再与安全校验码直接连接起来
	$mysgin = sign($prestr,'MD5');			    //把最终的字符串签名，获得签名结果
	return $mysgin;
}
/**
 * 进件生成签名
 * $paras 请求参数字符串
 * $key 密钥
 * return 生成的签名
 */
function createSign_JinJian($paras,$key){
	$sort_array = array_sort(array_filter($paras));             //删除数组中的空值并排序
	$prestr = create_linkstring($sort_array);                   //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	$prestr = $prestr.$key;                                   //把拼接后的字符串再与安全校验码直接连接起来
	$mysgin = sign($prestr,'MD5');              //把最终的字符串签名，获得签名结果
	return $mysgin;
}

/**
 * 对数组排序
 * $array 排序前的数组
 * return 排序后的数组
 */
function array_sort($array) {
	ksort($array);												//按照key值升序排列数组
	return $array;
}

/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 * $array 需要拼接的数组
 * return 拼接完成以后的字符串
 */
function create_linkstring($array) {
	$str  = "";
	while (list ($key, $val) = each ($array)) {
		//键值为空的参数不参与排序，键名为key的参数不参与排序
		if($val != null && $val != "" && $key != "key" && $key != "sign_type")
			$str.=$key."=".$val."&";
	}
	$str = substr($str,0,count($str)-2);						//去掉最后一个&字符
	return $str;												//返回参数
}

/**
 * 签名字符串
 * $prestr 需要签名的字符串
 * $sign_type 签名类型，也就是sec_id
 * return 签名结果
 */
function sign($prestr,$sign_type) {
	$sign='';
	if($sign_type == 'MD5') {
		$sign = md5($prestr);									//MD5加密
	}elseif($sign_type =='DSA') {
		//DSA 签名方法待后续开发
		die("DSA 签名方法待后续开发，请先使用MD5签名方式");
	}elseif($sign_type == ""){
		die("sign_type为空，请设置sign_type");
	}else {
		die("暂不支持".$sign_type."类型的签名方式");
	}
	return strtolower($sign);									//返回参数并小写
}


function requestAsHttpPOST($data, $service_url){
	load()->func('logging');
	$HTTP_TIME_OUT= "20";
	$http_data = array_sort(array_filter($data)); //删除数组中的空值并排序
	$post_data = http_build_query($http_data);
	$options = array(
		'http' => array(
			'method'  => 'POST',
			'header'  => 'Content-type:application/x-www-form-urlencoded;charset=MD5',
			'content' => $post_data,
			'timeout' => $HTTP_TIME_OUT * 1000 //超时时间,*1000将毫秒变为秒（单位:s）
		)
	);
	$context = stream_context_create($options);
	logging_run('context:'.$context."   service_url:".$service_url);

	$result = file_get_contents($service_url, false, $context);
	return $result;
}

function send($data,$service_url) // 发送 请求
{
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $service_url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	$content = curl_exec($curl);
	curl_close($curl);
	return $content;
}


?>


