<?php
session_start();


include 'connection.php';
include 'links.php';
?>
<?php
if(isset($_POST['login']))
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
     header("location: rvoice.php"); 
    
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
        <title>RaiseYourVoice</title>
        
        <style>
         .tbtn:hover{
           background-color:orange;
         }
         @media screen and (min-width: 600px) {
          #slideshow{
            height:65%;
          }
         }
         @media screen and (max-width: 600px) {
          #slideshow{
            height:45%;
          }
         }
          
        </style>
        
    </head>
    <body style="background-color:rgb(228, 190, 225);">
      
       <h1 class="conatiner-fluid text-white bg-info text-center py-2 bg-dark" >Raise Your Voice! 
       <i class="text-warning fa fa-bullhorn"></i></h1>
       <div class="container-fluid" style="text-align:center" >
          <a href="#logform" data-toggle="modal" class="tbtn btn btn-primary text-center col-md-4 col-sm-5 col-8  my-1 ml-auto font-weight-bold">
          Raise an Isuue </a>
          <a href="#logform" data-toggle="modal" class="tbtn btn btn-primary text-center col-md-4 col-sm-5 col-8  my-1 mx-auto font-weight-bold">
          Appeal For Funds</a>
       </div>
       <br>


      


        <?php
        
         $selectvoice="select * from issues order by datetime desc";
         $svoice=mysqli_query($con,$selectvoice);

         while($varray=mysqli_fetch_assoc($svoice))
         {
            if($varray['type']==='issue')
            { 
             ?>
            <div class="container-fluid">
              <div class="jumbotron col-11 mx-auto my-2 py-1 text-secondary" style="border: 2px solid white; border-radius:10px">
                  <h4> <span class="text-info text-center px-0 container-fluid badge-pill"><?php echo $varray['title']; ?></span> 
                </h4>

                <p class="my-1 container-fluid px-0" style="word-wrap:break-word;">
                <?php echo $varray['description']; ?> <br>
                <span class="float-right text-primary d-block"><?php echo $varray['datetime']; ?></span>
                </p>
                <div class="container-fluid px-0 my-1">
                
                    <a href="#logform" data-toggle="modal" class="btn p-0"><i class="fa fa-thumbs-up fa-2x text-primary "></i></a>
                    <span id="l<?php echo $varray['idi']; ?>">
                    <?php
                      $idi=$varray['idi'];
                      $getlikes="select * from ilikes where idi='$idi'";
                      $getl=mysqli_query($con,$getlikes);
                      $likes=mysqli_num_rows($getl);
                      echo $likes; ?>
                    </span>
                    <a href="#logform" data-toggle="modal" class="btn p-0"><i class="fa fa-thumbs-down fa-2x text-primary ml-3"></i></a>
                    <span id="dl<?php echo $varray['idi']; ?>">
                      <?php
                        $idi=$varray['idi'];
                        $getdlikes="select * from idislike where idi='$idi'";
                        $getdl=mysqli_query($con,$getdlikes);
                        $dlikes=mysqli_num_rows($getdl);
                        echo $dlikes; ?>
                    
                    </span>
                    <a href="#logform" data-toggle="modal" class="mx-2 my-1 p-0 text-primary font-weight-bold " 
                    style="font-size: 20px;">Comment</a>
                    <a href="#ic<?php echo $varray['idi']; ?>" class="mx-2 my-1 text-primary font-weight-bold" 
                    style="font-size: 20px;" data-toggle="collapse" >View Comments</a>
                </div>
               

                <div class="container-fluid collapse px-2 my-2 py-1" style="border:3px solid skyblue; border-radius:5px;"
                  id="ic<?php echo $varray['idi']; ?>">
                      <?php
                        $idi=$varray['idi'];
                        $selectvcom="select * from icomments where idi='$idi' order by datetime desc";
                        $svcom=mysqli_query($con,$selectvcom);
                        
                        $rows=mysqli_num_rows($svcom);
                        if($rows==0)
                        {
                          ?>
                          <div class="container-fluid text-info px-0 my-1" >
                            <h6>No comments Available Now. Be the first to comment!</h6>
                          </div>
                          <?php
                        }
                        else
                        {
                            while($vcarray=mysqli_fetch_assoc($svcom))
                          {
                            ?>
                            <div class="container-fluid px-0 my-1" style=""> 
                            <h6 class="text-info px-0"><?php echo $vcarray['username']; ?></h6>
                              <p class="container-fluid px-0 py-2" style="word-wrap:break-word;">
                              <?php echo $vcarray['comment']; ?><br>
                              <span class="float-right text-primary">~ <?php echo $vcarray['datetime']; ?></span>
                              </p>
                            </div> 
                          <?php
                          }
                        }
                        ?>

                </div>

             </div>

            </div>
           <?php
           }
           else{
           ?>
            <div class="container-fluid">
            <div class="jumbotron col-11 mx-auto my-2 py-1 text-secondary" style="border: 2px solid white; border-radius:10px;">
              <h4> <span class="text-info text-center px-0 container-fluid badge-pill"><?php echo $varray['title']; ?></span> 
            </h4>

            <p class="my-1 container-fluid px-0">
             <span class="text-dark ">Upi-Id: </span>
              <?php
                if(empty($varray['upi']))
                {?>
                 <span class="text-success"><?php echo "Not Available";?></span>
                <?php
                }
                else
                { ?>
                <span class="text-danger font-weight-bold"><?php echo $varray['upi']; ?></span>
                <?php
                }
              ?>
              <br>
            <?php echo $varray['description']; ?> <br>
            <span class="float-right text-primary d-block"><?php echo $varray['datetime']; ?></span>
            </p>
            <div class="container-fluid px-0 my-1">
                <a href="#logform" data-toggle="modal" class="btn p-0"><i class="fa fa-thumbs-up fa-2x text-primary "></i></a>
                  <span id="l<?php echo $varray['idi']; ?>">
                      <?php
                      $idi=$varray['idi'];
                      $getlikes="select * from ilikes where idi='$idi'";
                      $getl=mysqli_query($con,$getlikes);
                      $likes=mysqli_num_rows($getl);
                      echo $likes; ?>
                  </span>
                <a href="#logform" data-toggle="modal" class="btn p-0"><i class="fa fa-thumbs-down fa-2x text-primary ml-3"></i></a>
                  <span class="" id="dl<?php echo $varray['idi']; ?>">
                      <?php
                        $idi=$varray['idi'];
                        $getdlikes="select * from idislike where idi='$idi'";
                        $getdl=mysqli_query($con,$getdlikes);
                        $dlikes=mysqli_num_rows($getdl);
                        echo $dlikes; ?>
                    
                  </span>

                <a href="#logform" data-toggle="modal" class="mx-2 my-1 text-primary font-weight-bold" 
                style="font-size: 20px;" >Comment</a>
                <a href="#ic<?php echo $varray['idi']; ?>" class="mx-2 my-1 text-primary font-weight-bold" 
                    style="font-size: 20px;" data-toggle="collapse" >View Comments</a>
           </div>
           

            <div class="container-fluid collapse px-2 my-2 py-1" style="border:3px solid skyblue; border-radius:5px;"
              id="ic<?php echo $varray['idi']; ?>">
                  <?php
                    $idi=$varray['idi'];
                    $selectvcom="select * from icomments where idi='$idi' order by datetime desc";
                    $svcom=mysqli_query($con,$selectvcom);
                    
                    $rows=mysqli_num_rows($svcom);
                    if($rows==0)
                    {
                      ?>
                      <div class="container-fluid text-info px-0 my-1" >
                        <h6>No comments Available Now. Be the first to comment!</h6>
                      </div>
                      <?php
                    }
                    else
                    {
                        while($vcarray=mysqli_fetch_assoc($svcom))
                      {
                        ?>
                        <div class="container-fluid px-0 my-1" style=""> 
                        <h6 class="text-info px-0"><?php echo $vcarray['username']; ?></h6>
                          <p class="container-fluid px-0 py-2" style="word-wrap:break-word;">
                          <?php echo $vcarray['comment']; ?><br>
                          <span class="float-right text-primary">~ <?php echo $vcarray['datetime']; ?></span>
                          </p>
                        </div> 
                      <?php
                      }
                    }
                    ?>

            </div>

            </div>

        </div>
         <?php
           }

         }
        ?>

        <div class="row col-11 mx-auto">
          <div class="jumbotron  text-center col-xl-3 col-lg-4 col-md-5 col-sm-5 col-8 my-1" style="position: relative; z-index: 3;">
            <h3 class="container">Raise a Issue: </h3>
            <a href="#logform" data-toggle="modal" class="text-center"><img class="img-fluid" src="plus-circle (1).svg"></a>
          </div>
          <div class="jumbotron  text-center col-xl-3 col-lg-4 col-md-5 col-sm-5 col-8 my-1 ml-sm-3 " style="position: relative; z-index: 3;">
            <h3 class="container">Appeal for funds: </h3>
            <a href="#logform" data-toggle="modal" class="text-center"><img class="img-fluid" src="plus-circle (1).svg"></a>
          </div>
          
        </div>



        <div class="modal fade " id="logform">
        <div class="modal-dialog">
            <div class="modal-content bg-info">
              <div class="modal-header">
                <h4 class="modal-title ">Login!</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
              </div>
              <div class="modal-body">
                <form class="form" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
                    <div class="form-group">
                     <label for="email" class="text-dark font-weight-bold">E-mail:</label><br>
                     <input type="email" class="form-control" id="email" name="email" placeholder="Enter E-mail" required>
                    </div>
                    <div class="form-group">
                     <label for="password" class="text-dark font-weight-bold">Password:</label><br>
                     <input type="password" class="form-control" id="email" name="password"placeholder="Enter Password"required>
                    </div>
                    <input class="btn btn-success  btn-md d-block" type="submit" name="login" id="submit" value="Login!">
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
       </div>


      


      <br><br><br>

    </body>
</html>