<?php
namespace Controllers;

/**
* 
*/
class BaseController 
{
	protected $container;
	function __construct(\Slim\Container $container)
	{
		$this->container = $container;
	}

	public function json_success($msg = 'no success message',$data = null){
        $result = array(
            "status" => "success",
            "message" => $msg
        );
        if($data)
            $result["data"] = $data;

        return json_encode($result);
    }

    public function  json_fail($msg = 'no failed message'){
        return json_encode(array(
            "status" => "fail",
            "message" => $msg
        ));
    }
    public function reArrayFiles($file)
    {
    	$file_ary = array();
    	$file_count = count($file['name']);
    	$file_key = array_key($file);

    	for ($i = 0; $i < $file_count; $i++) { 
    		foreach ($file_key as $value) {
    			$file_ary[$i][$value] = $file[$value][$i];
    		}
    	}
    	return $file_ary;
    }
    public function saveFile($file)
    {
    	$FILENAME = array();
    	$i = 0;
    	foreach ($files as $key => $value) {
    		$realName = iconv('UTF-8', 'GBK', $value['name']);//防止中文乱码
    		$arr = explode(".", $realName);//提取后缀
    		$fileType = $arr[count($arr) - 1];
    		$tmpPath = $value['tmp_name'];
    		$tmpType = $value['type'];
    		$tmpSize = $value['size'];
    		$error = $value['error'];

    		if ($error > 0 || $tmpSize <= 0) {
    			continue;
    		}

    		$types = array('jpg', 'png', 'gif', 'svg', 'jpeg');
    		//检查图片格式
    		if (!in_array($fileType, $types)) {
    			continue;
    		}
    		//以下的路径要注意
    		
    		$path = 'upload';
    		if (!is_dir($path)) {
    			mkdir($path, 0700);
    		}

    		$time = time().mt_rand();
    		$realPath = $path.'/'.$time.'.'.$fileType;
    		$fileName = $time.'.'.$fileType;

    		if (file_exists($realPath)) {//检查文件是否存在
    			continue;
    		}
    		else{
    			move_uploaded_file($tmpPath, $realPath);
    			$FILENAME[$i] = $fileName;
    			$i++;
    		}
    	}

    	return $FILENAME;
    }
}

