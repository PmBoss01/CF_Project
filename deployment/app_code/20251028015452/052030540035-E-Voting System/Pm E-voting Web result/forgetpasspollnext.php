<?php
ob_start();
include "db_conn.php";
session_start();

if (isset($_SESSION['Agent_ID'])){

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password | Polling Agent</title>
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
      }
    .signupform form{
      justify-content: center;
      align-items: center;
      border-radius: 20px;
      width: 100%;
      margin-top: 100px;
    }
    
      
  </style>
  
</head>
<body class="bg-light">
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
  ></script>
  
  <script>
        
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            var intervalId; // Variable to store the interval ID

            intervalId = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(intervalId);
                    display.textContent = "00:00";
                    disableButton(); // Disable button after timer ends
                }
            }, 1000);
        }

        window.onload = function () {
            var fiveMinutes = 300; // Timer duration in seconds
            var display = document.getElementById('timer');
            startTimer(fiveMinutes, display);
        };
    </script>

<script>
        setTimeout(function() {
            var button = document.getElementById('myBtn');
            button.disabled = true;
        }, 300000); // 5 minutes timer
    </script>



  <div class="container mt-4">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="signupform">
            <form action="" method="post" class="p-3 shadow-lg bg-light mt-5">

            <?php
    
            if (isset($_POST['verifyaspcode'])) {
              $number1 = $_POST['number1'];
              $number2 = $_POST['number2'];
              $number3 = $_POST['number3'];
              $number4 = $_POST['number4'];

              //$fsid = $_SESSION['fsid'];
              $concatenatedNumbers = $number1 . $number2 . $number3 . $number4;

              $sql = "SELECT * FROM polling_agent WHERE Otp_Code ='$concatenatedNumbers'";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                if ($row['Otp_Code'] === $concatenatedNumbers){
                  $aid = $row['Agent_ID'];
                  $pass = $row['Agent_Password'];
                  $_SESSION['status'] = "Your Account Recovery was successful. ". " Your Polling Agent ID: ". $aid. " and Password: ". $pass. " Your can Copy your Password for LogIn";
                  $_SESSION['status_code'] = "success";

                  //Insert Activity Logs for Admin
                  $adminid = $_SESSION['Agent_ID'];
                  $activity_log = "Account Recovery";
                  $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
                  $currentDateTime = date('Y-m-d H:i:s');

                  $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
                  $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
                  if ($stmt->execute()) {
                    echo 'Data inserted successfully.';
                  } else {
                    echo 'Error inserting data: ' . $stmt->error;
                  }
      

                  ////////////////////////////////////

                  header("Location: polling_agent.php");
                  ob_end_flush();
                  exit();

                }else{
                  $_SESSION['status'] = "Your OPT Code: ". $concatenatedNumbers . " is incorrect. Try again or Resend Code if you didn't recieve any SMS";
                  $_SESSION['status_code'] = "warning";
                  header("Location: forgetpasspollnext.php");
                  ob_end_flush();
                  exit();

                }

            }else{
              $_SESSION['status'] = "Your OPT Code: ". $concatenatedNumbers . " is incorrect. Try again or Resend Code if you didn't recieve any SMS";
              $_SESSION['status_code'] = "warning";
              header("Location: forgetpasspollnext.php");
              ob_end_flush();
              exit();
          }
        }

            ?>

            
              <div
                class="container d-flex justify-content-center align-items-center mb-4"
              >
                <h6 class="display-6 fs-4 fw-normal">
                <i class="fa-solid fa-unlock mx-2"></i>OTP Code
                </h6>
              </div>

            <div class="alert alert-success mb-5" role="alert">
            <strong>Please, </strong>Enter A valid 4-digit OTP code that have been sent via your Phonenumber.
            </div>

              <div class="container">
                <div class="row">
                <div class="col-sm-3">
                <input
                  type="text"
                  class="form-control text-center mb-4 shadow-sm fs-5 fw-bold"
                  id="validationDefault03"
                  name = "number1"
                  required
                  placeholder="0"
                  autocomplete="off"
                  oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                  maxlength="1"
                  onkeyup="moveToNextField(this, 'number2')"
                  
                />
                </div>
                
                
                <div class="col-sm-3">
                <input
                  type="text"
                  class="form-control text-center mb-4 shadow-sm fs-5 fw-bold"
                  id="validationDefault03"
                  name = "number2"
                  placeholder="0"
                  autocomplete="off"
                  oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                  maxlength="1"
                  onkeyup="moveToNextField(this, 'number3')"
                />
                </div>

                <div class="col-sm-3">
                <input
                  type="num"
                  class="form-control text-center mb-4 shadow-sm fs-5 fw-bold"
                  id="validationDefault03"
                  name = "number3"
                  placeholder="0"
                  autocomplete="off"
                  oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                  maxlength="1"
                  onkeyup="moveToNextField(this, 'number4')"
                />
                </div>

                <div class="col-sm-3">
                <input
                  type="num"
                  class="form-control text-center mb-4 shadow-sm fs-5 fw-bold"
                  id="validationDefault03"
                  name = "number4"
                  placeholder="0"
                  autocomplete="off"
                  oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                  maxlength="1"
                  onkeyup="moveToNextField(this, 'number5')"
                />
                </div>
                
                

                <div
                  class="d-grid mt-3"
                >
                  <button type="submit" name="verifyaspcode" id="myBtn" class="btn btn-primary shadow-sm mb-3 mt-3">
                    Verify Code 
                  </button>
                  <p class="text-center mb-2"><a href="forgetpass.php" class="text-decoration-none">Resend Code</a></p>
                  <p class="mx-2 text-center">Time Remaining: <span id="timer" class="text-danger"></span></p>
                  
                </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      function moveToNextField(input, nextField) {
        if (input.value.length === input.maxLength) {
          document.getElementsByName(nextField)[0].focus();
        }
      }
    </script>
    
</body>
</html>
<?php
}else{
    header("Location: forgetpasspolling.php");
    exit();
}
?>

<?php
include "scripts.php";
?>

