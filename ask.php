<?php
session_start();
$errors =array();
//if(isset($_SESSION['name'])){
  
    include 'connection.php';

    if(isset($_POST['ask_q'])){
      
    $question=mysqli_real_escape_string($con,$_POST['question']);
     if(empty($question)){
         array_push($errors,"Please write valid question");
        header('location: ask.php');
     }
  else{
        $name=$_SESSION['username'];
       

  
        $query="INSERT into questions(name,question) values('$name','$question')";

          mysqli_query($con,$query);
        echo "ok";
        header('location: ask.php');
        
}
      }
  //  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
   <link href="ok.css" rel="stylesheet">
   <script href="ask_ques.js"></script>
    <title>Discussion</title>

</head>
<body style="background-color:#85B3D1FF">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
    <ul class="navbar-nav">
    <li class="nav-item "><a href="home.php" class="nav-link">Home</a></li>
    </ul>
    <button onclick="myFunction()" class="btn btn-primary btn-sm">ASk-Question</button>
   
    <span class="navbar-brand ml-auto">Discussion Forum</span>
  
</nav>

  <br>
  <div id="hide" style=" display: none;background-color:#2460A7FF; color: #B3C7D6FF;box-shadow: 5px 5px #B3C7D6FF;" class="container">
  
  <form   action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>"  class="form-group pt-2 pb-1" method="post">
  <textarea class="form-control " rows="5" placeholder="write question here" name="question"></textarea>
  
  <button class="btn btn-primary my-1 " name="ask_q" type="submit">submit</button>
</form>

</div>
<br>
<?php 
$query = "SELECT * from questions order by time desc";
$result=mysqli_query($con,$query);
while($row = mysqli_fetch_array($result)){
     $question=$row['question'];
     $qid=$row['qid'];
     ?>

<?php
    $name=$row['name'];?>
     <div id="ansdiv" style="background-color:#2460A7FF; color: #B3C7D6FF; box-shadow: 5px 5px #B3C7D6FF;" class="container">
     <span>QUESTION:</span>
     <span style="float:right;"> <?php echo "by : ". $name;?>
    </span>

    <p style="margin-left: 8%;"><?php echo     $question ?>
    </p>
    

    <form action="answer.php?qid=<?php echo $qid?>" class="form-group " method="post">
    <textarea class="form-control my-1" name="answer" placeholder="write answer here" required></textarea>
    
    <button class="btn btn-primary btn-sm " style="float: right;" type="submit" name="ans_q">submit</button>
    
     </form>
     <button class="btn btn-primary btn-sm my-1" data-toggle="collapse" data-target="#id<?php echo $qid; ?>">see answer</button>
     <br>
    
        <?php
        $query="SELECT * from answers where qid=$qid order by time desc";
        $results=mysqli_query($con,$query);
        ?>
        <div id="id<?php echo $qid; ?>" class="collapse my-1 pb-1"  >



        <?php
        while($row2= mysqli_fetch_array($results)){
          $answer=$row2['answer'];?>
          <div class="py-1 pl-4 my-1 container"style=" border: solid ;border-radius: 10px 10px 10px 10px;     padding-left: 10px; overflow: visible; display: block;
width: auto;
height: auto;">

    <span>Answer:</span>
    <span style="float: right;"><?php echo " at " . $row2['time'];?></span>

    <p style="margin-left: 8%; word-wrap: break-word;"><?php
         echo  $answer ?>
         </p>

         <p style="text-align-last: right;">
         <?php echo " by ". $row2['name']?>
         </p>
         
     </div>
     
   <?php
        }
        ?>
     </div>
     </div>
     <br>
     <?php
}
?>

<script>
function myFunction() {
  var x = document.getElementById("hide");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
function my_fun(z){
  const y= document.getElementById("z");
  if (y.style.display === "none") {
    y.style.display = "block";
  } else {
    y.style.display = "none";
  }
}
</script>



<script type="javascript" src="ask_ques.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>