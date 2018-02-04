<?php
//add record
if(ISSET($_POST['submit'])){
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$gender = $_POST['gender'];
	$age = $_POST['age'];
	$address = $_POST['address'];
	$zip = $_POST['zip'];
	$username = $_POST['username'];
	$password = $_POST['password'];

	$conn = new mysqli("localhost", "root", "", "student") or die(mysqli_error());
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$q1 = $conn->query ("SELECT * FROM `registration` WHERE `firstname` = '$firstname' && `lastname` = '$lastname'") or die(mysqli_error());
	$f1 = $q1->fetch_array();
	$check = $q1->num_rows;
	if($check > 0){
		echo "<script> alert ('Name already exist!')</script>";
		echo "<script>document.location='index.php'</script>";
	}
	else {
		$conn->query("INSERT INTO `registration` VALUES('', '$firstname', '$lastname', '$gender', '$age', '$address', '$zip', '$username', '$password')") or die(mysqli_error());
		$conn->close();
		echo "<script type='text/javascript'>alert('Successfully added new record!');</script>";
		echo "<script>document.location='index.php'</script>";  
	}
}
// edit record
if(ISSET($_POST['editrecord'])){
	$reg_id = $_POST['reg_id'];
	$firstname = $_POST['firstname'];    
	$lastname = $_POST['lastname'];
	$gender = $_POST['gender'];
	$age = $_POST['age'];
	$address = $_POST['address'];
	$zip = $_POST['zip'];
	$username = $_POST['username'];
	$password = $_POST['password'];

	$conn = new mysqli("localhost", "root", "", "student") or die(mysqli_error());
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$conn->query("UPDATE `registration` SET `firstname` = '$firstname', `lastname` = '$lastname', `gender` = '$gender', `age` = '$age', 
			`address` = '$address', `zip` = '$zip', `username` = '$username', `password` = '$password' WHERE `reg_id` = '$reg_id'") or die(mysqli_error());
	$conn->close();
	echo "<script type='text/javascript'>alert('Successfully updated record!');</script>";
	echo "<script>document.location='index.php'</script>";  
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Registration Form</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="icon" href="assets/images/users/no-image.jpg" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" id="theme" href="css/theme-brown.css" />
	</head>
	<body>
		<br>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Registration List</strong></h3>
					<div class="btn-group pull-right">
						<div class="pull-left">
							<button class="btn btn-default btn-md" onclick="Print()">Print</button>
							<button class="btn btn-default btn-md" data-toggle="modal" data-target="#new_record">New Record</button>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<table id="print" class="table datatable">
						<thead>
							<tr class="info">
								<th><center>Registration ID</center></th>
								<th><center>First Name</center></th>
								<th><center>Last Name</center></th>
								<th><center>Gender</center></th>
								<th><center>Age</center></th>
								<th><center>Address</center></th>
								<th><center>ZIP Code</center></th>
								<th><center>Username</center></th>
								<th><center>Password</center></th>
								<th><center>Action</center></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$conn = new mysqli("localhost", "root", "", "student") or die(mysqli_error());
							$query = $conn->query("SELECT * FROM `registration` ORDER BY `reg_id` DESC") or die(mysqli_error());
							while($fetch = $query->fetch_array()){
							?>
							<tr>
								<td><center><?php echo $fetch['reg_id']?></center></td>
								<td><center><?php echo $fetch['firstname']?></center></td>
								<td><center><?php echo $fetch['lastname']?></center></td>
								<td><center><?php echo $fetch['gender']?></center></td>
								<td><center><?php echo $fetch['age']?></center></td>
								<td><center><?php echo $fetch['address']?></center></td>
								<td><center><?php echo $fetch['zip']?></center></td>
								<td><center><?php echo $fetch['username']?></center></td>
								<td><center><?php echo $fetch['password']?></center></td>
								<td><center>
									<a href="#updaterecord<?php echo $fetch['reg_id'];?>" data-target="#updaterecord<?php echo $fetch['reg_id'];?>" data-toggle="modal" class="btn btn-info btn-sm"><span class="fa fa-pencil"></span></a>
									<a onclick = "return confirm('Are you sure you want to delete this record?');" href = "delete.php?reg_id=<?php echo $fetch['reg_id']?>" class = "btn btn-sm btn-danger"><span class="fa fa-times"></span></a>
									</center>
								</td>
							</tr>
							<?php
							}
							$conn->close();
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="modal fade" id="new_record" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="defModalHead"><strong>New Record</strong></h4>
					</div>
					<form role="form" class="form-horizontal" action="index.php" method="post" onsubmit="return confirm('Are you sure you want to register this record?');">
						<div class="modal-body">
							<div class="row">
								<div class="panel-body">
									<h5 class="push-up-1">First Name</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<input required data-toggle="tooltip" data-placement="bottom" title="Your First Name" type="text" class="form-control" name="firstname"/>
										</div>
									</div>
									<h5 class="push-up-1">Last Name</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<input required data-toggle="tooltip" data-placement="bottom" title="Your Last Name" type="text" class="form-control" name="lastname"/>
										</div>
									</div>
									<h5 class="push-up-1">Gender</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<select class="form-control select" name="gender">
												<option value="">Select</option>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
											</select>
										</div>
									</div>
									<h5 class="push-up-1">Age</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<input required data-toggle="tooltip" data-placement="bottom" title="Your Age" type="number" class="form-control" name="age"/>
										</div>
									</div>
									<h5 class="push-up-1">Address</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<input required data-toggle="tooltip" data-placement="bottom" title="Your Address" type="text" class="form-control" name="address"/>
										</div>
									</div>
									<h5 class="push-up-1">ZIP Code</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<input required data-toggle="tooltip" data-placement="bottom" title="Your Zip Code" type="text" class="form-control" name="zip"/>
										</div>
									</div>
									<h5 class="push-up-1">Username</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<input required data-toggle="tooltip" data-placement="bottom" title="Your Username" type="text" class="form-control"2 name="username"/>
										</div>
									</div>
									<h5 class="push-up-1">Password</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<input required data-toggle="tooltip" data-placement="bottom" title="Your Password" type="text" class="form-control" name="password"/>
										</div>
									</div>
								</div>
							</div>                       
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-info" name="submit"><span class="fa fa-check"></span>Save</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-times"></span>Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php
		$conn = new mysqli("localhost", "root", "", "student") or die(mysqli_error());
		$query = $conn->query("SELECT * FROM `registration`") or die(mysqli_error());
		while($fetch = $query->fetch_array()){
		?>

		<div id="updaterecord<?php echo $fetch['reg_id'];?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="defModalHead">Update Record</h4>
					</div>
					<form role="form" class="form-horizontal" action="index.php" method="post" onsubmit="return confirm('Are you sure you want to edit this record?');">
						<div class="modal-body">
							<div class="row">
								<div class="panel-body">
									<h5 class="push-up-1">First Name</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<input type="hidden" class="form-control" name="reg_id" value="<?php echo $fetch['reg_id'];?>">
											<input required data-toggle="tooltip" data-placement="bottom" title="Your First Name" type="text" class="form-control" name="firstname" value="<?php echo $fetch['firstname']?>"/>
										</div>
									</div>
									<h5 class="push-up-1">Last Name</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<input required data-toggle="tooltip" data-placement="bottom" title="Your Last Name" type="text" class="form-control" name="lastname" value="<?php echo $fetch['lastname']?>"/>
										</div>
									</div>
									<h5 class="push-up-1">Gender</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<select class="form-control select" name="gender">
												<option value="<?php echo $fetch['gender']?>"><?php echo $fetch['gender']?></option>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
											</select>
										</div>
									</div>
									<h5 class="push-up-1">Age</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<input required data-toggle="tooltip" data-placement="bottom" title="Your Age" type="number" class="form-control" name="age" value="<?php echo $fetch['age']?>"/>
										</div>
									</div>
									<h5 class="push-up-1">Address</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<input required data-toggle="tooltip" data-placement="bottom" title="Your Address" type="text" class="form-control" name="address" value="<?php echo $fetch['address']?>"/>
										</div>
									</div>
									<h5 class="push-up-1">ZIP Code</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<input required data-toggle="tooltip" data-placement="bottom" title="Your Zip Code" type="text" class="form-control" name="zip" value="<?php echo $fetch['zip']?>"/>
										</div>
									</div>
									<h5 class="push-up-1">Username</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<input required data-toggle="tooltip" data-placement="bottom" title="Your Username" type="text" class="form-control" name="username" value="<?php echo $fetch['username']?>"/>
										</div>
									</div>
									<h5 class="push-up-1">Password</h5>
									<div class="form-group ">
										<div class="col-md-12 col-xs-12">
											<input required data-toggle="tooltip" data-placement="bottom" title="Your Password" type="text" class="form-control" name="password" value="<?php echo $fetch['password']?>"/>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-info" name="editrecord"><span class="fa fa-check"></span>Update</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-times"></span>Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php
		}
		$conn->close();
		?>
		<script>
			function Print() {
				window.print();
			}	
		</script>
		<script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
		<script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>       
		<script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="js/plugins.js"></script>        
		<script type="text/javascript" src="js/actions.js"></script>
		<script type='text/javascript' src='js/plugins/bootstrap/bootstrap-select.js'></script>  

	</body>
</html>