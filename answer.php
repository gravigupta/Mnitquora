<?php
session_start();
   $qid=$_GET['qid'];
   $name=$_SESSION['name'];
   $errors=array();
   $con = mysqli_connect('localhost','root','','QUORA_db');
   if(!isset($_SESSION['name']))
   header('location: login.php');
   else{
   if(isset($_POST['ans_q'])){
       $answer=mysqli_real_escape_string($con,$_POST['answer']);
       if(empty($answer)){
           array_push($errors,"write valid answer");
          
       }
       else{
           $query="INSERT into answers(qid,name,answer) values('$qid','$name','$answer')";
           mysqli_query($con,$query);


       }
       header('location: ask.php');
    }
   }
   










   ?>
