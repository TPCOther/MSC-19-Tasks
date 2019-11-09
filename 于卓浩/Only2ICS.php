<?php
include_once("./lib/net.func.php");

require_once './vendor/autoload.php';
date_default_timezone_set('Asia/Shanghai');


function createEvt($startTime,$endTime,$title,$loc,$className,$cnt){
    $vEvent = new \Eluceo\iCal\Component\Event();
    $vEvent->setCategories($className);
    $vEvent->setDtStart($startTime);
    $vEvent->setDtEnd($endTime);
    $vEvent->setSummary($title);
    $vEvent->setLocation($loc);
    $vEvent->setUseTimezone(true);
    return $vEvent;
}



$stuID = "20194134";
$schoolCode = "10611";
$pass = "password";


$passClassified = strtoupper(substr(md5($stuID . strtoupper(substr(md5($pass),0,30)) . $schoolCode),0,30));
$data = ["Sel_Type"=>"STU","txt_dsdsdsdjkjkjc"=>$stuID,"efdfdfuuyyuuckjg"=>$passClassified];
$res = post_get_cookie("http://jxgl.cqu.edu.cn/_data/index_login.aspx", $data);
$data2 = [
    "Sel_XNXQ"=> "20190", "rad"=>"on", "px"=>1
];
$res1 = post_with_cookie("http://jxgl.cqu.edu.cn/znpk/Pri_StuSel_rpt.aspx",$data2);
$calHTML = iconv("GBK","UTF-8",$res1);
$dom = new DOMDocument();
@$dom->loadHTML('<?xml encoding="UTF-8">' . $calHTML);
$dom->normalize();
$xpath = new DOMXPath($dom);
$vCalendar = new \Eluceo\iCal\Component\Calendar('author20194134');
$title = null;
$loc = null;
function createClass($weekSt,$weekEd,$weekDay,$classSt,$classEd,$classTitle,$classLoc){
    global $vCalendar;
    $noToTime = [
        1 => [8,30],
        2 => [9,25],
        3 => [10,30],
        4 => [11,25],
        5 => [14,00],
        6 => [14,55],
        7 => [16,00],
        8 => [16,55],
        9 => [19,00],
        10=> [19,55],
        11=> [20,50],
        12=> [21,35]
    ];
    $dua = [
        1 => 55,
        2 => 120,
        4 => 220,
    ];
    $weekInit = "2019-09-02";
    $calcedDays = $weekSt * 7 - 8 + $weekDay;
    $weekCnt = $weekEd - $weekSt + 1;
    //if($weekSt==$weekEd) print_r([$weekSt,$weekEd,$calcedDays,$weekCnt]);
    $timeSt = new \DateTime($weekInit);
    $timeSt -> modify("+{$calcedDays} day");
    $timeSt -> setTime($noToTime[$classSt][0],$noToTime[$classSt][1],0);

    $timeEd = new \DateTime($weekInit);
    $timeEd -> modify("+{$calcedDays} day");
    if($classEd != 4 && $classEd!= 8) $timeEd -> setTime($noToTime[$classEd+1][0],$noToTime[$classEd+1][1],0);
    else if($classEd == 4) $timeEd -> setTime(12,10,0);
    else if($classEd == 8) $timeEd -> setTime(17,40,0);

    $obj1 = createEvt($timeSt,$timeEd,$classTitle,$classLoc,$classTitle,1);
    $vCalendar -> addComponent($obj1);
    $strSt = $timeSt -> format("Y-m-d H:i:s");
    $strEd = $timeEd -> format("Y-m-d H:i:s");
    $data = [];
    if($weekCnt != 1) {
        for($i=1;$i<=$weekCnt-1;$i++) {
            sleep(0.5);
            $calcDays = 7 * $i;
            $timeA = new \DateTime($strSt);
            $timeB = new \DateTime($strEd);
            $timeA -> modify("+{$calcDays} day");
            $timeB -> modify("+{$calcDays} day");
            $obj = createEvt($timeA,$timeB,$classTitle,$classLoc,$classTitle,1);
            $vCalendar -> addComponent($obj);
        }
    }
}
for($i=1;$i<=100;$i++) {
    $href = $xpath->query("/html/body/table[1]/tbody/tr[{$i}]");
    if($href->length == 0) break;
    $oldT = $title;
    $title = $xpath->query("/html/body/table[1]/tbody/tr[{$i}]/td[2]")->item(0)->textContent;
    if($title == NULL) $title = $oldT;
    else $title = explode("]",$title)[1];
    $weeks = $xpath->query("/html/body/table[1]/tbody/tr[{$i}]/td[11]")->item(0)->textContent;
    $claNo = $xpath->query("/html/body/table[1]/tbody/tr[{$i}]/td[12]")->item(0)->textContent;
    $oldL = $loc;
    $loc   = $xpath->query("/html/body/table[1]/tbody/tr[{$i}]/td[13]")->item(0)->textContent;
    if($loc == NULL) $loc = $oldL;
    $evt = null;
    $strToNum = [
        "一"=>1,"二"=>2,"三"=>3,"四"=>4,"五"=>5,"六"=>6,"日"=>7
    ];
    $dayNo = $strToNum[substr($claNo,0,3)];
    $classSt = (int)substr($claNo,4,1);
    $classEd = (int)substr($claNo,6,1);


    if(strlen($weeks) == strlen(str_replace("-","",$weeks))) {
        createClass((int)$weeks,(int)$weeks,$dayNo,$classSt,$classEd,$title,$loc);
    }
    else {
        $weekSt = 0;
        $weekEd = 0;
        if(strlen($weeks) == strlen(str_replace(",","",$weeks))){
            $arr = explode("-",$weeks);
            $weekSt = (int)$arr[0];
            $weekEd = (int)$arr[1];
            createClass($weekSt,$weekEd,$dayNo,$classSt,$classEd,$title,$loc);
        }
        else {
            $arr = explode(",",$weeks);
            foreach ($arr as $str) {
                if(strlen($str) == strlen(str_replace("-","",$str))) {
                    createClass((int)$str,(int)$str,$dayNo,$classSt,$classEd,$title,$loc);
                }
                else {
                    $arr = explode("-",$str);
                    $weekSt = (int)$arr[0];
                    $weekEd = (int)$arr[1];
                    createClass($weekSt,$weekEd,$dayNo,$classSt,$classEd,$title,$loc);
                }
            }
            continue;
        }
    }
}
for($i=1;$i<=100;$i++) {
    $href = $xpath->query("/html/body/table[2]/tbody/tr[{$i}]");
    if($href->length == 0) break;
    $oldT = $title;
    $title = $xpath->query("/html/body/table[2]/tbody/tr[{$i}]/td[2]")->item(0)->textContent;
    if($title == NULL) $title = $oldT;
    else $title = "[实验] " . explode("]",$title)[1];
    $weeks = $xpath->query("/html/body/table[2]/tbody/tr[{$i}]/td[10]")->item(0)->textContent;
    $claNo = $xpath->query("/html/body/table[2]/tbody/tr[{$i}]/td[11]")->item(0)->textContent;
    $oldL = $loc;
    $loc   = $xpath->query("/html/body/table[2]/tbody/tr[{$i}]/td[12]")->item(0)->textContent;
    if($loc == NULL) $loc = $oldL;
    $evt = null;
    $strToNum = [
        "一"=>1,"二"=>2,"三"=>3,"四"=>4,"五"=>5,"六"=>6,"日"=>7
    ];
    $dayNo = $strToNum[substr($claNo,0,3)];
    $classSt = (int)substr($claNo,4,1);
    $classEd = (int)substr($claNo,6,1);
    if(strlen($weeks) == strlen(str_replace("-","",$weeks))) {
        createClass((int)$weeks,(int)$weeks,$dayNo,$classSt,$classEd,$title,$loc);
    }
    else {
        $weekSt = 0;
        $weekEd = 0;
        if(strlen($weeks) == strlen(str_replace(",","",$weeks))){
            $arr = explode("-",$weeks);
            $weekSt = (int)$arr[0];
            $weekEd = (int)$arr[1];
            createClass($weekSt,$weekEd,$dayNo,$classSt,$classEd,$title,$loc);
        }
        else {
            $arr = explode(",",$weeks);
            foreach ($arr as $str) {
                if(strlen($str) == strlen(str_replace("-","",$str))) {
                    createClass((int)$str,(int)$str,$dayNo,$classSt,$classEd,$title,$loc);
                }
                else {
                    $arr = explode("-",$str);
                    $weekSt = (int)$arr[0];
                    $weekEd = (int)$arr[1];
                    createClass($weekSt,$weekEd,$dayNo,$classSt,$classEd,$title,$loc);
                }
            }
            continue;
        }
    }
}
file_put_contents($stuID.".ics",$vCalendar->render());