<?php
session_start();
include "db_conn.php";

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />

    <title>Admin Dashbard | Upload Event</title>
    <link rel="icon" href="img/toastlogo.png" alt="rounded-pill" />


    <script
      src="https://kit.fontawesome.com/48e15f0c7c.js"
      crossorigin="anonymous"
    ></script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400&display=swap");

      body {
        font-family: "Poppins", sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      .sidebar {
        height: 100%;
        width: 62px;
        position: fixed;
        top: 0;
        left: 0;
        background: linear-gradient(to top, #ff0000, #0000ff);
        padding-top: 20px;
        color: #f8f9fa;
      }

      .sidebar a {
        padding: 22px 15px;
        text-decoration: none;
        color: #f8f9fa;
        display: block;
        transition: 0.3s;
      }
      .sidebar i {
        font-size: 25px;
      }

      .sidebar a:hover {
        background-color: #f8f9fa;
        color: #000;
      }

      .content {
        margin-left: 70px;
        padding: 20px;
        margin-top: -35px;
      }
      .custom-shape {
        width: 100%;
        height: 100px;
        background: linear-gradient(to right, #ff0000, #0000ff);
        border-radius: 0 0 20px 20px; /* Border radius applied to top-left and bottom-left corners */
        color: #f8f9fa;
        text-align: center;
        line-height: 100px;
      }
      .dashboard {
        border-radius: 20px;
        margin-top: 25px;
      }
      .active {
        background-color: #f8f9fa;
        width: 100%;
        border: 0;
        border-radius: 0;
      }
      .active i {
        color: #000;
      }

      .signupform form {
        justify-content: center;
        align-items: center;
        border-radius: 0 0 20px 20px;
        width: 100%;
      }
      .searchdb {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 70%;
        margin: 0 auto; /* Center the search box */
        position: relative;
        top: 10px;
      }

      .searchdb input {
        width: 100%;
        height: 55px;
        padding: 0 40px;
        font-size: 18px;
        outline: none;
        border: none;
        border-radius: 20px;
        background: #f5f5f5;
      }

      .searchdb label {
        position: absolute;
        right: 15px;
        top: 54%; /* Center vertically */
        transform: translateY(-50%);
        cursor: pointer;
      }

      .searchdb i {
        transition: color 0.3s; /* Add transition for smooth hover effect */
      }

      .searchdb:hover i {
        color: #0dcaf0; /* Change the color on hover */
      }
      .searchdb:hover input {
        border: 1px solid #0dcaf0;
      }
      .tabledb {
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
        width: 100%;
        margin-top: 50px;
      }
      .btn-light{
        background: linear-gradient(to left, #ff0000, #0000ff);
      }
      .btn-1 i{
        font-size: 40px;
      }
      .btn-light {
        transition: box-shadow 0.3s ease;
      }
      .btn-light:hover {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }
    </style>
  </head>
  <body class="bg-light">
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>

    <div class="sidebar">
      <div class="d-flex justify-content-center mt-4 mb-3">
      <p class="text-center" style="font-size: 10px">
          <img src="img/dash.png" alt="" style="width: 50px" />
        </p>      
      </div>

      <a href="Admin.php" class="mb-1"
        ><i class="fa fa-tachometer" aria-hidden="true"></i>
      </a>
      <a href="Event_Registration.php" class="mb-1"
        ><i class="fa-solid fa-user-pen"></i
      ></a>
      <a href="uploadList.php" class="active mb-1"
        ><i class="fa-solid fa-cloud-arrow-up"></i
      ></a>
      <a href="Eventsinfo.php" class="mb-1"
        ><i class="fa-solid fa-registered"></i
      ></a>
      <a href="qrCodeGenerator.php"><i class="fa-solid fa-qrcode"></i></a>
    </div>

    <div class="content">
      <div class="custom-shape shadow" style="font-size: 20px">
        <i class="fa-solid fa-user-shield fs-4"></i> Administator Dashboard
      </div>

      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="signupform">
            <form action="" method="post" class="p-3 shadow-lg bg-light">
            <h5><a href="#" class="text-dark"><i class="fa fa-file-text mx-1 mb-4" aria-hidden="true"></i></a>Event Upload</h5>
                
              <div class="searchdb mb-5">
                <input type="text" class="shadow" placeholder="Search here..." autocomplete="off" id="live_search"/>
                <label for="search"><i class="fas fa-search"></i></label>
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
                    url: "livesearch.php",
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
      
    </div>
  </body>
</html>

<?php
include "alert.php";
?>