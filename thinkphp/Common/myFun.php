<?php//截取中文字符串function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true){    if(function_exists("mb_substr"))        return mb_substr($str, $start, $length, $charset);    elseif(function_exists('iconv_substr')) {        return iconv_substr($str,$start,$length,$charset);    }    $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";    preg_match_all($re[$charset], $str, $match);    $slice = join("",array_slice($match[0], $start, $length));    if($suffix) return $slice."…";    return $slice;}function RemoveXSS($val) {    $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);    $search = 'abcdefghijklmnopqrstuvwxyz';    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';    $search .= '1234567890!@#$%^&*()';    $search .= '~`";:?+/={}[]-_|\'\\';    for ($i = 0; $i < strlen($search); $i++) {        // ;? matches the ;, which is optional        // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars        // @ @ search for the hex values        $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;        // @ @ 0{0,7} matches '0' zero to seven times        $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;    }    // now the only remaining whitespace attacks are \t, \n, and \r    $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');    $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');    $ra = array_merge($ra1, $ra2);    $found = true; // keep replacing as long as the previous round replaced something    while ($found == true) {        $val_before = $val;        for ($i = 0; $i < sizeof($ra); $i++) {            $pattern = '/';            for ($j = 0; $j < strlen($ra[$i]); $j++) {                if ($j > 0) {                    $pattern .= '(';                    $pattern .= '(&#[xX]0{0,8}([9ab]);)';                    $pattern .= '|';                    $pattern .= '|(&#0{0,8}([9|10|13]);)';                    $pattern .= ')*';                }                $pattern .= $ra[$i][$j];            }            $pattern .= '/i';            $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag            $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags            if ($val_before == $val) {                // no replacements were made, so exit the loop                $found = false;            }        }    }    return $val;}function guolv($str,$flag=0){    if($flag==1)        return trim(post_check(strip_tags(RemoveXSS($str))));    else        return trim((strip_tags(RemoveXSS($str))));}function IsMail($Argv){    if(ereg("^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+",$Argv)){        return true;    }else{        return false;    }}function IsMobile($Argv){    if(preg_match("/^1[3|4|5|8][0-9]\d{8}$/",$Argv)){        return true;    }else{        return false;    }}function get_url(){   /* $url = (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://';    $url .= $_SERVER['HTTP_HOST'];*/    $url = strtolower($_GET['_URL_'][0]);    if($url=="login"||$url=="register"||$url=="user")    {        //return HTTPS_WEBSITE;        return WEBSITE;    }else    {        return WEBSITE;    }    //return $url;}function urlChange(){    $REQUEST_URI=$_SERVER['REQUEST_URI'];    if(strlen($REQUEST_URI)>80)    {        redirect("/");    }    $url = strtolower($_GET['_URL_'][0]);    $ishttps = (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ? 'https' : 'http';    $current = get_url();    if($url=="login"||$url=="register"||$url=="user")    {        if($ishttps == "http")        {            $current = str_replace("http","https",$current);            toHttps($current.'/'.$url);        }        header('Cache-Control: no-store');        header('Pragma: no-cache');    }else    {        if($ishttps == "https")        {            $current = str_replace("https","http",$current);            toHttp($current.'/'.$url);        }    }}function toHttps($url){    if ($_SERVER["HTTPS"] <> "on")    {        header("Location: ".$url);    }}function toHttp($url){    if ($_SERVER["HTTPS"] == "on")    {        header("Location: ".$url);    }}function nocache(){    $ishttps = (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ? 'https' : 'http';    if($ishttps == "https")    {        echo('<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">');        echo('<META HTTP-EQUIV="Cache-Control" CONTENT="no-store">');        echo('<META HTTP-EQUIV="pragma" CONTENT="no-cache">');    }}/** * 公钥加密 * * @param string 明文 * @param string 证书文件（.crt） * @return string 密文（base64编码） */function publickey_encodeing($sourcestr, $fileName){    $key_content = file_get_contents($fileName);    $pubkeyid    = openssl_get_publickey($key_content);    if (openssl_public_encrypt($sourcestr, $crypttext, $pubkeyid))    {        return base64_encode("" . $crypttext);    }    return False;}/** * 私钥解密 * * @param string 密文（base64编码） * @param string 密钥文件（.pem） * @param string 密文是否来源于JS的RSA加密 * @return string 明文 */function privatekey_decodeing($crypttext, $fileName,$fromjs = FALSE){    $key_content = file_get_contents($fileName);    $prikeyid    = openssl_get_privatekey($key_content);    $crypttext   = base64_decode($crypttext);    $padding = $fromjs ? OPENSSL_NO_PADDING : OPENSSL_PKCS1_PADDING;    if (openssl_private_decrypt($crypttext, $sourcestr, $prikeyid, $padding))    {        return $fromjs ? rtrim(strrev($sourcestr), "\0") : "".$sourcestr;    }    return FALSE;}function inject_check($sql_str) {    $check=preg_match('/select|insert|update|delete|\'|\\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/i',$sql_str);    if ($check) {        return false;    }else{        return true;;    }}function dowith_sql($str){    $str = str_replace("and","",$str);    $str = str_replace("execute","",$str);    $str = str_replace("update","",$str);    $str = str_replace("count","",$str);    $str = str_replace("chr","",$str);    $str = str_replace("mid","",$str);    $str = str_replace("master","",$str);    $str = str_replace("truncate","",$str);    $str = str_replace("char","",$str);    $str = str_replace("declare","",$str);    $str = str_replace("select","",$str);    $str = str_replace("create","",$str);    $str = str_replace("delete","",$str);    $str = str_replace("insert","",$str);    $str = str_replace("'","",$str);    $str = str_replace('"',"",$str);   $str = str_replace(" ","",$str);   $str = str_replace("or","",$str);   $str = str_replace("=","",$str);   $str = str_replace(" ","",$str);   return $str;}function post_check($post){    if (!get_magic_quotes_gpc())    {        $post = addslashes($post);    }    $post = str_replace("_", "\_", $post);    $post = str_replace("%", "\%", $post);    return $post;}/*function get_client_ip($type = 0){    $type = $type ? 1 : 0;    static $ip = NULL;    if ($ip !== NULL) return $ip[$type];    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);        $pos = array_search('unknown', $arr);        if (false !== $pos) unset($arr[$pos]);        $ip = trim($arr[0]);    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {        $ip = $_SERVER['HTTP_CLIENT_IP'];    } elseif (isset($_SERVER['REMOTE_ADDR'])) {        $ip = $_SERVER['REMOTE_ADDR'];    }}*/function build_order_no($id){    $pre = sprintf('%02d', $id / 14000000);// 每1400万的前缀    // 这里乘以 123456789 一是一看就知道是9位长度，二则是产生的数字比较乱便于隐蔽    $tempcode = sprintf('%09d', sin(($id % 14000000 + 1) / 10000000.0) * 123456789);    $seq = '371482506';// 这里定义 0-8 九个数字用于打乱得到的code    $code = '';    for ($i = 0; $i < 9; $i++)    {        $code .= $tempcode[ $seq[$i] ];    }    return $pre.$code;}