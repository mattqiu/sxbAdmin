<?php
/**
 *   分页函数
 * @param int $allrow 总记录数
 * @param int $row    取多少条记录
 * @param str $param  url后面要带的参数 如:index.php?q=aa&p=1  默认为 ? 组合的url 例: index.php?p=1
 * @param str $index  锚点  即跳转到下一个页面时 页面会垂直滚动 $index 这个锚点
 *                    return array
 */
function page($allrow, $row = 24, $url = '', $param = '?', $index = '') {
    $p = isset($_REQUEST['p']) ? intval($_REQUEST['p']) : 1;
    $size = isset($_REQUEST['row']) ? intval($_REQUEST['row']) : $row;
    $allpage = ceil($allrow / $size);
    $p1 = $p;
    if($allpage > $p) {
        $next = $p + 1;
    } else {
        $next = $allpage;
    }
    $next = $allpage > $p ? $p + 1 : $allpage;
    $prev = $p1 > 1 ? $p1 - 1 : 1;

    $start = $size * ($p - 1);

    //组合 url 
    $index = $index ? '&#' . $index : '';
    $url = $url . $param . 'p=';
    $first_url = $url . '1' . $index;
    $last_url = $url . $allpage . $index;
    $prev_url = $url . $prev . $index;
    $next_url = $url . $next . $index;

    return array('allpage' => $allpage, 'count' => $allrow, 'page' => $p, 'start' => $start, 'size' => $size, 'first_url' => $first_url, 'prev_url' => $prev_url, 'next_url' => $next_url, 'last_url' => $last_url);
}

/** 自定义跨项目调用模块函数
 *  替换原系统的R函数
 *
 */
function Rimport($classname) {
    $file = './bbulsearch/Lib/Action/' . $classname . 'Action.class.php';
    if(file_exists($file)) {
        require_once($file);
    } else {
        echo $classname . '模块不存在';

    }
}

/**
 * 生成又拍云签名
 * @param array $data 可选参数 ： save-key，return-url， notify-url
 * @return array
 */
function getUpyunSign($conf = array()) {
    $result = array('policy' => '', 'sign' => '');
    $path = '/Public/';

//    $bucket = 'mhimages';
    $bucket = 'mh-images';

    // 表单 API 验证密匙：需要访问又拍云管理后台的空间管理页面获取
//    $form_api_secret = 'VTHDdQoGtlLrWODx9OpN6Ft3e40=';
    $form_api_secret = 'VWZ6gU+5GkfC1X7Ik9sxCs+/QEE=';


    $options = array();
    $options['bucket'] = $bucket;

    // 授权过期时间：以页面加载完毕开始计时，10分钟内有效
    $options['expiration'] = time() + 6000;

    if(isset($conf['path'])) {
        $path .= $conf['path'] . '/';
    }

    $options['save-key'] = $path . '{year}/{mon}/{day}/{filemd5}{.suffix}';
    //        $data['save-key'] = '/{day}/{filemd5}{.suffix}';

    //    // 保存路径：最终将以"/年/月/日/upload_待上传文件名"的形式进行保存
    //    $options['save-key'] = '/{year}/{mon}/{day}/upload_{filename}{.suffix}';

    // 文件类型限制：仅允许上传扩展名为 jpg,gif,png 三种类型的文件
    $options['allow-file-type'] = 'jpg,gif,png';

    //    // 图片宽度限制：仅允许上传宽度在 0～1024px 范围的图片文件
    //    $options['image-width-range'] = '0,1024';
    //
    //    // 图片高度限制：仅允许上传高度在 0～1024px 范围的图片文件
    //    $options['image-height-range'] = '0,1024';

    //   $options['return-url'] = U('Tools/upyunReturn');
    $options['return-url'] = 'http://www.shipinmmm.com/admin.php/Tools/upyunReturn';

    if(isset($conf['notify-url'])) {
        $options['notify-url'] = $conf['notify-url'];
    }

    // 计算 policy 内容，具体说明请参阅"Policy 内容详解"
    $policy = base64_encode(json_encode($options));

    // 计算签名值，具体说明请参阅"Signature 签名"
    $signature = md5($policy . '&' . $form_api_secret);

    // 计算 policy 内容，具体说明请参阅"Policy 内容详解"
    $result['policy'] = $policy;
    // 计算签名值，具体说明请参阅"Signature 签名"
    $result['sign'] = $signature;

    return $result;
}

/**
 * 创建又拍云目录
 * @param $path
 */
