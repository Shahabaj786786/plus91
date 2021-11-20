<?php 
	include "config.php";
	$id=$_POST["id"];

	$sql="delete from dbphon where id='{$id}'";
	if($con->query($sql)){
		echo true;
	}else{
		echo false;
	}
?>