<?php
class Controller extends Database{
	public static function CreateView($viewName){

		require_once("./Views/$viewName.html");
	}
	public static function logOut($controllerName){
		require_once("./Controllers/$controllerName.php");
	}
}
?>