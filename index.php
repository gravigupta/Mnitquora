<?php
session_start();
include 'connection.php';
include 'links.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    #hidescroll::-webkit-scrollbar {
      display: none;
   
    }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
   
   
   
    <title>Index page</title>
   
</head>
<body style="background-color:		 #e6e6e6;">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <a href="home.php" style="margin-left:10px;"class="navbar-brand">MNIT-Quora</a> 
          <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse " id="navbarNavDropdown">
          <ul class="navbar-nav ">
          <li class="nav-item"><a href="add_post.php" class="nav-link">add_post</a></li>
          <li class="nav-item"><a href="ask.php" class="nav-link">Ask-?</a></li>
          <li class="nav-item"><a href="rvoice2.php" class="nav-link">RaiseIssue<i class="text-warning fa fa-bullhorn"></i></a></li>
          </ul>
          <div class="justify-content-end">
          <ul class=" navbar-nav ">
          <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
          <li class="nav-item"><a href="signup.php" class="nav-link">Register</a></li>
          
          </ul>
          </div>
          </div>
          </nav>
          <div id="hidescroll"class="container col-md-5 col-sm-8 mt-2 px-0" style="height:100%; overflow-y:scroll; ::-webkit-scrollbar-display: none; " >


<?php 

  $query="SELECT * from post order by time desc ";
  $result=mysqli_query($con,$query);
  while($row= mysqli_fetch_array($result)){
    $des=$row['description'];
    $file=$row['file'];
 
?>

<div  class="card container-fluid py-2" style="margin-bottom:5%; background-color:			 #FFFFFF; 

" class="mb-2 pb-2">
   
       <div class="card-header mb-2 " style="background-color:	 #d9d9d9; border-radius:5px;">
       <div class="mx-1 " style="">
       <p class="mx-2 ">
      <span style="font-weight:bold; "> <?php echo $row['name'];?><span>
       <span style="float:right ;">posted at <?php echo $row['time'];?></span>
       </div></p>
       </div>          
       <img class="card-img-top img-fluid height:10px;" src="home_pic/<?php echo $file;?>"> 


<div class="card-body my-2" style="background-color:	 #d9d9d9; border-radius:5px;">
<p class="card-text"><?php echo $des;?> </p>
</div>

<div>
<form class="form-group" action="postcomment.php?post_id=<?php echo $row['index'];?>" method="post">

<textarea class="form-control" placeholder="comment" name="comment" required minlength="5"></textarea>


<button class="btn-sm btn-primary mt-1" type="submit" name="post_cmt">comment</button>
<span><a data-toggle="collapse" href="#id<?php echo $row['index'];?>" 
style="float:right"> more comments </a>
</span>


</form>

</div>





<div id="id<?php echo $row['index'];?>" class="collapse">
<?php
      $idd=$row['index'];
       $query="SELECT * from comments where post_id=$idd order by time desc";
      $reesult= mysqli_query($con,$query);
 while($row2=mysqli_fetch_array($reesult)){
   $comment=$row2['comment'];
   ?>

   <div >
    <div ><span style="font-weight:bold;"><?php echo $row2['name'];?></span><span style="float:right;"> at <?php echo $row2['time'];?></span>
    </div>
</div>
<div style=" border-radius:5px; background-color:	 	 #d9d9d9;" > 
<p class="mx-2">
<?php echo $row2['comment'];?>

</div>



  
<?php
 }
   
?>

</div>
</div>
<?php
  } ?>

</div>












         
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