function createUpYunDir($path, $bucket = 'mh-images'){
    // 在 demobucket 空间根目录下创建一个 dir 的目录
    $process = curl_init('http://v0.api.upyun.com/' . $bucket . '/' . $path . '/');

    curl_setopt($process, CURLOPT_POST, 1);
    curl_setopt($process, CURLOPT_POSTFIELDS, '');

    // 设置需要创建目录
    curl_setopt($process, CURLOPT_HTTPHEADER, array( 'Expect:', 'folder: true'));

    curl_setopt($process, CURLOPT_USERPWD, "chrisying:m99h88*$");
    curl_setopt($process, CURLOPT_HEADER, 1);
    curl_setopt($process, CURLOPT_TIMEOUT, 60);
    curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);

    curl_exec($process);
    curl_getinfo($process, CURLINFO_HTTP_CODE);

    curl_close($process);
}

/**
 * 上传图片文件到又拍云
 */
function uploadToUpYum($path, $localPath, $bucket = 'shipinmmm-img'){
    // 保存文件到 demobucket 空间的根目录下
//    $process = curl_init('http://v0.api.upyun.com/demobucket/a.txt');
    $process = curl_init('http://v0.api.upyun.com/' . $bucket . $path);

    // 上传操作
    curl_setopt($process, CURLOPT_PUT, 1);
    curl_setopt($process, CURLOPT_USERPWD, "spchris:sp&98chris123");
    curl_setopt($process, CURLOPT_HEADER, 1);
    curl_setopt($process, CURLOPT_TIMEOUT, 60);

    // 本地待上传的文件
//    $local_file_path = "/tmp/sample.txt";
    $local_file_path = $localPath;
    $datas = fopen($local_file_path,'r');
    fseek($datas, 0, SEEK_END);
    $file_length = ftell($datas);
    fseek($datas, 0);

    // 设置待上传的内容
    curl_setopt($process, CURLOPT_INFILE, $datas);

    // 设置待上传的长度
    curl_setopt($process, CURLOPT_INFILESIZE, $file_length);

    // 设置自动创建父级目录
    curl_setopt($process, CURLOPT_HTTPHEADER, array("Expect:", "mkdir: true"));
    curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);

    curl_exec($process);
    curl_getinfo($process, CURLINFO_HTTP_CODE);

    curl_close($process);
    fclose($datas);
}

function thinkSendMail($to, $name = '时品网客服', $subject = '', $body = '', $attachment = null) {
    $config = C('THINK_EMAIL');
    vendor('PHPMailer.class#phpmailer');
    $mail = new PHPMailer();
    $mail->SMTPAuth = true;
    $mail->CharSet = 'UTF-8';
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = $config['SMTP_HOST'];
    $mail->Port = $config['SMTP_PORT'];
    $mail->Username = $config['SMTP_USER'];
    $mail->Password = $config['SMTP_PASS'];
    $mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
    $replyEmail = $config['REPLY_EMAIL'] ? $config['REPLY_EMAIL'] : $config['FROM_EMAIL'];
    $replyName = $config['REPLY_NAME'] ? $config['REPLY_NAME'] : $config['FROM_NAME'];
    $mail->AddReplyTo($replyEmail, $replyName);
    $mail->Subject = $subject;
    $mail->MsgHTML($body);
    $mail->AddAddress($to, $name);
    if(is_array($attachment)) {
        foreach ($attachment as $file) {
            is_file($file) && $mail->AddAttachment($file);
        }
    }

    return $mail->Send() ? true : $mail->ErrorInfo;
}

/**
 * 导入品牌目录下的品牌及flash场次图片到临时表中
 * @param $dir
 */
function getBrandFlashImageDir($dir){
    $importBrandM = M('import_brand_name');
    $importImgM = M('import_brand_img');

    if(is_dir($dir)) {
        if($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                $thisDepth = getDirDepth($dir);
                if((is_dir($dir . "/" . $file)) && $file != "." && $file != "..") {

                    //与初始化的深度相同，即品牌目录
                    if($thisDepth == FIRST_BRAND_PATH_DEPTH) {
                        $data = array();
                        $data['name'] = htmlspecialchars($file);
                        $isHave = $importBrandM->where('name = "' . $data['name'] . '"')->find();
                        if(!$isHave){
                            $bId = $importBrandM->add($data);
                        } else {
                            $bId = $isHave['id'];
                        }
//                        createUpYunDir($target . md5($file));
//                        createUpYunDir($target . md5($file) . '/' . $file);
                        $_SESSION['this_brand_name'] = $bId;
                    }

                    getBrandFlashImageDir($dir . "/" . $file . "/");
                } else {
                    if($file != "." && $file != "..") {
                        $fileArr = explode('.', $file);
                        if(in_array(strtolower($fileArr[1]), array('jpg', 'gif', 'png'))){
                            $isHaveImg = $importImgM->where('b_id = ' . $_SESSION['this_brand_name'] . ' AND name = "' . $file . '"')->find();

                            if(!$isHaveImg){
                                $data = array();
                                $data['b_id'] = $_SESSION['this_brand_name'];
                                $data['name'] = htmlspecialchars($file);
                                $importImgM->add($data);
                            }
                        }
                    }
                }
            }
            closedir($dh);
        }
    }
}

