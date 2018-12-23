<?php
namespace Controllers;
use Common;	
/**
* 
*/
class RegistController extends BaseController
{
	
	public function studentRegist()
	{
		$postArr = $this->container->get('request')->getParsedBody();
		//判断各变量是否存在
		if (!(isset($postArr['id']) && isset($postArr['name']) && isset($postArr['password']) && isset($postArr['repassword']) && isset($postArr['teacher_id']) && isset($postArr['teacher_work_id']))) {
			return $this->json_fail("fail");
		}
		//检查是否有非法输入
		Common\CheckCommon::inputCheck($postArr);

		//$_SESSION['captcha'] = 'abcd';	

		/*if ($_SESSION['captcha'] !== $postArr['captcha']) {
			return $this->json_fail('captcha error');
		}*/
		if ($postArr['password'] !== $postArr['repassword']) {
			return $this->json_fail("Password inconsistent");
		}
		//密码长度大于8位数，必须包含大小写字母数字特殊符号
		/*$result = preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])^.{8,16}$/', $postArr['password']);
		if (!$result) {
			return $this->json_fail("Password doesn't conform to the rules");
		}*/
		/*$teacher_id = $this->container['db']->select('teachers','id',[
				'name'=>$postArr['teacherName']
			]);
		if (!$teacher_id) {
			return $this->json_fail('The teacher is not exist');
		}*/
		$result = $this->container['db']->has('students',[
			'stu_id' => $postArr['id']
			]);
		if (!$result) {
			$regist = $this->container['db']->insert('students',[
				"stu_id" => $postArr['id'],
				"name"=>$postArr['name'],
				"password"=>md5($postArr['password']),
				"teacher_id"=>$postArr['teacher_id'],
				"teacher_work_id"=>$postArr['teacher_work_id']
			]);
			if ($regist->rowCount()) {
				return $this->json_success('regist success');
			}
			else{
				return $this->json_fail('regist fail');
			}
		}
		else{
			return $this->json_fail('the student has registed');
		}
	}

	public function teacherRegist()
	{
		$postArr = $this->container->get('request')->getParsedBody();
		//判断各变量是否存在
		if (!(isset($postArr['id']) && isset($postArr['name']) && isset($postArr['password']) && isset($postArr['repassword']))) {
			return $this->json_fail("fail");
		}
		//检查是否有非法输入
		Common\CheckCommon::inputCheck($postArr);
		//$_SESSION['captcha'] = 'abcd';
		/*if ($_SESSION['captcha'] !== $postArr['captcha']) {
			return $this->json_fail('captcha error');
		}*/
		if ($postArr['password'] !== $postArr['repassword']) {
			return $this->json_fail("Password inconsistent");
		}
		//密码长度大于8位数，必须包含大小写字母数字特殊符号
		/*$result = preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])^.{8,16}$/', $postArr['password']);
		if (!$result) {
			return $this->json_fail("Password doesn't conform to the rules");
		}*/

		$result = $this->container['db']->has('teachers',[
			'work_id' => $postArr['id']
			]);
		if (!$result) {
			$regist = $this->container['db']->insert('teachers',[
				"work_id" => $postArr['id'],
				"name"=>$postArr['name'],
				"password"=>md5($postArr['password'])
			]);
			if ($regist) {
				return $this->json_success('regist success');
			}
		}
		else{
			return $this->json_fail('the teacher has registed');
		}
	}

	public function showTeacher()
	{
		
		$result = $this->container['db']->select('teachers',[
				'id',
				'work_id',
				'name'
			]);
		return json_encode($result);
	}
}