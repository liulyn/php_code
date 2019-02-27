<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 取数组$arr的键与$limits的值的交集
 * @param $arr
 * @param $limits
 * @return array 返回$arr数组中的键在$limits的键值对数组
 */
if ( ! function_exists('array_key_intersect'))
{
	function array_key_intersect($arr, $limits)
	{
		// 将values 转为 keys
		$limits = array_flip($limits);
		return array_intersect_key($arr, $limits);
	}
}
/**
 * 打印数组函数
 * @param $arr
 */
if( ! function_exists('p'))
{
	function p($arr)
	{
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}
}

/**
 * 一维数组键值转换
 * @param $arr
 */
if( ! function_exists('key_exchange'))
{
	function key_exchange($arr,$key = '')
	{
		$res = array();
		if($key == '')
			foreach ($arr as $k => $v){
				$value = array_values($v);
				$res[$value[0]]= $v;
			}
		else
			foreach ($arr as $k => $v){
				$value = array_values($v);
				$res[$v[$key]]= $v;
			}
		return $res;
	}
}
/**
 * 一维数组数据提取
 * @param $arr
 */
if( ! function_exists('array_value_one'))
{
	function array_value_one($arr,$key = '')
	{
		if($key == '')
			return $arr;
		$res = array();
		unset($v);
		foreach ($arr as $k => $v){
			array_push($res, $v[$key]);
		}
		return $res;
	}
}

/**
 * 取某值作为键名
 * @param author Jerry
 */
if(!function_exists('value_as_key')){
    function value_as_key($array,$value){
        $arr = array();
        foreach($array as $k=>$v){
            $arr[$v[$value]] = $v;
        }
        
        return $arr;
    }
}
/**
 * 对象转为数组
 * @param object
 */
if( ! function_exists('object_to_array'))
{
	function object_to_array($obj) {
		$ret = array();
		foreach ($obj as $key => $value) {
			if (gettype($value) == "array" || gettype($value) == "object"){
				$ret[$key] =  object_to_array($value);
			}else{
				$ret[$key] = $value;
			}
		}
		return $ret;
	}
}


/**
 * 模板输出数组和字符串检查函数
 * @param $data 被检测的数据
 * @param $flag 检测类型（str、arr）str字符串，arr数组，默认为数组
 * @param $default 默认值，该参数只对字符串有效
 */
if ( ! function_exists('echo_on_temp'))
{
	function echo_on_temp($data, $flag = 'str', $default = '')
	{
		switch ($flag)
		{
			case 'arr':
				if(isset($data) && is_array($data) && !empty($data))
				{
					return true;
				}
				else
				{
					return false;
				}
				break;

			case 'str':
			default :
				if(isset($data) && is_string($data) && $data != '')
				{
					return $data;
				}
				else
				{
					return $default;
				}
				break;
		}
	}
}

/**
 * 截取文字
 * @param $string 被截取的字符串
 * @param $start 字符串截取的开始位置
 * @param $length 字符串截取的长度
 * @param $dot 字符串超出截取的长度后的后缀
 * @author jounglin
 */
if ( ! function_exists('str_cut'))
{
    function str_cut(&$string, $start, $length, $charset = "utf-8", $dot = '...') {
        if(function_exists('mb_substr')) {
            if(mb_strlen($string, $charset) > $length) {
                return mb_substr ($string, $start, $length, $charset) . $dot;
            }
            return mb_substr ($string, $start, $length, $charset);

        }else if(function_exists('iconv_substr')) {
            if(iconv_strlen($string, $charset) > $length) {
                return iconv_substr($string, $start, $length, $charset) . $dot;
            }
            return iconv_substr($string, $start, $length, $charset);
        }

        $charset = strtolower($charset);
        switch ($charset) {
            case "utf-8" :
                preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $ar);
                if(func_num_args() >= 3) {
                    if (count($ar[0]) > $length) {
                        return join("", array_slice($ar[0], $start, $length)) . $dot;
                    }
                    return join("", array_slice($ar[0], $start, $length));
                } else {
                    return join("", array_slice($ar[0], $start));
                }
                break;
            default:
                $start = $start * 2;
                $length   = $length * 2;
                $strlen = strlen($string);
                $tmpstr = '';
                for ( $i = 0; $i < $strlen; $i++ ) {
                    if ( $i >= $start && $i < ( $start + $length ) ) {
                        if ( ord(substr($string, $i, 1)) > 129 ) $tmpstr .= substr($string, $i, 2);
                        else $tmpstr .= substr($string, $i, 1);
                    }
                    if ( ord(substr($string, $i, 1)) > 129 ) $i++;
                }
                if ( strlen($tmpstr) < $strlen ) $tmpstr .= $dot;

                return $tmpstr;
        }
    }
}

/**
 * 根据某键名排序
 */
if(!function_exists('arr_sort')){
    function arr_sort($array,$key,$order="asc"){//asc是升序 desc是降序
        $arr_nums=$arr=array();
        foreach($array as $k=>$v){
            $arr_nums[$k]=$v[$key];
        }
    
        if($order=='asc'){
            asort($arr_nums);
        }else{
            arsort($arr_nums);
        }
        foreach($arr_nums as $k=>$v){
            $arr[$k]=$array[$k];
        }
        return $arr;
    }
}

/**
 * 数据打印
 * @author Jerry
 */
