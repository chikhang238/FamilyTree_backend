<?php
session_start();
if($_SESSION["username"] !=NULL && $_SESSION["password"] != NULL){
	unset($_SESSION["username"]);
undet($_SESSION["password"]);
}
?>
