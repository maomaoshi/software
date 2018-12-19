<?php
namespace Common;

/**
* 
*/
class BaseCommon 
{
	
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
}