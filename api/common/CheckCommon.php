<?php
namespace Common;

/**
* 
*/
class CheckCommon extends BaseCommon
{
	
	public static function inputCheck($data = array())
	{
		//判断是否为空
		if (self::check_array_null($data)) {
			return $this->json_fail('Value cannot be null');
		}
		//判断是否有非法输入
		if (self::check_array_inject($data)) {
			return $this->json_fail('illegal input');
		}
	}
	public static function check_array_null($data = array())
	{
		foreach ($data as $key => $value) {
			if (empty($value)) {
				return true;
			}
		}
		return false;
	}
	public static function check_array_inject($data = array())
	{
		foreach ($data as $key => $value) {
			if (self::inject_check($value)) {
				return true;
			}
		}
		return false;
	}

	//注入检测
	public static function inject_check($str){   
		$tmp=preg_match('/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/i', $str);
		if($tmp){
			return true;
		}else{
			return false;
		}
	}
}