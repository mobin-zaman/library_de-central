<?php
	session_start();
    if(isset($_SESSION['u_id'])){
      header("Location: home.php");
      exit;
    }

	
 //establish connection
 $conn = new mysqli('localhost','root','amarsql','library');
 	if($conn->connect_error) die("connection to db failed");

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$username=mysqli_real_escape_string($conn, $_POST["userName"]);
   

	$sql="SELECT u_id FROM user WHERE username='$username'";
	$result=($conn->query($sql));
//checking if the name is unique
	if($result->num_rows!=0) {
		$_SESSION['same_username_error']="someone else has thought that name before you. sorry!.<br>";
		echo "<script> location.href='signup.php'; </script>";
		exit;
	}

//name is unique, then
	else{
        $confirm_pass=mysqli_real_escape_string($conn, $_POST["confirm_pass"]);
        $password=mysqli_real_escape_string($conn, $_POST["password"]);
		$email=mysqli_real_escape_string($conn, $_POST["email"]);
		$phone=mysqli_real_escape_string($conn, $_POST["phone"]);
		
		/*
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$_SESSION['invalid_email']="Email is invalid, submit again";
			echo "<script> location.href='signup.php'; </script>";
			exit;

		}
		*/

		//checking if two passwords are same
		if($password==$confirm_pass){
			//now update user table
			$sql="INSERT INTO user (username, email, phone) VALUES ('$username', '$email', '$phone')";
			$conn->query($sql);

			$hashed_password=password_hash($password,PASSWORD_DEFAULT);

			//now store the hashed password in the login table
			//this sql is to fetch foreign key
			$sql="SELECT u_id FROM user WHERE username='$username'";

			$result=$conn->query($sql);

			$row=$result->fetch_assoc();


			//now finally storing into login
			$sql="INSERT INTO login (u_id,username,password) VALUES ('$row[u_id]','$username','$hashed_password')";
			
			$conn->query($sql);

			$_SESSION['login_success']="signup successful! now log in.";

           //now redirect to login page 
			 echo "<script> location.href='index.php'; </script>";
			 exit;

		}
		//or else 
		else{
			 $_SESSION['password_error']="password didn't match, fill the form again<br>";
			 echo "<script> location.href='signup.php'; </script>";
			 exit;
    }

} 
     exit;
}
?>