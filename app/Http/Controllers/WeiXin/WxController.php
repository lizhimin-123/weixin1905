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

    public function receiv()
    {
        $log="wechat.log";
        $xml_str=file_get_contents("php://input");
        //将接收的数据记录到日志文件
        $data= date('Y-m-d H:i:s') . $xml_str;
        file_put_contents($log,$data,FILE_APPEND);
        $xml_obj=simplexml_load_string($xml_str);//处理xml数据

        $event=$xml_obj->Event;//获取事件类型
        if ($event=='subscribe') {
            $openid=$xml_obj->FromUserName;//获取用户的openid
            /*获取用户信息*/
            $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->access_token."&openid=".$openid."&lang=zh_CN";
            $user_info=file_get_contents($url);
            file_put_contents('wechat.log,$user_info,FILE_APPEND');
            $data=json_decode($user_info,true);
            $nickname=$data['nickname'];
            $user=WechatModel::where(['openid'=>$openid])->first();
            if ($user) {
                //欢迎回家
                echo "欢迎".$nickname."回家";die;
            }else{
                $data=[
                    'openid'=> $openid,
                    'subscribe_time'=>$xml_obj->CreateTime,
                    'nickname'=>$data['nickname'],
                    'sex'=>$data['sex'],
                ];
                //信息入库
                $uid=WechatModel::insertGetId($data);
                echo "欢迎".$nickname."首次关注成功";
//                var_dump($uid);
//                die;
            }
        }

        //判断消息类型
        $msg_type=$xml_obj->MsgType;

        $touser=$xml_obj->FromUserName;//接收消息的用户的openid
        $fromuser=$xml_obj->ToUserName;//开发者公众号的ID
        $time=time();
        if ($msg_type=="text") {
            $content="现在是格林威治时间" . date('Y-m-d H:i:s') . "，您发送的内容是：" . $xml_obj->Content;
            $response_text=
                '<xml>
                  <ToUserName><![CDATA['.$touser.']]></ToUserName>
                  <FromUserName><![CDATA['.$fromuser.']]></FromUserName>
                  <CreateTime>'.$time.'</CreateTime>
                  <MsgType><![CDATA[text]]></MsgType>
                  <Content><![CDATA['.$content.']]></Content>
            </xml>';
            echo $response_text;
        }
    }


//     public function receiv(){
//         $log_file = "wx.log";
//         $xml = file_get_contents("php://input");
//         //将接收的数据记录到日志文件
//         $data = date('Y-m-d H:i:s') . $xml;
//
//         file_put_contents($log_file,$data,FILE_APPEND);
//
//         //处理xml数据
//         $xml_arr = simplexml_load_string($xml);
//     }
    /***
     * 获取用户基本信息
     */
    public function getUserInfo(){
        $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN";
    }
}
