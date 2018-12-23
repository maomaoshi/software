<?php
namespace Controllers;
use Common;

/**
* 
*/
class LoginController extends BaseController
{
	public function is_login()
	{
		$postArr = $this->container->get('request')->getParsedBody();
		Common\CheckCommon::inputCheck($postArr);
		if (!(isset($postArr['id']) && isset($postArr['password']) && isset($postArr['captcha']))) {
			return $this->json_fail('fail');	
		}
		if ($_SESSION['captcha'] !== $postArr['captcha']) {
			return $this->json_fail('captcha error');
		}
		if (isset($_SESSION[$postArr['id']]) && $_SESSION[$postArr['id']]['expire'] < time()) {
			return $this->json_success('have logged in');
		}
		else if($_SESSION[$postArr['id']]['expire'] > time()){
			Common\SessionCommon::clearGroupSession($postArr['id']);
			return $this->json_fail('no login');
		}
		else{
			return $this->json_fail('no login');
		}
	}
	
	public function teacherLogin()
	{
		$postArr = $this->container->get('request')->getParsedBody();
		if (!(isset($postArr['id']) && isset($postArr['password']))) {
			return $this->json_fail('fail');
		}
		//检查是否为空，是否有非法输入
		Common\CheckCommon::inputCheck($postArr);
		//验证码是否正确
		//$_SESSION['captcha'] = "abcd";
		/*if ($_SESSION['captcha'] !== $postArr['captcha']) {
			return $this->json_fail('captcha error');
		}*/
		//工号和密码是否正确
		$result = $this->container['db']->has('teachers',[
			"AND"=>[
				'work_id'=>$postArr['id'],
				'password'=>md5($postArr['password'])
			]
		]);
		if($result){
			Common\SessionCommon::setSession($postArr['id']);
			return $this->json_success('login succsess');
		}
		else{
			return $this->json_fail('work ID or password is error');
		}
	}

	public function studentLogin()
	{	
		$postArr = $this->container->get('request')->getParsedBody();
		if (!(isset($postArr['id']) && isset($postArr['password']))) {
			return $this->json_fail('fail');
		}
		//检查是否为空，是否有非法输入
		Common\CheckCommon::inputCheck($postArr);
		//验证码是否正确
		/*$_SESSION['captcha'] = "abcd";
		if ($_SESSION['captcha'] !== $postArr['captcha']) {
			return $this->json_fail('captcha error');
		}*/
		//学号和密码是否正确
		$result = $this->container['db']->has('students',[
			"AND"=>[
				'stu_id'=>$postArr['id'],
				'password'=>md5($postArr['password'])
			]
		]);
		if($result){
			Common\SessionCommon::setSession($postArr['id']);
			return $this->json_success('login succsess');
		}
		else{
			return $this->json_fail('student ID or password is error');
		}
	}

	

}