function getBrandImageDir($dir, $target) {
    $importBrand = M('import_brand');
    $importGoods = M('import_goods');
    $improtImgM = M('import_goods_img');
    $brandM = M('brand');
    $detailsM = M('details');
    $detailsSizeM = M('details_size');

    if(is_dir($dir)) {
        if($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                $thisDepth = getDirDepth($dir);
                if((is_dir($dir . "/" . $file)) && $file != "." && $file != "..") {

                    //与初始化的深度相同，即品牌目录
                    if($thisDepth == FIRST_PATH_DEPTH) {
                        $data = array();
                        $data['name'] = $file;
                        $isHaveBrand = $brandM->where('name = "' . $file . '"')->find();
                        if(!empty($isHave)){
                            $data['status'] = 1;
                        }

                        $isHave = $importBrand->where('name = "' . $file . '"')->find();
                        if(!$isHave){
                            $bId = $importBrand->add($data);
                        } else {
                            $bId = $isHave['id'];
                        }

                        $_SESSION['this_brand'] = $bId;

                        //在又拍云下建立md5(品牌名)目录及以品牌名命名的子目录, 便于上传商品图片时辨认
                        createUpYunDir($target . md5($file));
                        createUpYunDir($target . md5($file) . '/' . $file);

                    } else if($thisDepth == (FIRST_PATH_DEPTH + 1)) {
                        //商品目录
                        $data = array();
                        $data['b_id'] = $_SESSION['this_brand'];
                        $data['goods_sn'] = $file;
                        $isHaveGoods = $importGoods->where('goods_sn = "' . $file . '"')->find();

                        $goodsSnArr = explode('+', $file);
                        if(count($goodsSnArr) != '2'){
                            //如果是以“-”分隔的
                            $goodsSnArr = explode('-', $file);
                        }

                        $_SESSION['this_goods_sn'] = $goodsSnArr[0];
                        $_SESSION['this_goods_color_num'] = $goodsSnArr[1];

                        if(!$isHaveGoods){
                            //根据厂家货号和厂家颜色代码
                            $sizeWhere = 'factory_num = "' . $goodsSnArr[0] . '" AND factory_color_num = "' . $goodsSnArr[1] . '"';
                            $detailSize = $detailsSizeM->where($sizeWhere)->select();
                            if(!empty($detailSize)) {
                                $data['status'] = 1;
                            }

                            $data['detail_sn'] = $goodsSnArr[0];
                            $data['detail_color_num'] =$goodsSnArr[1];
                            $_SESSION['this_goods'] = $importGoods->add($data);

                        } else {
                            //如果已经存在此款商品,则直接跳过
                            $_SESSION['this_goods'] = $isHaveGoods['id'];
                        }
                    }

                    getBrandImageDir($dir . "/" . $file . "/", $target);
                } else {
                    if($file != "." && $file != "..") {
                        $fileArr = explode('.', $file);
                        if(in_array(strtolower($fileArr[1]), array('jpg', 'gif', 'png'))){
                            $isHaveImg = $improtImgM->where('g_id = ' . $_SESSION['this_goods'] . ' AND img_name = "' . $file . '"')->find();

                            if(!$isHaveImg){
                                $data = array();
                                if(strlen($fileArr[0]) < 4 && intval($fileArr[0]) < 20 ){
                                    $data['status'] = 1;
                                }

                                $data['g_id'] = $_SESSION['this_goods'];
                                $data['detail_sn'] = $_SESSION['this_goods_sn'];
                                $data['detail_color_num'] = $_SESSION['this_goods_color_num'];
                                $data['img_name'] = $file;
                                $improtImgM->add($data);
                                //删除图片
                                unlink($dir . "/" . $file);
                            }
                        }
                    }
                }
            }
            closedir($dh);
        }
    }
}

