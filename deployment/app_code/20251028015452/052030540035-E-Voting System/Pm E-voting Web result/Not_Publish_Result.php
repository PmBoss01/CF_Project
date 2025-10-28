<?php
include "db_conn.php";
session_start();

if (isset($_SESSION['Student_ID']) && isset($_SESSION['Serial_Code'])){
  $last_activity = isset($_SESSION['last_activity']) ? $_SESSION['last_activity'] : time();
  $timeout = 900; // 15 minutes in seconds

  // Check if user has been inactive for more than the timeout period
  if (time() - $last_activity > $timeout) {
      // Destroy the session and redirect to the login page
      session_unset();
      session_destroy();
      header("Location: StudentLogin.php"); // Replace "login.php" with your actual login page URL
      exit;
  }

  // Update the last activity time
  $_SESSION['last_activity'] = time();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    
    <title>View Aspirant Results </title>
    <link rel="icon" href="images/Site logo.png" alt="rounded-pill" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />

    <script
      src="https://kit.fontawesome.com/48e15f0c7c.js"
      crossorigin="anonymous"
    ></script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400&display=swap");
      * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
      }
      .topbardb {
        position: fixed;
        background: #fff;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.08);
        width: 100%;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 2fr 10fr 0.4fr 1fr;
        align-items: center;
        z-index: 1;
        height: 60px;
      }
      .topbar {
        position: fixed;
        width: 100%;
        align-items: center;
        
      }
      .copyright {
        width: 100%;
        text-align: center;
        padding: 8px 0;
        background: #f5f5f5;
        font-weight: 100;
        margin-top: 100px;
        height: 45px;
      }
      .copyright p {
        color: black;
        font-weight: 400;
        font-family: "Poppins", sans-serif;
      }
      .copyright i {
        color: #ff004f;
      }
      .btn.btn2{
        background: #ff004f;
        color: #fff;
        font-size: 16px;
        border-radius: 10px;
      }
      
      .btn.btn2:hover{
        color: black;
      }
      .toolbar a{
        background: #f5f5f5;
        margin-top: -70px;
        color: black;
        border-radius: 10px;
      }
      .toolbar a:hover{
        background: #ff004f;
        color: #fff;
      }
      /*Notice */
        .container {
        margin-top: 50px;
        margin-bottom: 50px;
        }

        .noticeboard {
        padding: 20px;
        background-color: #f2f2f2;
        border-radius: 8px;
        }
        .noticeboard h3{
          color: #ff004f;
          animation: mover 1s infinite alternate;
        }
        @keyframes mover {
        0% {
          transform: translateX(0);
        }

        100% {
          transform: translateX(-100px);
        }
      }
        .tp{
            font-size: 17px;
            
        }

        .text {
        font-size: 20px;
        color: #333;
        }

        .text-center {
        text-align: center;
        }

        .mt-4 {
        margin-top: 16px;
        }

        .mb-5 {
        margin-bottom: 32px;
        }

        .fa-info-circle {
        font-size: 24px;
        color: #333;
        vertical-align: middle;
        margin-right: 8px;
        }

        .shadow {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        span{
            font-weight: 400;
            font-size: 17px;
            color: #ff004f;
            margin-left: 40px;
        
        }
        .mt-5 i{
          font-weight: bold;
          font-size: 20px;
          color: #ff004f;
          margin-right: -20px;
        }
        #running-time{
            font-weight: bold;
            font-size: 20px;
            color: #ff004f;
        }
        .align-left {
          text-align: center;
        }
        .outsoon{
          color: #ff004f;

        }

      

      
    </style>
  </head>
  <body class="bg-light">
    
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>

    <div class="toolbar shadow bg-light">
      <div class="d-flex justify-content-center align-items-center">
        <img src="images/logo.png" class="img-responsive mt-3" />
        <h5 class="mt-4">Pm E-Voting System</h5>
        </div>
        <p class="text-end">
          <a href="" class= "btn text-decoration-none mx-3 shadow" data-bs-toggle="modal" data-bs-target="#logout"><i class="fa fa-user mx-1"></i>LogOut</a>
        </p>
       
    </div>

    <div>
      <h4 class="text-center mt-4">Certified Candidate Results</h4>
    </div>

    <!---------->
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="noticeboard shadow">
            <?php
            include "db_conn.php";
            include "scripts.php";
            
            $query = "SELECT * FROM election_details";
            $query_run = mysqli_query($conn, $query);

            if (mysqli_num_rows($query_run) > 0) {
              while ($row = mysqli_fetch_array($query_run)) {
          ?>
                <form>
                    <h3 class="text text-center mt-0 mb-4"><i class="fa fa-info-circle mx-2 mb-1" aria-hidden="true" style="color: #ff004f;";></i>Notice !!!</h3>
                    <p class="mb-4 text-center fs-5">ELECTION Results will be Uploaded<b class="outsoon"> Soon!</b> <br>Login Again to View Results.</p>
                    <p class="tp align-left"><b>Election ID: <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['Election_ID'] ?></b></span> </p>
                    <p class="tp align-left"><b>Election Name: <span><?php echo $row['Election_Name'] ?></span></b> </p>
                    <p class="tp align-left"><b>Starting Date: <span>&nbsp;&nbsp;<?php echo $row['Starting_Date'] ?></span></b> </p>
                    <p class="tp align-left"><b>Ending Date: <span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['Ending_Date'] ?></b></span> </p>
                    <p class="tp align-left"><b>Starting Time:<span>&nbsp;&nbsp;&nbsp;<?php echo $row['Starting_Time'] ?></span></b> </p>
                    <p class="tp align-left"><b>Ending Time:<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['Ending_Time'] ?></span></b> </p>
                    <p class="tp align-left"><b>Election Status: <span><?php echo $row['Election_Status'] ?></span></b> </p>
                    <p class="text-center mt-5"><i class="fa fa-clock-o" aria-hidden="true"></i><span id="running-time"><?php echo date('H:i:s'); ?></span></p>
                    
                </form>
                <?php
              }
                }else{
                  echo "";
                }  

                 ?>
            </div>
        </div>
    </div>
