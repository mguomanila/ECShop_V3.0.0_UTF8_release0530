<?php
/**
 * wechat php test
 */

//define your token
define("TOKEN", "oryigo");
define('APP_ID', 'wxee3c3c62ad040e31'); //改成自己的APPID
define('APP_SECRET', '9a9dd693df5b2d572429156f2c5ffd77'); //改成自己的APPSECRET
$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
        $a = $this->get_access_token();
        echo $a;
        // $this->delmenu($a);
        // $this->createmenu($a);
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)) {
            
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
            the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj            = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $this->fromUsername = $postObj->FromUserName;
            $this->toUsername   = $postObj->ToUserName;
            $this->keyword      = trim($postObj->Content);
            $this->time         = time();
            $MsgType            = $postObj->MsgType; //消息类型
            $EventKey           = $postObj->EventKey; //菜单的自定义的key值，可以根据此值判断用户点击了什么内容，从而推送不同信息
            $textTpl            = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>0</FuncFlag>
        </xml>";
            if ($MsgType == 'event') {
                $MsgEvent = $postObj->Event;
                // print_r($MsgEvent);
                if ($MsgEvent == 'subscribe') {
                    $arr[] = "你好，欢迎关注成都沃儿迅公众号！";
                    echo $this->callbackText($arr);
                    exit;
                }
                if ($MsgEvent == 'CLICK') {
                    switch ($EventKey) {
                        case 'bd':
                            $bd[0]['title']       = '百度';
                            $bd[0]['Description'] = '搜索引擎';
                            $bd[0]['picurl']      = 'https://ss0.bdstatic.com/94oJfD_bAAcT8t7mm9GUKT-xh_/timg?image&quality=100&size=b4000_4000&sec=1467685413&di=fdbf149c761c71799c2fde8cc247a0f5&src=http://www.qqtn.com/up/2010-9/2010916141442789.jpg';
                            $bd[0]['url']         = 'http://www.baidu.com/';
                            $k                    = $this->callbackNews($bd);
                            echo ($k);
                            break;
                    }
                }
            }
            if ($MsgType == 'text') {
                $Content = $this->keyword;
                if ($Content == '你好吗') {
                    $str[] = '我很好！';
                    echo $this->callbackText($str);
                    exit;
                }
            }

            if (!empty($keyword)) {
                $msgType    = "text";
                $contentStr = "Welcome to wechat world!";
                $resultStr  = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            } else {
                echo "Input something...";
            }

        } else {
            echo "";
            exit;
        }
    }

/**
 * 获取access_token
 */
    private function get_access_token()
    {
        $url  = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . APP_ID . "&secret=" . APP_SECRET;
        $data = json_decode(pata($url, array()), true);
        if ($data['access_token']) {
            return $data['access_token'];
        } else {
            return "获取access_token错误";
        }
    }
    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];

        $token  = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

/**
 *回复图文
 *@param $data  已获取的图文数组
 */
    private function callbackNews($data)
    {
        $time  = time();
        $count = count($data);
        if ($count <= 10) {
            $header = "<xml>
        <ToUserName><![CDATA[" . $this->fromUsername . "]]></ToUserName>
        <FromUserName><![CDATA[" . $this->toUsername . "]]></FromUserName>
        <CreateTime>" . $time . "</CreateTime>
        <MsgType><![CDATA[news]]></MsgType>
        <ArticleCount>" . $count . "</ArticleCount>
        <Articles>";
            foreach ($data as $k => $value) {
                $content .= "
                <item>
                    <Title><![CDATA[" . $value['title'] . "]]></Title>
                    <Description><![CDATA[" . $value['Description'] . "]]></Description>
                    <PicUrl><![CDATA[" . $value['picurl'] . "]]></PicUrl>
                    <Url><![CDATA[" . $value['url'] . "]]></Url>
                </item>";
            }
            $footer = "
        </Articles>
        <FuncFlag>1</FuncFlag>
    </xml>";
            return $header . $content . $footer;
        } else {
            $erro[]    = "图文不能超过10条";
            $resultStr = $this->callbackText($erro);
            return $resultStr;
        }
    }

    /**
     *回复文本
     *@param $data  已获取的文本数组
     */
    private function callbackText($data)
    {
        foreach ($data as $k => $v) {
            $s .= $v . "\n";
        }
        $text = "<xml>
        <ToUserName><![CDATA[" . $this->fromUsername . "]]></ToUserName>
        <FromUserName><![CDATA[" . $this->toUsername . "]]></FromUserName>
        <CreateTime>" . $this->time . "</CreateTime>
        <MsgType><![CDATA[text]]></MsgType>
        <Content><![CDATA[" . $s . "]]></Content>
        <FuncFlag>0</FuncFlag>
    </xml>";
        return $text;
    }
//     private function callbackText_loca()
    //     {

//         $text = "<xml>
    //     <ToUserName><![CDATA[" . $this->fromUsername . "]]></ToUserName>
    //     <FromUserName><![CDATA[" . $this->toUsername . "]]></FromUserName>
    //     <CreateTime>" . $this->time . "</CreateTime>
    //     <MsgType><![CDATA[text]]></MsgType>
    //     <Event><![CDATA[" . $postObj->Event . "]]></Event>
    //     <Latitude>" . $postObj->Latitude . "</Latitude>
    //     <Longitude>" . $postObj->Longitude . "</Longitude>
    //     <Precision>" . $postObj->Precision . "</Precision>
    // </xml>";
    //         return $text;
    //     }

/**
 * 创建菜单
 * @param $access_token 已获取的ACCESS_TOKEN
 */
public function createmenu($tok)
    {
        $url  = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $tok;
        $menu ='
      {
     "button":[
     {  
          "type":"click",
               "name":"点赞我们",
               "key":"V1001_GOOD"
      },
      {
           "type":"view",
               "name":"在线商城",
               "url":"http://www.oryigo.com/"
       }]
 }';
        $abc = pata($url, $menu);
        return $abc;
    }

    /**
     * 删除菜单
     * @param $access_token 已获取的ACCESS_TOKEN
     */
    public function delmenu($tk)
    {
        $url  = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=" . $tk;
        $data = json_decode(pata($url, array()), true);
        if ($data['errcode'] == 0) {
            return true;
        } else {
            return false;
        }
    }

}
/**
 *服务器推送URL(POST)
 *$param $url 推送地址 $data 推送数据
 */
function pata($url, $data)
{
    $ch      = curl_init();
    $timeout = 300;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $handles = curl_exec($ch);
    if (curl_errno($ch)) {
        return curl_error($ch);
    }
    curl_close($ch);
    return $handles;
}
/**
 *服务器推送URL(GET)
 */
function pata_get($url, $data)
{
    $ch      = curl_init();
    $timeout = 300;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    //curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $handles = curl_exec($ch);
    if (curl_errno($ch)) {
        return curl_error($ch);
    }
    curl_close($ch);
    return $handles;
}
