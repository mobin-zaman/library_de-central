<?php
     session_start();

     if(!isset($_SESSION['u_id'])){
     $_SESSION['log_in_first']="Log in to view this page";
     header("Location: index.php");
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

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
   
    	if(!empty($_SESSION['restore_success']))
    	{
        $msg = $_SESSION['restore_success'];
        echo "<div class=\"w3-col w3-container m2 w3-blue-grey\"><p>".$msg."</p></div><br>";
    		unset($_SESSION['restore_success']);
    	}
    	//empty info
    	else if(!empty($_SESSION['delete_success'])){
    		$msg =  $_SESSION['delete_success'];
        echo "<div class=\"w3-col w3-container m2 w3-blue-grey\"><p>".$msg."</p></div><br>";
    		unset($_SESSION['delete_success']);
        }
        else if(!empty($_SESSION['edit_success'])){
    		$msg =  $_SESSION['edit_success'];
        echo "<div class=\"w3-col w3-container m2 w3-blue-grey\"><p>".$msg."</p></div><br>";
    		unset($_SESSION['edit_success']);
        }
        echo "<br>";

?>
    

<h2>Provide the book id to get info about the book</h2>
<h4> Then edit the info of an existing book</h4>
<div class="w3-half">
<form class="w3-container w3-card-4" action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>' method="POST">
  <div class="w3-section">      
    Book id: <input class="w3-input" type="text" name="b_id" required><input type="submit" class="w3-button w3-black" value="look up">

</div>
    </form>
<?php

    if($_SERVER['REQUEST_METHOD']=='POST'){
        //$u_id for checking if the book belongs to current user
        $u_id=$_SESSION['u_id'];
        //set connection and run query
        $conn = new mysqli('localhost','root','amarsql','library');
                if($conn->connect_error) die("connection to db failed");

        $b_id=mysqli_real_escape_string($conn, $_POST["b_id"]);

    
        $sql="SELECT title,author,isbn,category,entry_time,is_deleted FROM book WHERE b_id='$b_id' AND u_id='$u_id'";
        $result=$conn->query($sql);

        //first check if the book exists
        if($result->num_rows==0) die("the book does not exist or maybe the book is not yours");

        //then check if the book has been deleted
        $row=$result->fetch_assoc();
        //here the result will be printed
        echo '<div class="w3-half" style="padding-left: 10px; padding-top: 20px">
            <div class="w3-card-4 w3-container">
            <ul class="w3-ul w3-border w3-hoverable">
                <li class="w3-theme">Book Info</li>
                <li>Book id: '.$b_id.'<br>
                <li>Book title: '.$row['title'].'<br>
                <li>Book author: '.$row['author'].'<br>
                <li>category: '.$row['category'].'<br>
                <li>ISBN  No.: '.$row['isbn'].'<br>
                <li>Entry time: '.$row['entry_time'].'<br>
            </ul>
            </div>
        </div>
        ';
        echo '<br>';
            
        //session variable to pass b_id in edit_db.php
        $_SESSION['b_id']=$b_id;

        if($row['is_deleted']==1) {
            echo "the book has been deleted<br>";
            echo "restore the book?<br>";
            //now restoring the books
            //logout needs to be added
            echo("<form class=\"w3-container w3-card-4\" style = \"padding-bottom: 20px\" action='edit_db.php' method='post' ><input type='submit'  value='restore' class='w3-button w3-black' name='restore'></form>");             
           
        }
        else {

          echo'  
          <div class="w3-half" style="padding-left: 10px; padding-bottom: 10px;">
            <form class="w3-container w3-card-4" method="post" action="edit_db.php">
                <ul class="w3-ul w3-border w3-hoverable">
                    <li class="w3-theme">Put Values to Edit</li> 
                  </ul>
                          <div class="w3-section">
              <label>Title</label> <input class="w3-input" type="text" name="title" >
              </div>
              <div class="w3-section">
              <label>Author</label> <input class="w3-input" type="text" name="author" >
              </div>
              <div class="w3-section">
              <label>Category</label> <input class="w3-input" type="text" name="category">
              </div>
              <div class="w3-section">
              <label>isbn</label> <input class="w3-input" type="text" name="isbn">
              </div>
              <input type="submit" class="w3-button w3-black" value="Edit" name="edit">
              </form>
          </div>         


          
       
         ';

         echo ' <div style="padding-left: 10px; padding-bottom: 10px;"> <i class="fas fa-exclamation-circle" style="color:red;"></i>
           Or, Delete this book</div> ';
         echo("<form class=\"w3-container w3-card-4\" style = \"padding-bottom: 20px\" action='edit_db.php' method='post' ><input type='submit' class='w3-button w3-black'  value='delete' name='delete'></form>");             

        
        }


    }

?>