if(!function_exists('Luk')){
    function Luk($title='From',$data='php',$on = 1,$die=0){
        if($on){
            echo "<script>console.log(". json_encode(array($title=>$data)). ")</script>";
            if($die) die;
        }
    }
}


/**
 * 返回json数据
 */
if(!function_exists('exit_json')){
    function exit_json($code='',$msg='',$data=array(), $return=0,$dev = 0){
        if($code=='' || $msg=='') return false;
        
        $arr = array('errorCode'=>$code,'errorMessage'=>$msg);
        if(!empty($data))
            $arr['data'] = $data;
            
        if($return){
            if($dev){  p($arr);die;}
            else  return json_encode($arr);
        }else{
            if($dev){  p($arr);die;}
            else  exit(json_encode($arr));
            
        }
    }
}



/*
 * 结束程序,返回json数据
 * @param $errorCode    返回状态码
 * @param $data         返回的数据
 * @param $errorMessage 错误提示
 * @param $dev          开发测试
 *
 */
if ( ! function_exists('exitJson'))
{
    function exitJson($errorCode=0,$errorMessage='',$data='',$dev=0){
    	$tips = array(
            0=>'请求成功',
            1=>'未知错误',
            41=>'缺少必要参数',
            40=>'查询结果为空'
	    );
	    $keys = array('errorCode','errorMessage','data');
	    foreach ($keys as $k=>$v) {
	    	if($k==1){
	    		if($$v!='') $DATA[$v] = $$v;
	    		else{
	    			if(isset($tips[substr($DATA['errorCode'],0,2)]) && $tips[substr($DATA['errorCode'],0,2)]!='')
						$DATA[$v] = $tips[substr($DATA['errorCode'],0,2)];
	    			else
	    				$DATA[$v] = substr($DATA['errorCode'],0,2).'对应的errorMessage未设置';
	    		}
	    	}else{
	    	     $DATA[$v] = $$v;
	    	}
	    }
	    if($data=='') unset($DATA['data']);
	    if($dev){
	        echo "<pre>";
	        print_r($DATA);
	        exit();
	    }
	    exit(json_encode($DATA));
    }
}

/**
 * 按某值排序
 */
if(!function_exists('array_sort')){
    function array_sort($arr,$keys,$type='asc'){
        $keysvalue = $new_array = array();
        foreach ($arr as $k=>$v){
            $keysvalue[$k] = $v[$keys];
        }
        if($type == 'asc'){
            asort($keysvalue);
        }else{
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k=>$v){
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }

}

/**
 *  @desc 根据两点间的经纬度计算距离
 *  @param float $lat 纬度值
 *  @param float $lng 经度值
 */
if ( ! function_exists('getDistance')){
    // getDistance($lat1, $lng1, $lat2, $lng2);
    function getDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6367000; //approximate radius of earth in meters

        /*
         Convert these degrees to radians
         to work with the formula
         */

        $lat1 = ($lat1 * pi() ) / 180;
        $lng1 = ($lng1 * pi() ) / 180;

        $lat2 = ($lat2 * pi() ) / 180;
        $lng2 = ($lng2 * pi() ) / 180;


        $calcLongitude = $lng2 - $lng1;
        $calcLatitude  = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);  $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;

        return round($calculatedDistance);
    }

}

/**
 * 下面三个方法主要思想是逆向异或可得到原字符串，下面举例说明
 * $txt = 'helloWorld' $key = 'workHard'
 * 1、passport_encrypt($txt,$key)：$encrypt_key随机字符串，用于异或生成中间字符串$tmp，
 *    每两个字符中首个字符是用于与第二个字符做异或运算可得到$txt原字符串的，所以当中间字符串暴露了之后就很危险了。
 * 2、passport_key($tmp,$key) 用于异或加密中间字符串，以后可通过$key再做异或运算得到原中间字符串$tmp
 * 3、passport_decrypt($txt,$key),先用第二步说的方法，与key做异或还原中间字符串$tmp，再用第一步最后说的第二位与第一位做异或运算即可
 */

if ( ! function_exists('passport_encrypt')) {
    function passport_encrypt($txt, $key)
    {
        srand((double)microtime() * 1000000);
        $encrypt_key = md5(rand(0, 32000));
        $ctr = 0;
        $tmp = '';
        for ($i = 0; $i < strlen($txt); $i++) {
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            $tmp .= $encrypt_key[$ctr] . ($txt[$i] ^ $encrypt_key[$ctr++]);
        }
        return base64_encode(passport_key($tmp, $key));
    }
}

if ( ! function_exists('passport_decrypt')) {
    /**
     * @param $txt
     * @param $key
     * @return string
     */
    function passport_decrypt($txt, $key)
    {
        $txt = str_replace(' ', '+', $txt);
        $txt = passport_key(base64_decode($txt), $key); // 逆向异或运算，得到 passport_encrypt 的 $tmp
        $tmp = '';
        for ($i = 0; $i < strlen($txt); $i++) {
            $md5 = $txt[$i];
            $tmp .= $txt[++$i] ^ $md5;
        }
        return $tmp;
    }
}

if ( ! function_exists('passport_key')) {
    /**
     * @param $txt
     * @param $encrypt_key
     * @return string
     */
    function passport_key($txt, $encrypt_key)
    {
        $encrypt_key = md5($encrypt_key);
        $ctr = 0;
        $tmp = '';
        for ($i = 0; $i < strlen($txt); $i++) {
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
        }
        return $tmp;
    }
}
?>