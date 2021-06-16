<?php
session_start();
include 'connection.php';
include 'links.php';
if(!isset($_SESSION['email'])){
 header('location:login.php');
}
$email=$_SESSION['email'];
$outtime=date("Y-m-d H:i:s");
$updatesession="update session set outtime='$outtime' where email='$email'";
$usession=mysqli_query($con,$updatesession);

session_destroy();
header('location:login.php');

?>