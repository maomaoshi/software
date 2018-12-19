<?php
namespace Controllers;

/**
* 
*/
class HelloController extends BaseController
{
	
	public function hello()
	{
		$result = $this->container['db']->select("groups","*");
		var_dump($result);
	}
}
