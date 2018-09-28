<?php session_start(); ?>
<html>
<head>
  <title>Library de-central </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="styles.css">
  
</head>
<body>
<header class="w3-container w3-theme w3-padding" id="myHeader">
    <div class="w3-center">
    <h4>LIBRARY WITHOUT ANYTHING</h4>
    <h1 class="w3-xxxlarge w3-animate-bottom">Library De-Central</h1>
      <div class="w3-padding-32">
        <a href="userHome.php" class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">Your Library</a>
      </div>
    </div>
</header>
<?php 

if(!isset($_SESSION['u_id'])){
    $_SESSION['log_in_first']="Log in to view this page";
    header("Location: index.php");
    exit;
  }
//page reload problem
?>
<?php
    //inorder to pass messages
    	if(!empty($_SESSION['return_success'])){
        $msg = $_SESSION['return_success'];
        echo "<div class=\"w3-col w3-container m2 w3-blue-grey\"><p>".$msg."</p></div><br>";
    		unset($_SESSION['return_success']);
    	}
    	else if(!empty($_SESSION['issue_success'])){
    		$msg =  $_SESSION['issue_success'];
        echo "<div class=\"w3-col w3-container m2 w3-blue-grey\"><p>".$msg."</p></div><br>";
    		unset($_SESSION['issue_success']);
    	}
?>

<h2 style="padding-left: 10px">Provide the book id to get info about the book</h2>
<h4 style="padding-left: 10px"> Then issue another user providing username<h4>
<div class="w3-half">
<form class="w3-container w3-card-4" action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>' method="POST">
  <div class="w3-section" style="padding-left: 10px">      
    Book id: <input class="w3-input" type="text" name="b_id" required><input type="submit" class="w3-button w3-black" value="look up">

</div>
    </form>

<?php

if($_SERVER['REQUEST_METHOD']=='POST'){

    //$u_id for checking if the book belongs to current user
    $u_id=$_SESSION['u_id'];
    //set connection and run query
    $conn=new mysqli('localhost','sadatjub_book','*BFQK^QQRIi;','sadatjub_lib');
        if($conn->connect_error) die("connection to db failed");

    $b_id=mysqli_real_escape_string($conn, $_POST["b_id"]);
    if(empty($b_id)) die("enter the book id<br>");

    $sql="SELECT title,author,isbn,category,entry_time,is_deleted FROM book WHERE b_id='$b_id' AND u_id='$u_id'";
    $result=$conn->query($sql);

    //first check if the book exists
    if($result->num_rows==0) die("the book does not exist or maybe the book is not yours");

    $row=$result->fetch_assoc();
    //here the result will be printed  
        
        echo '<div class="w3-half" style="padding-left: 10px">
            <div class="w3-card-4 w3-container">
            <ul class="w3-ul w3-border w3-hoverable">
                <li class="w3-theme">Book Info</li>
                <li>ID: '.$b_id.'<br>
                <li>Title: '.$row['title'].'<br>
                <li>Aauthor: '.$row['author'].'<br>
                <li>Category: '.$row['category'].'<br>
                <li>ISBN  No.: '.$row['isbn'].'<br>
                <li>Entry time: '.$row['entry_time'].'<br>
            </ul>
            </div>
        </div>
        ';
        

        
    //session variable to pass b_id in issue_return.php
    $_SESSION['b_id']=$b_id;

    //then check if the book has been deleted
    if($row['is_deleted']==1) {
        echo "the book has been deleted<br>";
       
    }
    //if the book is issued already
    
     else{
         //not exists/ exists
        $sql="SELECT i.i_id, i.borrower from issue i  where i.b_id='$b_id' and not exists(select i_id from return_info r where r.i_id=i.i_id)";
        $result=$conn->query($sql);

        if($result->num_rows!=0){
            $row=$result->fetch_assoc();

            $borrower=$row['borrower'];
            $sql="SELECT username FROM user WHERE u_id='$borrower'";

            $result2=$conn->query($sql);
            $b=$result2->fetch_assoc();


echo "the book is issued to ".$b['username']."<br>";
        
            //get i_id for return_info 
            $_SESSION['i_id']=$row['i_id'];
            echo("<form class=\"w3-container w3-card-4\" style = \"padding-bottom: 20px\" action='issue_return.php' method='post' ><input type='submit'  value='ruturned' class='w3-button w3-black' name='return'></form>");             
           

        }


        //or available for issuing
        else {
            echo'<div style="float: left; padding: 10px;"> <div style="background-color: #607d8b;" >This book is available for issuing</div><br>
            <form class="w3-container w3-card-4" action="issue_return.php" method="POST">
            <div class="w3-section">
            Username <input class="w3-input" type="text" name="username" required>
            <input type="submit" class="w3-button w3-black" value="issue" name="issue">
            </div>
            </form></div>' ;          
            
        }


  }
}



?>




</body>
</html>
