<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class VoteController extends Controller
{
    //
    public function index(){
       //echo '<pre>';print_r($_GET);echo'</pre>';
       $code = $_GET['code'];
       //获取access_token
        $data=$this->getAccessToken($code);
        //dd($data);
        //获取用户信息
        $user_info = $this ->getUserInfo($data['access_token'],$data['openid']);

        //处理业务逻辑
        $openid = $user_info['openid'];
        $key = 's:vote:lizhimin';
        //  TODO 判断是否已经投过 集合或有序集合
        if (Redis::zrank($key,$user_info['openid'])){
            echo "已经投过票了";
        }else{
            Redis::Zadd($key,time(),$openid);
        }

        $members = Redis::zRange($key,0,-1,true); //获取所有投票人数的openid
        echo '<pre>';print_r($members);echo'</pre>';
        foreach ($members as $k=>$v) {
            echo "用户: ".$k.'投票时间: '.date('Y-m-d H:i:s',$v);echo '</br>';
        }


        //        $total=Redis::Scard($key); //统计投票人数
        //        echo "投票人数:".$total;
        //        echo "<hr>";
        //        echo "<pre>";print_r($members);echo"</pre>";

        //        $redis_key = 'vote';
        //        $number = Redis::incr($redis_key);
        //        echo "投票成功,当前票数".$number;
    }

    /**
     * 根据code获取access_token
     * @param $code
     */

    protected function getAccessToken($code)
    {
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('APPID').'&secret='.env('APPSECRET').'&code='.$code.'&grant_type=authorization_code';
        $json_data = file_get_contents($url);
        return json_decode($json_data,true);
    }

    /**
     * 获取用户基本信息
     * @param $access_token
     * @param $openid
     * @return mixed
     */

    protected function getUserInfo($access_token,$openid){
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='. $access_token .'&openid='.$openid.'&lang=zh_CN';
        $json_data=file_get_contents($url);
        $data=json_decode($json_data,true);
//        echo '<pre>';print_r($data);echo'</pre>';
        if (isset($data['errcode'])){
            //TODO 错误处理
                die('出错了 40001');
        }
        return $data;
    }
}
