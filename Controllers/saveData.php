<?php
include 'connection.php';
session_start();
if($_POST['type'] == 1){
	$name = $_POST['username'];
	$password = $_POST['password'];
	$name = $_POST['name'];
	$bdate = $_POST['bdate'];
	$sex = $_POST['sex'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];

	$check_duplicate = mysqli_query($conn, "selct * from users where username='$username'");
	if (mysql_num_rows(($check_duplicate) > 0){
		echo json_encode(array("statusCode=>201"));
	} else {
		$sql = "INSERT  INTO 'user'('username','password','name','bdate' , 'sex', 'email', 'phone') VALUES ('$username','$password','$name','$bdate' , '$sex', '$email', '$phone')";
		if (mysql_query($conn, $sql)){
			echo json_encode(array("statusCode=>200"));
		}else {
			echo json_encode(array("statusCode=>201"));
		}
		mysql_close($conn);
	}
}
if($_POST['type'] == 2){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$validCheck = mysql_query($conn, "select * from users where username = '$username and password=$password");
	if(mysql_num_rows($validCheck) > 0){
		$_SESSION['username'] = $username;
		$_SESSION['name'] = $name; //display ten cua user;
	}
	else{
		echo json_encode(array("statusCode"=>201));
	}
}


?>