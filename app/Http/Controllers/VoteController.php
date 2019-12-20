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
        //获取用户信息
        $user_info = $this ->getUserInfo($data['access_token'],$data['option']);
        //处理业务逻辑
        $redis_key = 'vote';
        $number = Redis::incr($redis_key);
        echo "投票成功,当前票数".$number;
    }

    /**
     * 根据code获取access_token
     * @param $code
     */
    protected function getAccessToken($code){
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('APPID').'&secret='.env('APPSECRET').'&code='.$code.'&grant_type=authorization_code';
        $json_data=file_get_contents($url);
        $data=json_encode($json_data,true);
//        echo '<pre>';print_r($data);echo'</pre>';
        if (isset($data['errcode'])){
            //TODO 错误处理
                die('出错了 40001');
        }
        return $data;
    }
}
