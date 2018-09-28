<?php 
    session_start();

if(!isset($_SESSION['u_id'])){
  $_SESSION['log_in_first']="Log in to view this page";
  header("Location: index.php");
  exit;
}

$conn=new mysqli();
    if($conn->connect_error) die("connection to db failed");

    $b_id=$_SESSION['b_id'];

    //for restoration
    if(isset($_POST['restore'])){
        $sql="UPDATE book SET is_deleted = '0' WHERE book.b_id = '$b_id' ";
        $conn->query($sql);
        unset($_SESSION[$b_id]);
        unset($_POST['restore']);
        $_SESSION['restore_success']="restored!";
    }
    //for editing
    else if(isset($_POST['edit'])){
    
        $title=mysqli_real_escape_string($conn, $_POST["title"]);
        $author=mysqli_real_escape_string($conn, $_POST["author"]);
        $category=mysqli_real_escape_string($conn, $_POST["category"]);
        $isbn=mysqli_real_escape_string($conn, $_POST["isbn"]);

        $sql="SELECT title,author,category,isbn FROM book WHERE b_id='$b_id'";
        $result=$conn->query($sql);
        $row=$result->fetch_assoc();

        //this was done is order to prevent creating combination of queries
        if(empty($title)) {
            $title=$row['title'];
        }

        if(empty($author)) {
            $author=$row['author'];
        }

        if(empty($category)){
            $category=$row['category'];
        }

        if(empty($isbn)) {
            $isbn=$row['isbn'];
        }

        $sql="UPDATE book SET title = '$title', author = '$author', isbn = '$isbn', category = '$category' WHERE book.b_id = '$b_id'";
        $conn->query($sql);

        $_SESSION['edit_success']="edited";
        

    }
    //for deleting
    else if(isset($_POST['delete'])){
        $sql="UPDATE book SET is_deleted = '1' WHERE book.b_id = '$b_id' ";
        $conn->query($sql);
        unset($_SESSION[$b_id]);
        unset($_POST['delete']);
        $_SESSION['delete_success']="deleted!";
    }

    echo "<script> location.href='editDb.php'; </script>"; 
    exit;
?>
