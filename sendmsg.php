<?php
$cust_code = '403116';									//�˺�
$password = '3935ZZ5CBN';						//����
$sp_code = '';										//��չ��
$content = '��ӭ������ʿ���ι����ײͣ���֤��1898��';					//��������
$destMobiles = '18964991967,15950596785';	 						//�ֻ����룬ʹ�ö��Ÿ������Է��Ͷ������
$url='http://218.207.201.185:8860/';												//URL��ַ
$post_data = array();
$post_data['cust_code'] = $cust_code;																	
$post_data['destMobiles'] = $destMobiles;									
$post_data['content'] =  mb_convert_encoding($content, 'utf-8', 'gb2312');
$post_data['sign'] = md5(urlencode(mb_convert_encoding($content, 'utf-8', 'gb2312').$password));								//ǩ��
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
//Ϊ��֧��cookie
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);

$result = curl_exec($ch);
curl_close($ch);

?>