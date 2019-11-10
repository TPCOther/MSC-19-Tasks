<?php
/**
 * @param $durl
 * @return bool|string
 */
function H_get($durl){
        $headers = array(
            "token:1111111111111",
            "over_time:22222222222",
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $durl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true) ;
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true) ;
        // 添加头信息
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }

    /**
     * @param $durl
     * @param $post_data
     * @return bool|string
     */
    function H_post($durl, $post_data){
        $headers = array(
            "token:1111111111111",
            "over_time:22222222222",
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $durl);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }
    function H_post_json($durl, $post_data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $durl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($post_data))
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }
function send_post($url, $post_data,$method='POST') {
    $postdata = http_build_query($post_data);
    $options = array(
        'http' => array(
            'method' => $method, //or GET
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => $postdata,
            'timeout' => 3 * 60 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}

function request_post($url, $data){
    $ch = curl_init();
    $header=array();
    $header[]='Content-Type: application/json; charset=utf-8';
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $tmpInfo = curl_exec($ch);
    if (curl_errno($ch)) {
        return false;
    }else{
        return $tmpInfo;
    }
}
$cookieSuccess = dirname(__FILE__)."/1769.tmp";

function post_get_cookie($url,$data){
    global $cookieSuccess;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieVerify);
//curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
    curl_setopt($ch, CURLOPT_POST, true);
    $headers_login = array("User-Agent" => "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36");
    $fields_string = "";
    foreach($data as $key => $value){
        $fields_string .= $key . "=" . $value . "&";
    }
    $fields_string = rtrim($fields_string , "&");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_login);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieSuccess);//用来存放登录成功的cookie
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result= curl_exec($ch);
    curl_close($ch);
    return $result;
}

function post_with_cookie($url,$data)
{
    global $cookieSuccess;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieVerify);
//curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
    curl_setopt($ch, CURLOPT_POST, true);
    $headers_login = array("User-Agent" => "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36");
    $fields_string = "";
    foreach($data as $key => $value){
        $fields_string .= $key . "=" . $value . "&";
    }
    $fields_string = rtrim($fields_string , "&");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_login);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieSuccess);//用来存放登录成功的cookie
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result= curl_exec($ch);
    curl_close($ch);
    return $result;
}