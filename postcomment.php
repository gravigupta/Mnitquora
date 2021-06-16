<?php
session_start();

if(!isset($_SESSION['name'])){
    header('location: login.php');
}
else{
$name=$_SESSION['name'];
$con =mysqli_connect('localhost','root','','QUORA_db');
$div_id=$_GET['post_id'];

if(isset($_POST['post_cmt'])){
    $comment=mysqli_real_escape_string($con,$_POST['comment']);

    $query="INSERT into comments(post_id,name,comment) values('$div_id','$name','$comment')";
    mysqli_query($con,$query);

     header('location: home.php');

}
}

?>
