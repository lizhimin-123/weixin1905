<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoteController extends Controller
{
    //
    public function index(){
       echo '<pre>';print_r($_GET);echo'</pre>';die;
       $code = $_GET['code'];
       //获取access_token
        $this->getAccessToken($code);
    }

    /**
     * 根据code获取access_token
     * @param $code
     */
    protected function getAccessToken($code){
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('APPID').'&secret='.env('APPSECRET').'&code='.$code.'&grant_type=authorization_code';
        $json_data=file_get_contents($url);
        $data=json_encode($json_data,true);
        echo '<pre>';print_r($data);echo'</pre>';
    }
}
