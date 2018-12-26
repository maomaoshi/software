<?php
namespace Controllers;
use Common;
use \PDO;

/**
* 
*/
class NoticeController extends BaseController
{
	
	public function noticeList()
	{
		$getArr = $this->container->get('request')->getQueryParams();
		if (!isset($getArr['course_id'])) {
			return $this->json_fail('fail');
		}

		$List = $this->container['db']->select('notice',[
				'publisher',
				'title',
				'content',
				'publish_time'
			],[
				'course_id'=>$getArr['course_id'],
				'ORDER'=>[
					'publish_time'=>'DESC'
				]
			]);
		if ($List) {
			foreach ($List as $key => $value) {
				$List[$key]['publish_time'] = date("Y-m-d H:i",$List[$key]['publish_time']);
			}
		}
		return json_encode($List);
	}
}