function getDirDepth($path) {
    if(!is_dir($path)) {
        return 0;
    }
    $dirArr = explode('/', $path);
    $dirDepthArr = array();
    foreach ($dirArr as $item) {
        $item = trim($item, '/');
        if(!empty($item)) {
            $dirDepthArr[] = $item;
        }
    }

    return $thisDirDepth = count($dirDepthArr);
}

/**
 * 返回某一目录下的所有文件名
 * @param $dir
 * @return array
 */
function getDirAllFileName($dir){
    $fileNameArr = array();
    if(is_dir($dir)){
        if($dh= opendir($dir)) {
            while(($file= readdir($dh)) !== false){
                if($file!="."&& $file!=".."){
                    $file=mb_convert_encoding ($file,'UTF-8','GBK');//转换编码，因为中文windwows文件名的编码是GBK格式的
                    //var_dump($file);
                    //                        $re=explode(".",$file);//分解文件名
                    //                        $res=$re[0];  //不要文件后缀名，取出文件名
                    $fileNameArr[] = $file;
                }
            }
            closedir($dh);
        }
    }

    return $fileNameArr;
}

function createDir($dir) {
    if(!is_dir($dir)) {
        $dirArr = explode('/', $dir);
        $dirStr = '';
        foreach ($dirArr as $dirName) {
            $dirStr .= '/' . $dirName;
            if(!is_dir($dirStr)) {
                mkdir($dirStr);
            }
        }
    }
}

/**
 *过滤csv文件中的行空
 * @param $arr
 * @return array
 */
function getCsvArr($str){
    $str = str_replace(PHP_EOL, '', $str);
    $str = str_replace(array("\r\n", "\r", "\n"), "", $str);

    $arr = explode(',', $str);
    $newArr = array();
    foreach($arr as $item){
        if(!empty($item)){
            $newArr[] = $item;
        }
    }

    return $newArr;
}

function isHaveSubDir($path){
    $result = false;
    if(is_dir($path)){
        $dir = opendir($path);
        while(false !== ( $file = readdir($dir))) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if (is_dir($path . '/' . $file) ) {
                    return true;
                }
            }
        }
        closedir($dir);
    }

    return $result;
}

/**
 * 复制目录
 * @param $src
 * @param $dst
 */
function resourceCopy($src,$dst) {  // 原目录，复制到的目录

    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                resourceCopy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}


//循环删除目录和文件函数
function delDirAndFile($dirName)
{
    if ( $handle = opendir( "$dirName" ) ) {
        while ( false !== ( $item = readdir( $handle ) ) ) {
            if ( $item != "." && $item != ".." ) {
                if ( is_dir( "$dirName/$item" ) ) {
                    delDirAndFile( "$dirName/$item" );
                } else {
                    if(unlink( "$dirName/$item")){
                        //                        echo "成功删除文件： $dirName/$item<br />\n";
                    }
                }
            }
        }
        closedir( $handle );
        if( rmdir( $dirName ) ){
//            echo "成功删除目录： $dirName<br />\n";
        }
    }
}

function getCurlRequest($url, $data , $timeout = 200 , $headers = null , $cookiefile =null , $proxy =null ){
    $ch = curl_init( $url );
    curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_HEADER, 0 );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ch, CURLOPT_MAXREDIRS, 5 );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_ENCODING, "" );
    curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)");
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );

//    if ( $proxy ) {
//        curl_setopt( $ch, CURLOPT_PROXY, $proxy );
//        curl_setopt( $ch, CURLOPT_PROXYTYPE, $proxy_type );
//
//        print "use proxy: $proxy  type $proxy_type \n";
//    }

    if ( $headers ) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    if ( $cookiefile ) {
        curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookiefile );
        curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookiefile );
    }

    if ( $data ) {
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
    }

    $content = curl_exec( $ch );
    $httpcode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    curl_close($ch);

    if ( $httpcode >= 400 ) {
        return null;
    }

    $content = str_replace(array("\n","\r","\t"), '', trim($content));
    $result = json_decode( $content , true );
    if(!empty($result)){
        return $result;
    } else {
        return $content;
    }
}

function getCurlRequestXML($url, $data = array() , $timeout = 200 , $headers = null , $cookiefile =null , $proxy =null ){
    $ch = curl_init( $url );
    curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_HEADER, 0 );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ch, CURLOPT_MAXREDIRS, 5 );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_ENCODING, "" );
    curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)");
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );

