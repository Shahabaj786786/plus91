<?php 
	include "config.php";
	$id=$_POST["id"];
	// echo $id;die;
	$name=$_POST["name"];
	$age=$_POST["age"];
	$dob=$_POST["dob"];
	$mobile=$_POST["mobile"];


		if($id=="0"){
			$sql="insert into dbphon (name,age,dob,mobile_number) values ('$name','$age','$dob','$mobile')";
			if($con->query($sql)){
				$id=$con->insert_id;
				echo"<tr class='{$id}'>
					<td>{$name}</td>
					<td>{$age}</td>
					<td>{$dob}</td>
					<td>{$mobile}</td>
					<td><a href='#' class='btn btn-primary edit' id='{$id}'>Edit</a></td>
					<td><a href='#' class='btn btn-danger del' id='{$id}'>Delete</a></td>					
				</tr>";
				
			}
		}else{
			$sql="update dbphon set name='{$name}',age='{$age}',dob='{$dob}',mobile_number='{$mobile}' where id='{$id}'";
			// echo $sql;
			// exit;
			if($con->query($sql)){
				echo"
					<td>{$name}</td>
					<td>{$age}</td>
					<td>{$dob}</td>
					<td>{$mobile}</td>
					<td><a href='#' class='btn btn-primary edit' id='{$id}'>Edit</a></td>
					<td><a href='#' class='btn btn-danger del' id='{$id}'>Delete</a></td>					
				";
			}
		}



	
?>