<?php

session_start();
include 'connection.php';

$username=$_SESSION['username'];
$email=$_SESSION['email'];
?>


<?php

if(isset($_POST['icomment']))
{
    $icomment=mysqli_real_escape_string($con,$_POST['comment']);
    $idi=$_GET['id'];
    $insertcomment="insert into icomments(idi, email, username, comment) values('$idi', '$email', '$username', '$icomment')";
    $incomment=mysqli_query($con,$insertcomment);
    if(!$incomment)
    {
     ?>
     <script>alert('comment insert failed');</script>
     <?php
    }
    else{
        header('location:rvoice.php');
    }
}



?>