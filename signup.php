<?php session_start(); 
    if(isset($_SESSION['u_id'])){
      header("Location: home.php");
      exit;
    }
  ?>

<html>
<head>
  <title>Library de-central </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
</head>

<body>


  <header class="w3-container w3-theme w3-padding" id="myHeader">
    <div class="w3-center">
    <h4>LIBRARY WITHOUT ANYTHING</h4>
    <h1 class="w3-xxxlarge w3-animate-bottom">Library De-Central</h1>
      <div class="w3-padding-32">
        <a href="index.php" class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">Log In</a>
      </div>
    </div>
  </header>



  <form class="w3-container w3-card-4" style = "padding-bottom: 20px" method="post" action="sign_up.php">
    <h2>Sign up</h2>
    <?php
    //inorder to pass messages
    	if(!empty($_SESSION['same_username_error']))
    	{
        $msg = $_SESSION['same_username_error'];
        echo "<div class=\"w3-col w3-container m2 w3-blue-grey\"><p>".$msg."</p></div><br>";
    		unset($_SESSION['same_username_error']);
    	}
    	else if(!empty($_SESSION['password_error'])){
    		$msg =  $_SESSION['password_error'];
        echo "<div class=\"w3-col w3-container m2 w3-blue-grey\"><p>".$msg."</p></div><br>";
        unset($_SESSION['password_error']);
      }
      
      else if(!empty($_SESSION['invalid_email'])){
        $msg =  $_SESSION['invalid_email'];
        echo "<div class=\"w3-col w3-container m2 w3-blue-grey\"><p>".$msg."</p></div><br>";
        unset($_SESSION['invalid_email']);
      }
    	
     ?>
    <div class="w3-section">
      <input class="w3-input" type="text" name="userName" required>
      <label>Username</label>
    </div>
    <div class="w3-section">
      <input class="w3-input" type="password" name="password" required>
      <label>Password</label>
    </div>
    <div class="w3-section">
      <input class="w3-input" type="password" name="confirm_pass" required>
      <label>Confirm Password</label>
    </div>
    <div class="w3-section">
      <input class="w3-input" type="text" name="email">
      <label>email</label>
    </div>
    <div class="w3-section">
      <input class="w3-input" type="text" name="phone">
      <label>phone</label>
    </div>
   

     <input type="submit" class="w3-button w3-black" value="Submit">
  </form>



</body>
</html>




