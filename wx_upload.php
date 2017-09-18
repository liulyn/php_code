<?php
    /**
     * 上传微信图片以及服务器图片
     * @return [type] [description]
     */
    public function wx_upload(){
        if(!isset($_FILES['Filedata']) || empty($_FILES['Filedata']) || $_FILES['Filedata']['error'] != 0){
            $this->exit_json_array(1,'上传图片失败');
        }
        $this->load->helper('curl');
        $this->load->library('wechat_lib');
        $url = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=";

        $access_token = 'sad'; // 项目数据库获取或调用微信接口获取 $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=SECRET";
        if(!$access_token){
            $this->exit_json_array(3,'获取access_token失败');
        }
        $url .= $access_token;
        if(class_exists('\CURLFILE')){
            $filedata = array('buffer'=>new \CURLFILE(realpath($_FILES['Filedata']['tmp_name']),'image/jpeg',$_FILES['Filedata']['name']));
        }else{ //由于微信接口仅支持JPG、PNG格式,所以必须使用上面的语句指定图片格式
            $this->exit_json_array(4,'请联系技术人员升级php至5.6+版本');
            // $filedata = array('buffer' => '@'.realpath($file_path));
        }
        $res = curl_post($url,$filedata);
        if(!$res){
            $this->exit_json_array(5,'上传图片失败');
        }
        $res = json_decode($res,true);
        if(empty($res['url'])){
            $this->exit_json_array(6,$res['errorMessage']);
        }
        $wx_url = $res['url']; //微信图片地址

        //可上传图片格式类型
        // 转换成服务器指定的图片格式
        $image_type = explode('.', $_FILES['Filedata']['name']);
        $image_type = $image_type[count($image_type)-1];
        // 图片大小的下标判断
        if(!isset($_FILES['Filedata']['size']) || !$_FILES['Filedata']['size']) {
            $this->exit_json_array(7,'上传图片大小有误');
        }

        $size = $_FILES['Filedata']['size'];

        //图片大小2M以内
        if(2 < bcdiv(bcdiv($size,1024,2),1024,2)){
            $this->exit_json_array(8,'上传图片过大');
        }
        $url = $this->config->item('mobile_upload');
        // 获取文件
        if(!isset($_FILES['Filedata']['tmp_name']) || !$_FILES['Filedata']['tmp_name']) {
            $this->exit_json_array(9,'图片不存在');
        }
        //判断是否合法上传(PHP函数能检测)
        if(!is_uploaded_file($_FILES['Filedata']['tmp_name'])){
            $this->exit_json_array(10,'非法上传');
        }
        $img_file_name = $_FILES['Filedata']['tmp_name'];

        $data = array(
            'from'=>$_SERVER['HTTP_HOST'], // 图片上传域名
            'img_type'=>$image_type,// 图片类型
            'img_data'=>base64_encode(file_get_contents($img_file_name))// base64加密
        );
        $this->load->helper('curl');
        $res = curl_post($url,$data,array(CURLOPT_TIMEOUT=>10));
        if($res) {
            $res = json_decode($res,true);
            if(isset($res['errorCode']) && $res['errorCode'] == 0){
                $pic_url = $res['url']; // 服务器图片地址
                $this->exit_json_array(0,'上传成功',array('wx_url'=>$wx_url,'pic_url'=>$pic_url));
            }
            $this->exit_json_array($res['errorCode'],$res['errorMessage']);
        } else {
            $this->exit_json_array(11,'上传失败');

        }

    }