//    if ( $proxy ) {
//        curl_setopt( $ch, CURLOPT_PROXY, $proxy );
//        curl_setopt( $ch, CURLOPT_PROXYTYPE, $proxy_type );
//
//        print "use proxy: $proxy  type $proxy_type \n";
//    }

    if(isset($data['ssl_cert'])){
        //第一种方法，cert 与 key 分别属于两个.pem文件
        //curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,$data['ssl_cert']);
        unset($data['ssl_cert']);
    }

    if(isset($data['ssl_key'])){
        //默认格式为PEM，可以注释
        //curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,$data['ssl_key']);
        unset($data['ssl_key']);
    }



    if ( $headers ) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    if ( $cookiefile ) {
        curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookiefile );
        curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookiefile );
    }

    if (!empty($data)) {
        $data = toXml($data);
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
    }

    $content = curl_exec( $ch );
    $httpcode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    curl_close($ch);

    if ( $httpcode >= 400 ) {
        return null;
    }
    $content = trim($content);
    return $content;
}

function whereArrToStr($whereArr = array(), $whereOrArr = array()){
    $where = '';

    if(empty($whereArr) && empty($whereOrArr)){
       return $where;
    }

    if(!empty($whereArr)){
        foreach($whereArr as $key => $value){
            $tempWhere[] = ' ' . $key .  ' ' . $value;
        }
        $where = implode(' AND ', $tempWhere);
    }

    if(!empty($whereOrArr)){
        $tempOrWhere = array();
        foreach($whereOrArr as $key => $value){
            $tempOrWhere[] = $key . $value;
        }

        if(!empty($where)){
            $where .= ' OR' .  implode(' OR', $tempOrWhere);
        }
    }


    return $where;
}

/**
 * 增加写入文本日志功能
 * @author yihua.ying 2014-6-30
 * @param $data 日志内容
 * @param string $file 日志文件名
 * @param bool $status
 */
function deBugLog($data, $file = '', $status = true) {
//    return;
    $status = true; //2016-3-9 全面禁用程序调试日志
    $file = str_replace('/', '-', $file);
    if($status) {

        $dir = $_SERVER['DOCUMENT_ROOT'] . '/logs/' . date('Y-m-d', time());
        $dirArr = explode('/', $dir);
        $dirStr = '';
        foreach($dirArr as $dirName){
            $dirStr .= '/' . $dirName;
            if(!is_dir($dirStr)) {
                mkdir($dirStr);
            }
        }

        $fileName = $dir . '/' . $file . '.log';
        $fp = fopen($fileName, 'a');
        if($fp) {
            fwrite($fp, "\xEF\xBB\xBF");
            fwrite($fp, '[' . date('Y-m-d H:i:s') . ' ]        ');
            fwrite($fp, serialize($data));
            fwrite($fp, "\n");
        }
        fclose($fp);
    }
}

/**
 *  生成支付单号
 * @return string
 */
function createPaymentId(){
    return time() . rand(1000, 9999);
}


/**
 * 数组转xml字符
 * @param $data
 * @return string
 */
