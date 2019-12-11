<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
//    public function admin(){
//    	echo "123abc";
//    }
    public function  admin(Request $request)
    {
        $echostr = $request -> input('echostr');
        echo $echostr;die;
    }
    public function xmlTest(){
        $xml_str = "<xml><ToUserName><![CDATA[gh_6baa97ba6825]]></ToUserName>
<FromUserName><![CDATA[oXPAvwhG7EbVGDwpFjAPXDLfa6fc]]></FromUserName>
<CreateTime>1576051634</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[111]]></Content>
<MsgId>22563633300297302</MsgId>
</xml>";
        $xml_obj= simplexml_load_string($xml_str);
        echo '<pre>';print_r($xml_obj);echo'</pre>';echo"<hr>";

        echo "ToUserName:".$xml_obj->ToUserName;echo "<br>";
        echo "FromUserName:".$xml_obj->FromUserName;echo "<br>";
    }
}
