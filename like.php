<?php

session_start();
include 'connection.php';

$username=$_SESSION['username'];
$email=$_SESSION['email'];
$idi=$_GET['q'];
$t=$_GET['t'];

if($t==0)
{
  $select="select * from ilikes where email='$email' AND idi='$idi'";
  $squery=mysqli_query($con,$select);
  $row=mysqli_num_rows($squery);
  if($row==0)
  {
      $insertlike="insert into ilikes(idi, email, username) values('$idi', '$email', '$username')";
      $insertl=mysqli_query($con,$insertlike);
  }
   
  $getlikes="select * from ilikes where idi='$idi'";
  $getl=mysqli_query($con,$getlikes);
  $likes=mysqli_num_rows($getl);
  echo $likes;
}
else{
    $select="select * from idislike where email='$email' AND idi='$idi'";
    $squery=mysqli_query($con,$select);
    $row=mysqli_num_rows($squery);
    if($row==0)
    {
        $insertdlike="insert into idislike(idi, email, username) values('$idi', '$email', '$username')";
        $insertdl=mysqli_query($con,$insertdlike);
    }
     
    $getdlikes="select * from idislike where idi='$idi'";
    $getdl=mysqli_query($con,$getdlikes);
    $dlikes=mysqli_num_rows($getdl);
    echo $dlikes;
}
?>

