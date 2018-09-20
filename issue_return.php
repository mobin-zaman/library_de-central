<?php 
    session_start();

if(!isset($_SESSION['u_id'])){
    $_SESSION['log_in_first']="Log in to view this page";
    header("Location: index.php");
    exit;
  }

  $conn = new mysqli('localhost','root','amarsql','library');
      if($conn->connect_error) die("connection to db failed");


    //for return
    if(isset($_POST['return'])){
        $i_id=$_SESSION['i_id'];
        $sql="INSERT INTO return_info(i_id) VALUES('$i_id')";
        $conn->query($sql);
        //now set is_returned in the b_id
        $b_id=$_SESSION['b_id'];
        $sql="UPDATE `book` SET `is_issued` = '0' WHERE `book`.`b_id` = '$b_id'; ";
        $conn->query($sql);
    
        unset($_SESSION['b_id']);
        unset($_POST['return']);
        $_SESSION['return_success']="returned!";
        echo "<script> location.href='issueReturn.php'; </script>"; 
        exit;

    }
    if(isset($_POST['issue'])){
        $username=mysqli_real_escape_string($conn, $_POST["username"]);

        $sql="SELECT u_id  FROM user WHERE username='$username'";
        //if there is no user in that name
        $result=$conn->query($sql);
        if($result->num_rows==0){
            die("username doesn't exist, go back and submit again");
        }
        
        $row=$result->fetch_assoc();


        if($_SESSION['u_id']==$row['u_id']){
            die("you want to issue the book to yourself?! go back and submit again");
        }

        $b_id=$_SESSION['b_id'];
        $issuer=$_SESSION['u_id'];
        $borrower=$row['u_id'];
        //oke now update the issue table
        $sql="INSERT INTO issue (b_id, issuer, borrower) VALUES ('$b_id', '$issuer', '$borrower')"; 
        $conn->query($sql);
        $sql="UPDATE `book` SET `is_issued` = '1' WHERE `book`.`b_id` = '$b_id'; ";
        $conn->query($sql);
        $sql="UPDATE book set last_issue='$borrower' WHERE book.b_id='$b_id'";
        $conn->query($sql);
        $_SESSION['issue_success']="issued!<br>";
        unset($_SESSION['b_id']);
        echo "<script> location.href='issueReturn.php'; </script>"; 
        exit;

        
    }
?>