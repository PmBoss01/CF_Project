<?php
ob_start();
include "db_conn.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polling Agent SignUp</title>
    <link rel="icon" href="images/Site logo.png" alt="rounded-pill" />
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous"
  />    
  <script src="https://kit.fontawesome.com/48e15f0c7c.js" crossorigin="anonymous"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        justify-content: center;
        align-items: center;
      }
    .signupform form{
      justify-content: center;
      align-items: center;
      border-radius: 20px;
      width: 100%;
      margin-top: 70px;
    }
    .btn{
      transition: box-shadow 0.3s ease;
    }
    .btn:hover{
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }
      
  </style>
</head>
<body class="bg-light">
<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@11"
    integrity="your-integrity-hash"
    crossorigin="anonymous"
  ></script>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
  ></script>

  <div class="container mb-5">
      <div class="row justify-content-center">
        <div class="col-lg">
          <div class="signupform">
          <form action="" method="post" class="p-3 shadow-lg bg-light">
          <h5><img src="images/logo.png" class="img-responsive" />Polling Agent Sign Up</h5>

            <div class="alert alert-success alert-dismissible text-center" role="alert">
              <strong>Please,</strong> Enter Valid ID or Info for Identity Verification and Registration
            </div>
            <p class="text-center mb-0"><i class="fa fa-id-card"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Search For Voter Information</label></p>  
            <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon1"><i class="fa fa-search" aria-hidden="true"></i></span>
            <input type="text" class="form-control text-center" placeholder="Search....." autocomplete="off" id="live_search" required>
            </div>

            <!-- jquery-->
           <div id="searchresult"></div>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

          <script type="text/javascript">
            $(document).ready(function(){
              $("#live_search").keyup(function(){
                var input = $(this).val();
                //alert(input);

                if(input != ""){
                  $.ajax({
                    url: "livesearch2.php",
                    method: "POST",
                    data:{input:input},

                    success:function(data){
                      $("#searchresult").html(data);
                      $("#searchresult").css("display","block");
                    }

                  });
                }else{
                  $("#searchresult").css("display","none");
                }
              });
            });
          </script>
    

            </form>
</div>
</div>
</div>
</body>
</html>

<?php
include "scripts.php";
?>
