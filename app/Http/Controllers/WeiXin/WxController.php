<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WxController extends Controller
{

    /**
     * 处理接入
     */
    public function index()
    {
        $token = 'token';       //开发提前设置好的 token
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $echostr = $_GET["echostr"];



        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );



        if( $tmpStr == $signature ){        //验证通过
            echo $echostr;
        }else{
            die("not ok");
        }
    }

    /**
     * 接收微信推送事件
     */
     public function receiv(){
         $log_file = "wx.log";
         $xml = file_get_contents("php://input");
         //将接收的数据记录到日志文件
         $data = data('Y-m-d H:i:s') . $xml;
         file_put_contents($log_file,$data,FILE_APPEND);
     }
    /***
     * 获取用户基本信息
     */
    public function getUserInfo(){
        $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN";
    }
}
