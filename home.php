<?php session_start();
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
        <div class="w3-container">
    
    <div class="w3-bar w3-theme">
      <a href="updateDb.php" class="w3-bar-item w3-button w3-padding-16">Update Database</a>
      <a href="editDb.php" class="w3-bar-item w3-button w3-padding-16">Edit or delete</a>
      <a href="issueReturn.php" class="w3-bar-item w3-button w3-padding-16">Issue or Return</a>
      <a href="log_out.php" class="w3-bar-item w3-button w3-padding-16">Log out</a>
</div>
      </div>
    </div>
  </header>


<?php 
    $conn=new mysqli('localhost','sadatjub_book','*BFQK^QQRIi;','sadatjub_lib');   
    //user id for the query
    $u_id=$_SESSION['u_id'];
    $sql="SELECT book.b_id,book.title,book.author,book.category,user.username FROM book,user WHERE book.u_id=user.u_id AND is_deleted='0' AND is_issued='0' order by book.b_id desc";
    $result=$conn->query($sql);
    //html code goes here for table
    echo '<div class="w3-container">';
    echo '<hr>';
    echo '<div class="w3-center">';
    echo '<h2>Books available for issuing</h2>';
    echo '</div>';
    echo '<div class="w3-responsive w3-card-4">';
    echo '<table class="w3-table w3-striped w3-bordered">';
    echo '<thead>';
    echo '<tr class="w3-theme">';
    echo '<th>Book Id</th>';
    echo '<th>Title</th>';
    echo '<th>Author</th>';
    echo '<th>Category</th>';
    echo '<th>Owner</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while($row=$result->fetch_assoc()){
    echo '<tr class="w3-white">';
    echo '<td>'.$row["b_id"].'</td>';
    echo '<td>'.$row["title"].'</td>';
    echo '<td>'.$row["author"].'</td>';
    echo '<td>'.$row["category"].'</td>';
    echo '<td>'.$row["username"].'</td>';
    echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
//ongoing issues 
    
$sql="SELECT book.b_id,book.title,book.author,book.category,user.username FROM book,user WHERE book.u_id=user.u_id AND is_deleted='0' AND is_issued='1' order by entry_time desc";
$result=$conn->query($sql);
$sql="SELECT user.username FROM book,user WHERE book.last_issue=user.u_id AND is_deleted='0' AND is_issued='1' order by entry_time desc";
$result2=$conn->query($sql);
//html code goes here for table
echo '<div class="w3-container">';
echo '<hr>';
echo '<div class="w3-center">';
echo '<h2>Ongoing issues</h2>';
echo '</div>';
echo '<div class="w3-responsive w3-card-4">';
echo '<table class="w3-table w3-striped w3-bordered">';
echo '<thead>';
echo '<tr class="w3-theme">';
echo '<th>Book Id</th>';
echo '<th>Title</th>';
echo '<th>Author</th>';
echo '<th>Category</th>';
echo '<th>Owner</th>';
echo '<th>Issued to</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
//array for priting borrowers
$a=array();
$i=0;
while($row2=$result2->fetch_assoc()) {
  $a[]=$row2["username"];
  $i++;
}
$i=0;
while($row=$result->fetch_assoc())
{
echo '<tr class="w3-white">';
echo '<td>'.$row["b_id"].'</td>';
echo '<td>'.$row["title"].'</td>';
echo '<td>'.$row["author"].'</td>';
echo '<td>'.$row["category"].'</td>';
echo '<td>'.$row["username"].'</td>';
echo '<td>'.$a[$i++].'</td>';
echo '</tr>';
}
echo '</tbody>';
echo '</table>';
echo '</div>';
    //ends here
    
?>
    </body>
  </html>