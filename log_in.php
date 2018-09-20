<?php
    session_start();
   
    if(isset($_SESSION['u_id'])){
      header("Location: home.php");
      exit;
    }


    if($_SERVER["REQUEST_METHOD"]=="POST" ){
        //collect name and Password

             //create connection with db
             $conn = new mysqli('localhost','root','amarsql','library');
                     //check connection
        if ($conn->connect_error) die("connection failed ".$conn->connect_error);


        $username=mysqli_real_escape_string($conn, $_POST["userName"]);
        $password=mysqli_real_escape_string($conn, $_POST["password"]);

        //sql for validating
        //first checking if the user name exists
        $sql="SELECT l_id FROM login WHERE username='$username'";
        $result=$conn->query($sql);
        $row=$result->fetch_assoc();

        if($result->num_rows==0) {
           $_SESSION['wrong_login_info']="wrong username / password"."<br>"."login failed";
              echo "<script> location.href='index.php'; </script>";
              exit;
        }
        //now password
        $sql="SELECT password FROM login WHERE username='$username'";
        $result=$conn->query($sql);
        $row=$result->fetch_assoc();
        //matching the password with hash in db
        if(password_verify($password,$row['password'])){
            //getting the u_id for further use
                $sql="SELECT u_id FROM user WHERE username='$username'";
                $result=$conn->query($sql);
                $u_id=$result->fetch_assoc();
                $_SESSION["u_id"]=$u_id['u_id'];
	         echo "<script> location.href='home.php'; </script>";
            //then the list will start here
            }
        else $_SESSION['wrong_login_info']="wrong username / password"."<br>"."login failed";
        echo "<script> location.href='index.php'; </script>";
        exit;
    }
  


 ?>
