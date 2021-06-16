<?php

session_start();
include 'connection.php';
if(empty($_SESSION['username'])){
    header('location: login.php');
}
else{
    $name=$_SESSION['username'];
   
    if(isset($_POST['add_post'])){
       //$title=mysqli_real_escape_string($con,$_POST['title']);

       $des=mysqli_real_escape_string($con,$_POST['des']);
        $file=$_FILES['file'];

       $fileName= $_FILES['file']['name'];
       
       $fileTmpName= $_FILES['file']['tmp_name'];

       $fileExt= explode('.',$fileName);
       $fileActualExt = strtolower(end($fileExt));

       $allowed= array('jpg','jpeg','png');
          
       if(in_array( $fileActualExt, $allowed)){
            if($_FILES['file']['error'] === 0){
                $filenameNew= uniqid('',true).".".$fileActualExt;
                $fileDestination = 'home_pic/'.$filenameNew;

                move_uploaded_file($fileTmpName,
                $fileDestination);
                $query="INSERT into post(name,file,description) values('$name','$filenameNew','$des')";
               $result= mysqli_query($con,$query);
                if(!empty($result))
                header('location: home.php');
                
            }
       }
       else {
           
       }

    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
   <style>
   @media only screen and (max-width: 992px) {
  /* For mobile phones: */
   #postimg{
       display: none;
   }
   
  
}
   </style>
    <title>Add post</title>
</head>
<body>
    
    <div class="container">
    <div class="row mt-2">
    <div class=" col-lg-6 col-11 pt-4 mx-auto" style="background-color:#8fc2c0; color:#00203FFF; ">
     <form class="form-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" enctype="multipart/form-data">
     
     <label  for="file" >choose your file:</label>
     <input type="file" name="file" class="form-control" id="file" required>
     
     <label for="description" class="mt-2">description</label>
     <textarea onkeyup="fun()" onkeydown="fun()" id="text" type="text" name="des" placeholder="write something " class="form-control" rows="7" id="description" required maxlength="255"></textarea>

      <p><span id="show"> 0 </span>/255</p>
    

     <button  type="submit" name="add_post" class="btn btn-primary mt-2 pl-3">Post
     </button>
</div>
<div class="col-lg-6 ">
<img class="img-fluid" id="postimg" src="photos/postgif.gif" alt="gif">
</div>
</div>
</div>
      









<script>
function fun(){

const length=document.getElementById('text').value.length;
document.getElementById('show').innerHTML=length;
}
</script>





     
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>