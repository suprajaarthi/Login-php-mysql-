<?php 

	$username = $_POST['uname'];
	$password = $_POST['pass'];
	$gender = $_POST['gender'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	if(!empty($username) && !empty($password) && !empty($gender) && !empty($email) && !empty($phone))
	{
		$servername = "localhost";
		$usernam = "root";
		$passwor = "";
		$dbname = "safety_band";
		$conn = new mysqli($servername, $usernam, $passwor, $dbname);
		if(mysqli_connect_error())
		{

			
			die('Connection error('.mysqli_connect_errno().')'.mysqli_connect_error());
		}
		else
		{
			$SELECT = "SELECT email FROM register WHERE email = ? LIMIT 1";
			$INSERT = "INSERT INTO register(username,password,gender,email,phone) values (?,?,?,?,?)";
			$stmt = $conn->prepare($SELECT);
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$stmt->bind_result($email);
			$stmt->store_result();
			$rnum = $stmt->num_rows;

			if($rnum==0)
			{
				$stmt->close();
				$stmt = $conn->prepare($INSERT);
				$stmt->bind_param("ssssi",$username,$password,$gender,$email,$phone);
				$stmt->execute();
				echo "New record inserted successfully";
			}
			else
			{
				echo "Someone already registerd";
			}
			$stmt->close();
			$conn->close();
		}
	}
	else
	{
		echo "All Fields Are Required";
		die();
	}

?>