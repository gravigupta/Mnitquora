<?php
session_start();
?>

<?php 
  include 'connection.php';
  include 'links.php';
  if(isset($_POST['submit']))
{
$email=$_POST['email'];
$password=$_POST['password'];


$emailquery="select * from users where email='$email'";
$equery=mysqli_query($con,$emailquery);
$rows=mysqli_num_rows($equery);

if($rows)
{ 
  $darray=mysqli_fetch_assoc($equery);
  $db_pass=$darray['password'];

  $passcheck= password_verify($password,$db_pass);
  if($passcheck)
  {  $user=$darray['username'];
     $_SESSION['username']=$user;
     $_SESSION['email']=$email;
     $intime=date("Y-m-d H:i:s");
     $updatesession="update session set intime='$intime' where email='$email'";
     $usession=mysqli_query($con,$updatesession);
     header("location: home.php"); 
    
  }
  else{
      ?>
      <script>
      alert('Password did Not Match!');
      </script>
      
      <?php
  }

}else{
    ?>
    <script>
    alert("E-mail is not registerd. Please sign Up!");
    </script>
    <?php
}

}

?>



<html>
<head>
<title>MnitPeople Login!</title>
</head>
<body class="bg-info" >
   <div class="container-fluid">
    <h1 class="text-info text-center bg-dark m-1 p-2">Login!</h1>
   </div>
   <?php 
      
       if(isset($_SESSION['msg'])){?>
     <div class="container">
       <div class="alert alert-info text-center font-weight-bold">
        <?php
        echo $_SESSION['msg'];} ?>
      </div>
     </div>
   <div class="container">
      <div class="form-row">
        <div class="col-md-5 col-sm-9 col-10 mx-auto">      
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST" class=" bg-warning text-center mx-auto rounded my-2 " style="border:2px solid grey">
            <div class="form-group mx-2 ">
             <label for="email" class="text-dark font-weight-bold">E-mail:</label><br>
             <input type="email" class="form-control" id="email" name="email" placeholder="Enter E-mail" required>
            </div>
        
            <div class="form-group mx-2">
             <label for="password" class="text-dark font-weight-bold">Password:</label><br>
             <input type="password" class="form-control" id="email" name="password"placeholder="Enter Password"required>
            </div>
            
            <input type="submit" class="btn btn-primary my-2 " value="Login" name="submit">
            <p class="text-white">If You Don't Have Account! <a href="signup.php" class="btn btn-info btn-sm">Signup!</a></p>
          </form>
        </div>
        
      </div> 
   </div>


</body>
</html>
