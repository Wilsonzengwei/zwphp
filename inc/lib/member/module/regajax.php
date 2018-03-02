<?php
    $districtNumber=$_POST['districtNumber'];
    if($districtNumber!=='0086'){//区号如果不为0086
        function PostCURL($url,$post_data)
    {
        try {
            $attributes = array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8','Expect:','Connection: Close');//请求属性
            $ch = curl_init();//初始化一个会话
            /* 设置验证方式 */
            curl_setopt($ch, CURLOPT_HTTPHEADER, $attributes);//设置访问
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//设置返回结果为流
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);//设置请求超时时间
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);//设置响应超时时间
            /* 设置通信方式 */
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);//使用urlencode格式请求
            
            $result = curl_exec($ch);//获取返回结果集
            $result=preg_replace('/\"msgid":(\d{1,})./', '"msgid":"\\1",', $result);//正则表达式匹配所有msgid转化为字符串
            $result = json_decode($result, true);//将返回结果集json格式解析转化为数组格式
            if (curl_errno($ch) !== 0) //网络问题请求失败
            {
                $result['result'] = $this->ERROR_310099;
                curl_close($ch);//关闭请求会话
                return $result;
            } else {
                $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($statusCode != 200)//域名问题请求失败
                {
                    $result['result'] = $this->ERROR_310099;
                }
                curl_close($ch);//关闭请求会话
                return $result;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());//打印捕获的异常消息
            $result['result'] = $this->ERROR_310099;//返回http请求错误代码
            return $result;
        }
    }
    function encrypt_content($content)
    {
        try {
            return urlencode(iconv('UTF-8', 'GBK', $content));//短信内容转化为GBK格式再进行urlencode格式加密
        }catch (Exception $e) {
            print_r($e->getMessage());  //输出捕获的异常消息
        }
    }

        $url = 'http://61.145.229.28:8803/sms/v2/std/single_send';
        $userid="GJ0117";
        $pwd_1="159369";
        $mobile  = $_POST['districtNumber'].$_POST['mobile'];
        $string = "00000000";
        $timestamp= time();    
        $pwd = md5($userid.$string.$pwd_1.$timestamp);       
        $content = encrypt_content($_POST['content']);
        $post_data= "userid=".$userid."&pwd=".$pwd."&mobile=".$mobile."&content=".$content."&timestamp=".$timestamp;
        $c=PostCURL($url, $post_data);
        $result=json_encode($c);
        echo $result;
    }
    else{       
        $userId="JS5275";
        $password="159369";
        $pszMobis=$_POST['districtNumber'].$_POST['mobile'];       
        $pszMsg=$_POST['content'];
        $iMobiCount=15;
        $pszSubPort="*";
        $url="http://TSC3.800CT.COM:8086/MWGate/wmgw.asmx/MongateSendSubmit?userId=".$userId."&password=".$password."&pszMobis=".$pszMobis."&pszMsg=".$pszMsg."&iMobiCount=".$iMobiCount."&pszSubPort=*";
        $data=file_get_contents($url);
        echo $data;            
    }   
?>