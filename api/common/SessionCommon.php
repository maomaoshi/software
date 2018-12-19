<?php
namespace common;

/**
* 
*/
class SessionCommon 
{
	
	public static function setSession($id, $expire = 3600)
	{
		$_SESSION['id'] = $id;
		$_SESSION['$expire'] = time() + $expire;
	}
	
	public static function clearGroupSession($id)
	{
		unnset($_SESSION['id']);
		unset($_SESSION['expire']);
	}
}