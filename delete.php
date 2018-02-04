		<?php
		$conn = new mysqli("localhost", "root", "", "student") or die(mysqli_error());
		$conn->query("DELETE FROM `registration` WHERE `reg_id` = '$_GET[reg_id]'") or die(mysqli_error());
		$conn->close();
		echo "<script type='text/javascript'>alert('Successfully deleted record!');</script>";
		echo "<script>document.location='index.php'</script>";  
		?> 