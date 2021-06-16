<?php
session_start();

include 'links.php';
include 'connection.php';

$username=$_SESSION['username'];
$email=$_SESSION['email'];

if(!isset($username))
{
    header('location:login.php');
}

?>
<html>
<head>
<title>Our Users!</title>
</head>
<body>
<h1 class="bg-info text-warning py-2 pl-2 mx-1" style="border-radius:5px">Our <span class="text-white">Users!</span></h1>
<div class="ml-2">
<h4>Filter Users:</h4>
<button class="btn btn-sm btn-outline-info mx-1 my-1">New users</button>
<button class="btn btn-sm btn-outline-info mx-1 my-1">college</button>
<button class="btn btn-sm btn-outline-info mx-1 my-1">Degree</button>
</div>
<?php
$selectuser="select * from users where email!='$email'";
$suser=mysqli_query($con,$selectuser);
while($uarray=mysqli_fetch_assoc($suser))
{
  ?>
    <div class="col-10 mx-auto my-1" style="border:2px solid #17a2b8; border-radius:10px 10px 10px 10px;">
     <div class="row container-fluid ">
      <div class="col-4 py-2">
        <img src="usericon.png" alt="profileimg" class="img-fluid mx-auto img-thumbnail d-block">
      </div>
      <div class="col-6 mx-auto">
        <p class="py-1 my-1" style="word-wrap:break-word;">
         <span class="font-weight-bold text-dark"><?php echo $uarray['username']; ?></span><br>
         <span><?php echo $uarray['email']; ?></span><br>
         
        </p><br>
        <a href="message.php?username=<?php echo $uarray['username'];?>&email=<?php echo $uarray['email'];?>" 
          class="btn btn-primary col-sm-3 col-5 btn-sm btn-block" style="margin-bottom:4px;">Chat</a>
      </div>
     </div>
    </div>

  <?php
}

?>
<br><br>


</body>
</html>