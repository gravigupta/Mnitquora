<?php
session_start();

include 'connection.php';
include 'links.php';

$username=$_SESSION['username'];
$email=$_SESSION['email'];

if(!isset($username))
{
  header('location:login.php');
}

$_SESSION['otheruser']=$_GET['username'];
$_SESSION['otheremail']=$_GET['email'];
$otheruser=$_SESSION['otheruser'];
$otheremail=$_SESSION['otheremail'];
?>





<html>
    <head>
        <title>Chat page</title>
        <style>
         #chats::-webkit-scrollbar {
              display: none;
          }
         #chats{
            -ms-overflow-style: none;  
            scrollbar-width: none;  
          }

         

         
        </style>
        <script>
          function fun(){
            const chats=document.getElementById("chats");
            chats.scrollTop = chats.scrollHeight;
          }


          function mlength(){
            
            var message=document.getElementById("msg").value;
            if(message==="")
             document.getElementById("send").style.display="none";
            else
            document.getElementById("send").style.display="inline-block";
           
          }

          function myfun(){ 
           const msg=document.getElementById("msg").value;
            var xhttp; 
            xhttp=new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                 document.getElementById("msg").value="";
                 document.getElementById("send").style.display="none";
              }
            };
            xhttp.open("GET", "msg.php?msg="+msg, true);
            xhttp.send();

          }
          
          setInterval(function realtime(){           
                var xhttp; 
                xhttp=new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("chats").innerHTML =this.responseText;
                  }
                };
                xhttp.open("GET", "msg.php", true);
                xhttp.send();
              },100);

          setInterval(function online(){           
            var xhttp; 
                xhttp=new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("online").innerHTML =this.responseText;
                  }
                };
                xhttp.open("GET", "msg.php?online=1", true);
                xhttp.send();
              },100);
                          
         
            

        </script>
    </head>
    <body onload="fun()">
        <div class="container-fluid bg-dark pl-3 py-1">
        
             <img src="usericon.png" class="rounded" alt="reciever" style="height:10%; width:auto;margin-left: 3%;">
             <h3 class="text-white" style="display: inline-block;margin-left: 1%;"><?php echo $otheruser; ?>
             </h3>
             <span id="online">
               <?php
                  $checksession="select *from session where email='$otheremail'";
                  $csession=mysqli_query($con,$checksession);
                  $session=mysqli_fetch_assoc($csession);
                  if($session['intime']>$session['outtime'])
                  {?>
                    <span class="text-primary mx-1">(online)</span>
                    <?php
                  }
                  else
                  {
                    ?>
                     <span class="text-warning mx-1">(Last seen: <?php echo $session['outtime'];?>)</span>
                     <?php
                  }
                   
               ?>
              
             </span>
         </div>

        <div id="chats" style="overflow-y:scroll; height:74%;">
          <?php
            $selectmsg="select * from chats where (semail='$email' OR semail='$otheremail') AND (remail='$email' OR remail='$otheremail')";
            $smsg=mysqli_query($con,$selectmsg);
            while($marray=mysqli_fetch_assoc($smsg))
            {
              if($marray['semail']==$otheremail)
              {
              ?>
                <div class=" text-white bg-warning my-1 pl-1 py-1" 
                style="display:block;max-width:60%;margin-left:4px;border:3px solid black;border-radius:10px 10px 10px 10px;">
                  <img src="usericon.png" class="ml-1 rounded mr-1" style="float:left; height:5%;width:auto;"/>
                  <p class="text-dark text-left" style="word-wrap:break-word;"><?php echo $marray['datetime']; ?></p>
                  <p class="text-dark text-left" style="word-wrap:break-word;"><?php echo $marray['msg']; ?></p>
                </div><br>
              <?php
              }
              else
              {
              ?>
                <div class="text-white bg-info my-1 pr-1 py-1" 
                style="display:block; max-width:60%;margin-left:40%;margin-right:4px;border:3px solid black;border-radius:10px 10px 10px 10px;">
                  <img src="usericon.png" class="mr-1 rounded ml-1" style="float:right;height:5%;width:auto;"/>
                  <p class="text-dark text-left" style="word-wrap:break-word;"><?php echo $marray['datetime']; ?></p>
                  <p class="text-dark text-right" style="word-wrap:break-word;"><?php echo $marray['msg']; ?></p>
                </div><br>
              <?php
              }
              
            }
          ?>

        </div>
    
        <div class="container-fluid" style="position: fixed;bottom: 0;height:10%;margin-bottom:2%;padding-bottom:1%">
        <div class="form">
            <textarea id="msg" class="form-control col-8 my-1" row="2" placeholder="Type your msg!" 
            onkeyup="mlength()" onkeydown="mlength()" 
            style="border:3px solid grey;border-radius:10px 10px 10px 10px ;display:inline-block;"></textarea>
            <button id="send" class="btn btn-primary btn-sm mb-5" style="display:none;" onclick="myfun()" >Send</button>
            
        </div>
        </div>       
            
      
    </body>
</html>