</div>

    
    <div class="text-center">
      <a href="Homepage.php" class="btn btn2 shadow"><i class="fa fa-home mx-1"></i>Go Home</a>
    </div>

    <div class="copyright">
      <p>
        Copyright © 2023 Pm E-Voting System. Made with <i class="fas fa-heart"></i>
        by Pm Tech Solutions
      </p>
    </div>
  </body>
</html>

 <!-- Create a logout Module-->


 <div>
      <div
      class="modal fade"
      id="logout"
      tabindex="-1"
      aria-labelledby="ModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog shadow">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel"><i class="fas fa-sign-out mx-2"></i>LogOut</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body mt-1">
          <p class="text-center text-danger fs-3"><i class="fas fa-sign-out"></i></p>
          <p class="text-center">Are you sure you want to <b class="text-danger">LogOut</b> ?</p>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <a class="btn btn-danger" href="stulogout.php" >LogOut</a>
          </div>
        </div>
      </div>
    </div>

    </div>

    <!--Running Time-->
    <?php
  // Set the timezone
  date_default_timezone_set('Africa/Accra'); // Replace 'Your_Timezone' with your desired timezone

  // Update the running time every second
  echo '<script>
    setInterval(function() {
      var currentTime = new Date();
      var hours = currentTime.getHours();
      var minutes = currentTime.getMinutes();
      var seconds = currentTime.getSeconds();
      var formattedTime = hours.toString().padStart(2, "0") + ":" + minutes.toString().padStart(2, "0") + ":" + seconds.toString().padStart(2, "0");
      document.getElementById("running-time").textContent = formattedTime;
    }, 1000);
  </script>';
  ?>

    </body>
</html>

<?php
}else{
    header("Location: Homepage.php");
    exit();
}
?>

<?php
  include "scripts.php";
?>
