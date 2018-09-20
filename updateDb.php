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

<h1> update the db </h1>

        <div class="w3-half" style="padding-left: 10px; padding-bottom: 10px;">
            <form class="w3-container w3-card-4" action="update_db.php" method="post">
                <ul class="w3-ul w3-border w3-hoverable">
                    <li class="w3-theme">please give info the way it is written on the book</li> 
                  </ul>
        <div class="w3-section">
              <label>Title</label> <input class="w3-input" type="text" name="title" >
              </div>
              <div class="w3-section">
            <label>Author</label> <input class="w3-input" type="text" name="author" >
              </div>
              <div class="w3-section">
              <label>Category</label> <input class="w3-input" type="text" name="category" required>
              </div>
              <div class="w3-section">
              <label>isbn</label> <input class="w3-input" type="text" name="isbn">
              </div>
              <input type="submit" class="w3-button w3-black" value="Update">
              </form>
          </div> 

<?php
//inorder to pass messages 
    //login_info wrong
	if(!empty($_SESSION['empty_book_info']))
	{
		//sadat, here will be html formatting
		echo $_SESSION['empty_book_info'];
		unset($_SESSION['empty_book_info']);
    }
    
 ?>