function toXml($data)
{
    if(!is_array($data)
        || count($data) <= 0)
    {
        return '';
    }

    $xml = "<xml>";
    foreach ($data as $key=>$val)
    {
        if (is_numeric($val)){
            $xml.="<".$key.">".$val."</".$key.">";
        }else{
            $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
    }
    $xml.="</xml>";
    return $xml;
}

/**
 * 将xml转为array
 * @param string $xml
 * @throws WxPayException
 */
function fromXml($xml)
{
    if(!$xml){
        return;
    }
    //将XML转为array
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $data;
}

function getMem($key){
    $m = new Memcached();
    $m->addServer('121.43.225.46', 11211);
    $val = $m->get($key);
    return $val;
}

function sendWxMsg($openId, $content, $type='text'){
    $wxToken = S('wx_api_access_token');
    if(!empty($wxToken) && !empty($openId)){
        $wxUrl = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $wxToken;
        $wxData = array(
            'touser' => $openId,
            'msgtype' => $type,
            'text' => array(
                'content' => urlencode($content)),
        );
        $wxDataJson = urldecode(json_encode($wxData));
        $wxResult = getCurlRequest($wxUrl, $wxDataJson);


//        deBugLog($wxData, 'test_wx_send_msg_result');
//        deBugLog($wxResult, 'test_wx_send_msg_result');
        return $wxResult;
    }
}

/**
 *  发送微信模板消息
 * @param string $openid
 * @param string $tmplType
 * @param array $params
 * @return mixed|null|void
 */
function sendWxTmplMsg($openid = '', $tmplType = '', $params = array()){
    $wxToken = S('wx_api_access_token');
    $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $wxToken;
// 第一步：获取模板ID
//通过在模板消息功能的模板库中使用需要的模板，可以获得模板ID。
//第二步：请求接口
//请注意，URL置空，则在发送后，点击模板消息会进入一个空白页面（ios），或无法点击（android）。

    if(empty($openid) || empty($tmplType)){
        return;
    }

    $tempIdArr = array();
    $tempIdArr['groupbuy_succ'] = C('GROUPBUY_SUCC_MSG_TML_ID');
    $tempIdArr['coupon_get'] = C('COUPON_GET_MSG_TML_ID');
//    $tempIdArr['refund_no_stock'] = C('NO_STOCK_REFUND_MSG_TML_ID');
    $data = array();
    $data['touser'] = $openid;  //openid
    $data['template_id'] = $tempIdArr[$tmplType]; //模板id
    $data['url'] = isset($params['url']) ? $params['url'] : ''; //链接地址
    $data['topcolor'] = '#FF0000';

    $msgData = array();
    switch($tmplType){
        case 'groupbuy_succ':
            $productName = isset($params['product_name']) ? $params['product_name'] : '';
            $wxNickname = isset($params['nickname']) ? $params['nickname'] : '';
            $msgData['first'] = array('value'=>'恭喜小主拼团成功!', 'color'=>'#173177');
            $msgData['Pingou_ProductName'] = array('value'=>$productName, 'color'=>'#173177');
            $msgData['Weixin_ID'] = array('value'=>$wxNickname, 'color'=>'#173177');
            $msgData['Remark'] = array('value'=>'感谢关注叔小白，有您的支持我们会做得更好。', 'color'=>'#173177');
            break;

        case 'coupon_get':
            $couponContent = isset($params['content']) ? $params['content'] : '';
            $msgData['first'] = array('value'=>'恭喜小主获得[叔小白]' . $couponContent, 'color'=>'#173177');
            $msgData['orderTicketStore'] = array('value'=>'叔小白商城', 'color'=>'#173177');
            $msgData['orderTicketRule'] = array('value'=> '详见优惠券列表', 'color'=>'#173177');
            $msgData['remark'] = array('value'=>'感谢关注叔小白，有您的支持我们会做得更好。', 'color'=>'#173177');
            break;

        case 'luckdraw_msg':


            break;

//        case 'refund_no_stock':
//            //缺货退款通知
//            $content = isset($params['content']) ? $params['content'] : '';
//            $reason = isset($params['reason']) ? $params['reason'] : '';
//            $refund = isset($params['refund']) ? $params['refund'] : '';
//            $msgData['first'] = array('value'=>$content, 'color'=>'#173177');
//            $msgData['reason'] = array('value'=>$reason, 'color'=>'#173177');
//            $msgData['refund'] = array('value'=>$refund, 'color'=>'#173177');
//            $msgData['remark'] = array('value'=>'感谢关注叔小白，给您带来不便非常抱歉!', 'color'=>'#173177');
//
//            break;
    }

    $data['data'] = $msgData;

    $wxDataJson = urldecode(json_encode($data));
    $wxResult = getCurlRequest($url, $wxDataJson);

//    deBugLog($data, 'test_wx_send_tmp_msg_result');
//    deBugLog($wxResult, 'test_wx_send_tmp_msg_result');

    return $wxResult;
}

/**
 * 发送手机短信
 * @param $phone
 * @param $content
 * @return bool
 */
function sendMobileMsg($phone, $content){
    $smsUrl = C('SMS_URL');
    //发货成功
    //发送短信通知
    $account = C('SMS_ACCOUNT');
    $password = C('SMS_PASSWD');
    $userid = C('SMS_USERID');
    $contentSend = $content;
    $timestamps = time()*1000;

    $md5Paswd = md5($password.$phone.$timestamps);

    $params = array(
        'account' => $account,
        'password' => $md5Paswd,
        'mobile' => $phone,
        'content' => $contentSend,
        'timestamps' => $timestamps
    );

    $response =  getCurlRequest($smsUrl, http_build_query($params));

    if(!empty($response))
    {
        $json_data = $response;
        if(!empty($json_data))
        {
            if(count($json_data['Rets']) != 0 )
            {
                foreach($json_data['Rets'] as $key => $value )
                {
                    if($value['Rspcode'] == 0)
                    {
                        //某条发送成功
                        return true;
                    }
                }
            }
        }

        return false;
    }
    else{
        return false;
    }
}


/**
    //	收件人：
    //wenzh <wenzh@fruitday.com>
    //	抄   送：
    //tianiao <tianiao@126.com>; wangwj <wangwj@fruitday.com>; zhaohw <zhaohw@fruitday.com>; sunhl <sunhl@fruitday.com>; wangbin <wangbin@fruitday.com>; shisq <shisq@fruitday.com>; jingang <jingang@fruitday.com>; gaoes <gaoes@fruitday.com>; libo <libo@fruitday.com>; liangjt <liangjt@fruitday.com>; zhoujie <zhoujie@fruitday.com>; maozk <maozk@fruitday.com>; liull3 <liull3@fruitday.com>; yangtao <yangtao@fruitday.com>; wangyj2 <wangyj2@fruitday.com>; madd <madd@fruitday.com>
*/
function getMail(){
    vendor('PHPMailer/phpmailer');
    ini_set("magic_quotes_runtime",0);
    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
    $mail->SMTPAuth   = true;                  //开启认证
    $mail->Port       = 25;
    $mail->Host       = "smtp.ym.163.com";

    $userName = 'dingdan001@shipinmmm.com';
    $password = 'abc1236540';
    $hour = date('H');
    if($hour > 14 and $hour < 22){
        $userName = 'dingdan002@shipinmmm.com';
        $password = 'abc1236540';
    }

    if($hour >= 22){
        $userName = 'dingdan003@shipinmmm.com';
        $password = 'abc1236540';
    }

    $mail->Username   = $userName;
    $mail->Password   = $password;

    //$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
    $mail->AddReplyTo($userName,"mckee");//回复地址
    $mail->From       = $userName;
    $mail->FromName   = "上海时品";

    return $mail;
}

/**
 *  导出excel 从CommonAction中移植过来
 * @param $expTitle
 * @param $expCellName
 * @param $expTableData
 * @param string $type
 * @param bool|false $isDown
 */
function exportExcel($expTitle,$expCellName,$expTableData,$type = 'normal', $isDown=false){
    $xlsTitle = iconv('utf-8', 'utf-8', $expTitle);//文件名称
    $fileName = $xlsTitle; //文件名称
    $cellNum = count($expCellName);
    $dataNum = count($expTableData);
    vendor("PHPExcel");
    $objPHPExcel = new PHPExcel();
    $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

    switch($type){
        //原导出订单功能 2015-11-11 chrisying
        case 'export_order':
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '运单信息');
            $objPHPExcel->getActiveSheet(0)->mergeCells('B1:E1');//合并单元格
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '收件人信息');
            $objPHPExcel->getActiveSheet(0)->mergeCells('F1:H1');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '托寄物信息');
            $objPHPExcel->getActiveSheet(0)->mergeCells('I1:J1');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '保价信息');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '订单金额');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '服务类型');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '运单备注');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '配送业务类型');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '运单号');

            $objPHPExcel->getActiveSheet(0)->getStyle("B1")->getFont()
                ->setName('宋体')
                ->setSize(11);
            $objPHPExcel->getActiveSheet(0)->getStyle("F1")->getFont()
                ->setName('宋体')
                ->setSize(11);


            for($i=0;$i<$cellNum;$i++){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
            }
            // Miscellaneous glyphs, UTF-8
            for($i=0;$i<$dataNum;$i++){
                for($j=0;$j<$cellNum;$j++){

                    switch($j){
                        case 8:
                            //保价
                            $objActSheet = $objPHPExcel->getActiveSheet(0);
                            $objValidation = $objActSheet->getCell($cellName[$j].($i+3))->getDataValidation();
                            //这一句为要设置数据有效性的单元格
                            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                                ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                                ->setAllowBlank(false)
                                ->setShowInputMessage(true)
                                ->setShowErrorMessage(true)
                                ->setShowDropDown(true)
                                ->setErrorTitle('请选择保价')
                                ->setError('您输入的值不在下拉框列表内.')
                                ->setPromptTitle('保价')
                                ->setFormula1('"是,否"')
                                ->setFormula2('"是,否"');
                            $objActSheet->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);

                            break;

                        case 11:
                            //代收货款
                            $objActSheet = $objPHPExcel->getActiveSheet(0);
                            $objValidation = $objActSheet->getCell($cellName[$j].($i+3))->getDataValidation();
                            //这一句为要设置数据有效性的单元格
                            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                                ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                                ->setAllowBlank(false)
                                ->setShowInputMessage(true)
                                ->setShowErrorMessage(true)
                                ->setShowDropDown(true)
                                ->setErrorTitle('请选择代收货款')
                                ->setError('您输入的值不在下拉框列表内.')
                                ->setPromptTitle('代收货款')
                                ->setFormula1('"是,否"')
                                ->setFormula2('"是,否"');
                            $objActSheet->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
                            break;

                        case 13:
                            //配送业务类型
                            $objActSheet = $objPHPExcel->getActiveSheet(0);
                            $objValidation = $objActSheet->getCell($cellName[$j].($i+3))->getDataValidation();
                            //这一句为要设置数据有效性的单元格
                            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                                ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                                ->setAllowBlank(false)
                                ->setShowInputMessage(true)
                                ->setShowErrorMessage(true)
                                ->setShowDropDown(true)
                                ->setErrorTitle('请选择配送业务类型')
                                ->setError('您输入的值不在下拉框列表内.')
                                ->setPromptTitle('配送业务类型')
                                ->setFormula1('"普通,控温,冷藏,冷冻,深冷"')
                                ->setFormula2('"普通,控温,冷藏,冷冻,深冷"');
                            $objActSheet->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
                            break;

                        default:
                            //                            echo $expTableData[$i][$expCellName[$j][0]];
                            //由PHPExcel根据传入内容自动判断单元格内容类型  setCellValue('A1', '字符串内容');
                            //显式指定内容类型  setCellValueExplicit('A1', '字符串内容', PHPExcel_Cell_DataType::TYPE_STRING)
                            $objPHPExcel->getActiveSheet(0)->setCellValueExplicit($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]], PHPExcel_Cell_DataType::TYPE_STRING);
                            break;
                    }

                }
            }
            break;

        //按发货渠道导出订单
        case 'export_send_channel_order':
            for($i=0;$i<$cellNum;$i++){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);
            }
            // Miscellaneous glyphs, UTF-8
            for($i=0;$i<$dataNum;$i++){
                for($j=0;$j<$cellNum;$j++){

                    switch($j){
                        case 83:
                            //保价
                            $objActSheet = $objPHPExcel->getActiveSheet(0);
                            $objValidation = $objActSheet->getCell($cellName[$j].($i+2))->getDataValidation();
                            //这一句为要设置数据有效性的单元格
                            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                                ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                                ->setAllowBlank(false)
                                ->setShowInputMessage(true)
                                ->setShowErrorMessage(true)
                                ->setShowDropDown(true)
                                ->setErrorTitle('请选择保价')
                                ->setError('您输入的值不在下拉框列表内.')
                                ->setPromptTitle('保价')
                                ->setFormula1('"是,否"')
                                ->setFormula2('"是,否"');
                            $objActSheet->setCellValue($cellName[$j].($i+2), $expTableData[$i][$expCellName[$j][0]]);

                            break;

                        default:
                            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $expTableData[$i][$expCellName[$j][0]]);
                            break;
                    }
                }
            }

            break;

        default:
            //由PHPExcel根据传入内容自动判断单元格内容类型  setCellValue('A1', '字符串内容');
            //显式指定内容类型  setCellValueExplicit('A1', '字符串内容', PHPExcel_Cell_DataType::TYPE_STRING)
            for($i=0;$i<$cellNum;$i++){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($cellName[$i].'1', $expCellName[$i][1], PHPExcel_Cell_DataType::TYPE_STRING);
            }
            // Miscellaneous glyphs, UTF-8
            for($i=0;$i<$dataNum;$i++){
                for($j=0;$j<$cellNum;$j++){
                    $objPHPExcel->getActiveSheet(0)->setCellValueExplicit($cellName[$j].($i+2), $expTableData[$i][$expCellName[$j][0]], PHPExcel_Cell_DataType::TYPE_STRING);
                }
            }


            break;
    }

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $filename = $fileName . ".xlsx";

    if($isDown){
        //excel 5格式
        //        header('pragma:public');
        //        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        //        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        //        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //        $objWriter->save('php://output');

        //excel 2007 格式
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$filename.'"');
        header("Content-Transfer-Encoding: binary");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $objWriter->save('php://output'); //文件通过浏览器下载
    }else{
        $dateStr = str_replace('-', '/', date('Y-m-d', time()));
        $filePath = BASE_PATH . '/upload' . '/' . $dateStr . '/';
        createDir($filePath);
        $objWriter->save($filePath . $filename); //脚本方式运行，保存在当前目录
        return $filePath . $filename;
    }
}