<?php
$cust_code = '403116';									//账号
$password = '3935ZZ5CBN';						//密码
$sp_code = '';										//扩展码
$content = '欢迎订购迪士尼梦工厂套餐，验证码1898。';					//发送内容
$destMobiles = '18964991967,15950596785';	 						//手机号码，使用逗号隔开可以发送多个号码
$url='http://218.207.201.185:8860/';												//URL地址
$post_data = array();
$post_data['cust_code'] = $cust_code;																	
$post_data['destMobiles'] = $destMobiles;									
$post_data['content'] =  mb_convert_encoding($content, 'utf-8', 'gb2312');
$post_data['sign'] = md5(urlencode(mb_convert_encoding($content, 'utf-8', 'gb2312').$password));								//签名
$post_data['sp_code'] = $sp_code;	
$o="";
foreach ($post_data as $k=>$v)
{
		if($k =='content')
    $o.= "$k=".urlencode($v)."&";
    else
    $o.= "$k=".($v)."&";
}
$post_data=substr($o,0,-1);
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_URL,$url);
//为了支持cookie
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);

$result = curl_exec($ch);
curl_close($ch);

?>