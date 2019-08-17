<?php

require_once("common.php");
define("version", "1.0");
define("partner_id", "18060410173207886");
define("input_charset", "UTF-8");
define("core_merchant_no", "EW_N5772984681");
define("sign_type", "MD5");
define("partner_key", "78bc1ac50be17004b58edea930c70c78");
define("submit_url", "http://newfront.liantuobank.com/NewFront/base/gateway.in");


//test_FrontMicropay();
//test_FrontNative();
//test_FrontJSAPI();
//test_FrontQuery();
//test_FrontReverse();
//test_FrontClose();
//test_FrontRefund();
//test_FrontRefundQuery();
uploadImg();
    /**
   * 网商图片上传接口-----把图片先上传到联拓内部服务器，再上传到网商银行的服务器，然后返回图片在联拓和网商银行的地址。
   */
     function uploadImg(){
      $filePath = 'G:\aest.jpg';
      $files=new \CURLFile(realpath($filePath));

     // $files = @file_get_contents($filePath) or exit('not found file ( '.$filepath.' )'); //生成文件流 
      echo json_encode($files);
      $head["service"]         ="front.micropay";//扫码--被扫支付
      $head["version"]         =version;//默认版本号
      $head["partner_id"]       =partner_id;//联富通线下提供pid
      $head["input_charset"]            = input_charset; //编码格式，默认只支持UTF-8
      $head["core_merchant_no"]            =core_merchant_no;//联富通后台核心商户编号
      $head["sign_type"]            = sign_type;//加密方式，默认只支持MD5

      $body["merchant_no"]            = "EW_N8366110628"; //门店商户编号
      $body["channel_type"]            = "WX";//支付渠道
      $body["out_trade_no"]            ="EW_N8366110628_0001aaa23111";//商户订单号
      $body["total_amount"]            = "0.01"; //订单总金额
      $body["subject"]            ="玉玲兰麓谷店";//商品标题
      $body["spbill_create_ip"]            ="123.0.0.1";//终端IP
      $body["device_info"]            ="设备测试账号1";//设备号
      $body["auth_code"]            ="134916225958156985";//支付授权码134916225958156985

    
      $signArray = array_merge($head, $body);
      $sign=createSign($signArray,partner_key);
      $head["sign"]         =$sign;
      $body["picture"]    =$files;
      $requestJson["body"]             =$body;
      $requestJson["head"]             =$head;
      $requestPara["requestJson"]   =json_encode($requestJson);

      // echo '$reqxml====='.json_encode($reqXml).'<br/><br/><br/>';
      $resp                = send($requestPara,"http://newfront.liantuobank.com/NewFront/base/gateway.in"); //发送请求
        
     var_dump($resp);  
    }

    //------------------------------------------------------------
    // 扫码--被扫支付
    //------------------------------------------------------------
    function test_FrontMicropay(){
  
      $head["service"]         ="front.micropay";//扫码--被扫支付
      $head["version"]         =version;//默认版本号
      $head["partner_id"]       =partner_id;//联富通线下提供pid
      $head["input_charset"]            = input_charset; //编码格式，默认只支持UTF-8
      $head["core_merchant_no"]            =core_merchant_no;//联富通后台核心商户编号
      $head["sign_type"]            = sign_type;//加密方式，默认只支持MD5

      $body["merchant_no"]            = "EW_N8366110628"; //门店商户编号
      $body["channel_type"]            = "WX";//支付渠道
      $body["out_trade_no"]            ="EW_N8366110628_0001aaa23111";//商户订单号
      $body["total_amount"]            = "0.01"; //订单总金额
      $body["subject"]            ="玉玲兰麓谷店";//商品标题
      $body["spbill_create_ip"]            ="123.0.0.1";//终端IP
      $body["device_info"]            ="设备测试账号1";//设备号
      $body["auth_code"]            ="134916225958156985";//支付授权码134916225958156985

    
      $signArray = array_merge($head, $body);
      $sign=createSign($signArray,partner_key);
      $head["sign"]         =$sign;
     
      $requestJson["body"]             =$body;
      $requestJson["head"]             =$head;
      $requestPara["requestJson"]   =json_encode($requestJson);
      $resp                        = requestAsHttpPOST($requestPara, submit_url); //发送请求
      
      var_dump($resp);
    }
    //------------------------------------------------------------
    // 扫码--主扫支付
    //------------------------------------------------------------
    function test_FrontNative(){
  
      $head["service"]         ="front.native";//扫码--主扫支付
      $head["version"]         =version;//默认版本号
      $head["partner_id"]       =partner_id;//联富通线下提供pid
      $head["input_charset"]            = input_charset; //编码格式，默认只支持UTF-8
      $head["core_merchant_no"]            =core_merchant_no;//联富通后台核心商户编号
      $head["sign_type"]            = sign_type;//加密方式，默认只支持MD5

      $body["merchant_no"]            = "EW_N8366110628"; //门店商户编号
      $body["channel_type"]            = "WX";//支付渠道
      $body["out_trade_no"]            ="EW_N8366110628_0001aaa23111a1";//商户订单号
      $body["total_amount"]            = "0.01"; //订单总金额
      $body["subject"]            ="玉玲兰麓谷店";//商品标题
      $body["spbill_create_ip"]            ="123.0.0.1";//终端IP
      $body["device_info"]            ="设备测试账号1";//设备号
    
      $signArray = array_merge($head, $body);
      $sign=createSign($signArray,partner_key);
      $head["sign"]         =$sign;
     
      $requestJson["body"]             =$body;
      $requestJson["head"]             =$head;
      $requestPara["requestJson"]   =json_encode($requestJson);
      $resp                        = requestAsHttpPOST($requestPara, submit_url); //发送请求
      
      var_dump($resp);
    }
     //------------------------------------------------------------
    // 扫码--公众号支付
    //------------------------------------------------------------
    function test_FrontJSAPI(){
  
      $head["service"]         ="front.jsapi";//扫码--公众号支付
      $head["version"]         =version;//默认版本号
      $head["partner_id"]       =partner_id;//联富通线下提供pid
      $head["input_charset"]            = input_charset; //编码格式，默认只支持UTF-8
      $head["core_merchant_no"]            =core_merchant_no;//联富通后台核心商户编号
      $head["sign_type"]            = sign_type;//加密方式，默认只支持MD5

      $body["merchant_no"]            = "EW_N8366110628"; //门店商户编号
      $body["channel_type"]            = "WX";//支付渠道
      $body["out_trade_no"]            ="EW_N8366110628_0001aaa23111a11";//商户订单号
      $body["total_amount"]            = "0.01"; //订单总金额
      $body["subject"]            ="玉玲兰麓谷店";//商品标题
      $body["spbill_create_ip"]            ="123.0.0.1";//终端IP
      $body["device_info"]            ="设备测试账号1";//设备号
      $body["open_id"]            ="oLNmRjrZe5hqTd0eXMvZQTUBjR94";//对应的appid获取的用户openid
      $body["sub_appid"]            ="wx6c68ab3d898a1a96";//联富通后台门店进件时填写的appid,传递参数时针对于所有的商户全部都为sub_appid
      $body["notify_url"]            ="http://dailishanghu.com";//商户自己服务器被动接收支付结果的服务器地址
    
      $signArray = array_merge($head, $body);
      $sign=createSign($signArray,partner_key);
      $head["sign"]         =$sign;
     
      $requestJson["body"]             =$body;
      $requestJson["head"]             =$head;
      $requestPara["requestJson"]   =json_encode($requestJson);
      $resp                        = requestAsHttpPOST($requestPara, submit_url); //发送请求
      
      var_dump($resp);
    }
    //------------------------------------------------------------
    // 订单查询API
    //------------------------------------------------------------
    function test_FrontQuery(){
  
      $head["service"]         ="front.query";//订单查询API
      $head["version"]         =version;//默认版本号
      $head["partner_id"]       =partner_id;//联富通线下提供pid
      $head["input_charset"]            = input_charset; //编码格式，默认只支持UTF-8
      $head["core_merchant_no"]            =core_merchant_no;//联富通后台核心商户编号
      $head["sign_type"]            = sign_type;//加密方式，默认只支持MD5

    
      $body["out_trade_no"]            ="EW_N8366110628_0001aaa23111";//商户订单号
      $body["trade_no"]            ="00060011806081011119020239178664";//交易流水号,支付请求返回结果参数
      
      $signArray = array_merge($head, $body);
      $sign=createSign($signArray,partner_key);
      $head["sign"]         =$sign;
     
      $requestJson["body"]             =$body;
      $requestJson["head"]             =$head;
      $requestPara["requestJson"]   =json_encode($requestJson);
      $resp                        = requestAsHttpPOST($requestPara, submit_url); //发送请求
      
      var_dump($resp);
    }
   //------------------------------------------------------------
    //订单撤销API
    //------------------------------------------------------------
    function test_FrontReverse(){
  
      $head["service"]         ="front.reverse";//订单撤销
      $head["version"]         =version;//默认版本号
      $head["partner_id"]       =partner_id;//联富通线下提供pid
      $head["input_charset"]            = input_charset; //编码格式，默认只支持UTF-8
      $head["core_merchant_no"]            =core_merchant_no;//联富通后台核心商户编号
      $head["sign_type"]            = sign_type;//加密方式，默认只支持MD5

    
      $body["out_trade_no"]            ="EW_N8366110628_0001aaa23111";//商户订单号
      $body["merchant_no"]            ="EW_N8366110628";//门店商户编号
      
      $signArray = array_merge($head, $body);
      $sign=createSign($signArray,partner_key);
      $head["sign"]         =$sign;
     
      $requestJson["body"]             =$body;
      $requestJson["head"]             =$head;
      $requestPara["requestJson"]   =json_encode($requestJson);
      $resp                        = requestAsHttpPOST($requestPara, submit_url); //发送请求
      
      var_dump($resp);
    }
     //------------------------------------------------------------
    //订单关单API
    //------------------------------------------------------------
    function test_FrontClose(){
  
      $head["service"]         ="front.close";//订单关单
      $head["version"]         =version;//默认版本号
      $head["partner_id"]       =partner_id;//联富通线下提供pid
      $head["input_charset"]            = input_charset; //编码格式，默认只支持UTF-8
      $head["core_merchant_no"]            =core_merchant_no;//联富通后台核心商户编号
      $head["sign_type"]            = sign_type;//加密方式，默认只支持MD5

    
      $body["out_trade_no"]            ="EW_N8366110628_0001aaa23111";//商户订单号
      $body["merchant_no"]            ="EW_N8366110628";//门店商户编号
      
      $signArray = array_merge($head, $body);
      $sign=createSign($signArray,partner_key);
      $head["sign"]         =$sign;
     
      $requestJson["body"]             =$body;
      $requestJson["head"]             =$head;
      $requestPara["requestJson"]   =json_encode($requestJson);
      $resp                        = requestAsHttpPOST($requestPara, submit_url); //发送请求
      
      var_dump($resp);
    }

   //------------------------------------------------------------
    //订单退款API
    //------------------------------------------------------------
    function test_FrontRefund(){
  
      $head["service"]         ="front.refund";//订单退款
      $head["version"]         =version;//默认版本号
      $head["partner_id"]       =partner_id;//联富通线下提供pid
      $head["input_charset"]            = input_charset; //编码格式，默认只支持UTF-8
      $head["core_merchant_no"]            =core_merchant_no;//联富通后台核心商户编号
      $head["sign_type"]            = sign_type;//加密方式，默认只支持MD5

      $body["out_trade_no"]            ="EW_N8366110628_0001aaa23111";//商户订单号
      $body["merchant_no"]            ="EW_N8366110628";//门店商户编号
      $body["trade_no"]            ="00060011806081011119020239178664";//交易流水号,支付请求返回结果参数
      $body["out_refund_no"]            ="EW_N8366110628_0001aaa231112";//退款订单号
      $body["refund_fee"]            ="0.01";//退款金额
      $body["refund_reason"]            ="商品已售完";//退款的原因说明
      $body["spbill_create_ip"]            ="123.12.12.123";//终端IP
      
      $signArray = array_merge($head, $body);
      $sign=createSign($signArray,partner_key);
      $head["sign"]         =$sign;
     
      $requestJson["body"]             =$body;
      $requestJson["head"]             =$head;
      $requestPara["requestJson"]   =json_encode($requestJson);
      $resp                        = requestAsHttpPOST($requestPara, submit_url); //发送请求
      
      var_dump($resp);
    }


   //------------------------------------------------------------
    //订单退款查询API
    //------------------------------------------------------------
    function test_FrontRefundQuery(){
  
      $head["service"]         ="front.refundquery";//订单退款查询
      $head["version"]         =version;//默认版本号
      $head["partner_id"]       =partner_id;//联富通线下提供pid
      $head["input_charset"]            = input_charset; //编码格式，默认只支持UTF-8
      $head["core_merchant_no"]            =core_merchant_no;//联富通后台核心商户编号
      $head["sign_type"]            = sign_type;//加密方式，默认只支持MD5

      $body["out_refund_no"]            ="EW_N8366110628_0001aaa231112";//退款订单号
    
      $signArray = array_merge($head, $body);
      $sign=createSign($signArray,partner_key);
      $head["sign"]         =$sign;
     
      $requestJson["body"]             =$body;
      $requestJson["head"]             =$head;
      $requestPara["requestJson"]   =json_encode($requestJson);
      $resp                        = requestAsHttpPOST($requestPara, submit_url); //发送请求
      
      var_dump($resp);
    }
?>

