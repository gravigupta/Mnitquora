<?php
session_start();

include 'links.php';
include 'connection.php';

$username=$_SESSION['username'];
$email=$_SESSION['email'];
$otheruser=$_SESSION['otheruser'];
$otheremail=$_SESSION['otheremail'];
if(isset($_GET['msg']))
{
$msg=$_GET['msg'];
}

if(isset($_GET['online'])){
 $checksession="select *from session where email='$otheremail'";
 $csession=mysqli_query($con,$checksession);
 $session=mysqli_fetch_assoc($csession);
 if($session['intime']>$session['outtime'])
 {
   echo "<span class='text-primary mx-1'>(online)</span>";
 }
 else
  echo "<span class='text-warning mx-1'>(Last seen: ".$session['outtime'].")</span>";
}
else if(isset($msg)){

$insertmsg="insert into chats(sname, semail, rname, remail, msg) values('$username', '$email', '$otheruser', '$otheremail', '$msg')";
$imsg=mysqli_query($con,$insertmsg);

}
else{
    $selectmsg="select * from chats where (semail='$email' OR semail='$otheremail') AND (remail='$email' OR remail='$otheremail') order by datetime";
 $smsg=mysqli_query($con,$selectmsg);
 $rows=mysqli_num_rows($smsg);
 if($rows==0)
  echo"<div class='text-center alert-primary my-3 p-2 font-weight-bold'>There are no messages!</div>";
 
 while($marray=mysqli_fetch_assoc($smsg))
 {
   if($marray['semail']===$email)
   {
     echo "<div class='text-white bg-info my-1 pr-1 py-1' 
    style='display:block; max-width:60%;margin-left:40%;margin-right:4px;border:3px solid black;border-radius:10px 10px 10px 10px;'>
      <img src='usericon.png' class='mr-1 rounded ml-1' style='float:right;height:5%;width:auto;'/>
      <p class='text-dark text-right'>".$marray['msg']."</p></div>";
   }
   else{
    echo "<div class='text-white bg-warning my-1 pl-1 py-1' 
   style='display:block;max-width:60%;margin-left:4px;border:3px solid black;border-radius:10px 10px 10px 10px;'>
     <img src='usericon.png' class='ml-1 rounded mr-1' style='float:left; height:5%;width:auto;'/>
     <p class='text-dark text-left'>".$marray['msg']. "</p></div>";
   }
    
    
 }
}
?>



