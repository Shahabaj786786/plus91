<?php
	include "config.php";
?>
<html>
	<head>
		<title>Ajax CRUD</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">

	</head>
	<body>
	<div class="container">
		<h3 class='text-center'>Ajax CRUD Operation</h3><hr>
		<div class='row'>
		<div class="col-md-3">
				
			</div>
			<div class="col-md-6">
				<form id='frm'>
				  <div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" name="name" id='name'  placeholder="Enter Your Name" required>
					
				  </div>
				  <div class="form-group">
					<label>Age</label>
					<input type="text" class="form-control" name="age" id='age'  placeholder="Enter Your Age" required>
				  </div>
				  <div class="form-group">
					<label>Date of Birth</label>
					<input type="date" class="form-control" name="dob" id='dob'  placeholder="Enter Date of Birth" required>
				  </div>
				  <div class="form-group">
					<label>Mobile No</label>
					<input type="text" class="form-control"  name="mobile" id='mobile'  placeholder="Enter Mobile Number" required maxlength="10">
				</div>
				  
				  <input type="hidden" class="form-control" name="id" id='id'  value='0' placeholder="" >
				  
				  <center><button type="submit" name="submit" id="submit" class="btn btn-success">Add User</button>
				  <button type="button" id="clear" class="btn btn-warning">Clear</button></center>
				</form> 
			</div>
		  
		  </div>
		  <div class="row">
			<div class="col-md-12">
				<table class="table table-bordered" id='table'>
					<thead>
						<tr>
							<th>Name</th>
							<th>Age</th>
							<th>Date of Birth</th>
							<th>Mobile Number</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql="select * from dbphon";
							$res=$con->query($sql);
							if($res->num_rows>0)
							{
								while($row=$res->fetch_assoc())
								{	
									echo"<tr class='{$row["id"]}'>
										<td>{$row["name"]}</td>
										<td>{$row["age"]}</td>
										<td>{$row["dob"]}</td>
										<td>{$row["mobile_number"]}</td>

										<td><a href='#' class='btn btn-primary edit' id='{$row["id"]}'>Edit</a></td>
										<td><a href='#' class='btn btn-danger del' id='{$row["id"]}'>Delete</a></td>					
									</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>
			<div>
		</div>
	</div>	
	<script>
		$(document).ready(function(){
			
			//Clear all the Fields
			$("#clear").click(function(){
				$("#name").val("");
				$("#age").val("");
				$("#dob").val("");
				$("#mobile").val("");
				$("#submit").text("Add User");
			});
			
			//Insert and update using jQuery ajax
			// $("#submit").click(function(e){
			// 	e.preventDefault();
			
			// 		$.ajax({
			// 			type:'POST',
			// 			url:'insert.php',
			// 			data:$("#frm").serialize(),
			// 			success:function(res){
			// 				// alert(res);
			// 				var id=$("#id").val();
			// 				if(id=="0"){
			// 					$("#table").find("tbody").append(res);
			// 				}else{
			// 					$("#table").find("."+id).html(res);
			// 				}
							
			// 				$("#clear").click();
			// 				$("#submit").text("Add User");
			// 			}
			// 		});
				
			// });

			$("#submit").click(function(e){
				e.preventDefault();
				var btn=$(this);
				var id=$("#id").val();
				
				//Check All Fields are filled
				var required=true;
				$("#frm").find("[required]").each(function(){
					if($(this).val()==""){
						alert($(this).attr("placeholder"));
						$(this).focus();
						required=false;
						return false;
					}
				});
				if(required){
					$.ajax({
						type:'POST',
						url:'insert.php',
						data:$("#frm").serialize(),
						beforeSend:function(){
							$(btn).text("Wait...");
						},
						success:function(res){
							// alert(res);
							var id=$("#id").val();
							if(id=="0"){
								$("#table").find("tbody").append(res);
							}else{
								$("#table").find("."+id).html(res);
							}
							
							$("#clear").click();
							$("#submit").text("Add User");
						}
					});
				}
			});
			
			
			//Delete row using jQuery ajax
			$("body").on("click",".del",function(e){
				e.preventDefault();
				var id=$(this).attr("id");
				// alert(id);
				var btn=$(this);
				if(confirm("Are You Sure ? ")){
					$.ajax({
						type:'POST',
						url:'delete.php',
						data:{id:id},
						beforeSend:function(){
							$(btn).text("Deleting...");
						},
						success:function(res){
							// alert(res);
							if(res){
								btn.closest("tr").remove();
							}
						}
					});
				}
			});
			
			//fill all fields from table values
			$("body").on("click",".edit",function(){
				var id=$(this).attr("id");
				// alert(id);
				$("#id").val(id);
				var row=$(this);
				var name=row.closest("tr").find("td:eq(0)").text();
				$("#name").val(name);
				var age=row.closest("tr").find("td:eq(1)").text();
				$("#age").val(age);
				var dob=row.closest("tr").find("td:eq(2)").text();
				$("#dob").val(dob);
				var mobile=row.closest("tr").find("td:eq(3)").text();
				$("#mobile").val(mobile);
			});
		});
	</script>
	</body>
</html>