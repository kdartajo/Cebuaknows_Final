<?php
	session_start();
	$conn = new mysqli('localhost','root','','cebuaknows');
	if(!$conn){
		die(mysqli_error($conn));
	}
?>