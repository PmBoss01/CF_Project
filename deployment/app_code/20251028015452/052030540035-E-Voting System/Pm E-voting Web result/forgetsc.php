<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Serial Code</title>
    <link rel="icon" href="images/Site logo.png" alt="rounded-pill" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
      margin-top: 80px;
    }
    img{
      width: 30px;
    }
      
  </style>
</head>
<body class="bg-light">
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
  ></script>

  <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="signupform">
            <form action= "" method="post" class="p-3 shadow-lg bg-light">
              <!--PHP Code for SMS Sending-->
              
              <?php
              ob_start();
              session_start();
              include "db_conn.php";
              include "scripts.php";

              if (isset($_POST['forgotsubmit'])) {
                $fsid = $_POST['fsid'];
                $fphone = $_POST['fphone'];

                $_SESSION['fsid'] = $fsid;

                function validate($data){
                  $data = trim($data);
                  $data = stripslashes($data);
                  $data = htmlspecialchars($data);
                  return $data;
                }
              
                $fsid = validate($_POST['fsid']);
                $fphone = validate($_POST['fphone']);
            

                if (empty($fsid)) {
                  $_SESSION['status'] = "Voter ID is Required!";
                  $_SESSION['status_code'] = "info";
                  header("Location: forgetsc.php");
                  ob_end_flush();
                  exit();

                  }elseif (empty($fphone)) {
                    $_SESSION['status'] = "Phonenumber is Required!";
                    $_SESSION['status_code'] = "info";
                    header("Location: forgetsc.php");
                    ob_end_flush();
                    exit();

                  }else{
                  
                    $sql = "SELECT * FROM votersdetails WHERE Student_ID = '$fsid'";
                    $result = mysqli_query($conn, $sql);
                    
                
                    if (mysqli_num_rows($result) === 1) {
                      $row = mysqli_fetch_assoc($result);
                      if ($row['Student_ID'] === $fsid){
                        $_SESSION['Student_ID'] = $row['Student_ID'];
                        $a = rand(1000, 9999);

                        $query = "UPDATE votersdetails SET Otp_Code = $a WHERE Student_ID = '$fsid'";
                        $query_run = mysqli_query($conn, $query);

                        // SMS Message
                        
                        $url = 'https://devapi.fayasms.com/messages';
                        $headers = array('fayasms-developer: 37151436.9JRjLAUCYuYBjarEtNURWabNdjnSb9tm');
                        $data = array(
                          'sender' => 'PmTecH',
                          'message' => 'Your OTP Code for account verification is '.$a,
                          'recipients' => array(
                            $fphone
                        )
                      );

                      $curl = curl_init($url);
                      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

                      $response = curl_exec($curl);
                      curl_close($curl);
                      if($response){

                      $_SESSION['status'] = "Details Verified Successfully!";
                      $_SESSION['status_code'] = "success";

                      header("Location: forgetscnext.php");
                      ob_end_flush();
                      exit();
                    }else{
                      $_SESSION['status'] = "SMS Not delivered.";
                      $_SESSION['status_code'] = "error";

                      header("Location: forgetsc.php");
                      ob_end_flush();
                    }

                  }else{
                        $_SESSION['status'] = "Invalid Credentials!";
                        $_SESSION['status_code'] = "error";
                        header("Location: forgetsc.php");
                        ob_end_flush();
                        exit();
                      }
                    }else{
                      $_SESSION['status'] = "Invalid Credentials";
                      $_SESSION['status_code'] = "error";
                      header("Location: forgetsc.php");
                      ob_end_flush();
                      exit();
                    }
                  }
                }
                ?>
              
              <div
                class="container d-flex justify-content-center align-items-center mb-4"
              >
                <h6 class="display-6 fs-4 mt-2 mb-3 fw-normal">
                <i class="fa-solid fa-key mx-2"></i>Forgot Serial Code
                </h6>
              </div>

            <div class="alert alert-success text-center" role="alert">
              <strong>Please,</strong> Enter Valid Credentials
            </div>

              <div class="container">
                <p>
                <input
                  type="text"
                  class="form-control text-center mb-4"
                  id="validationDefault03"
                  name = "fsid"
                  oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                  required
                  placeholder="Enter Your Voter ID"
                  maxLength="12"
                  autocomplete="off"
                />
                </p>
                
                <p class="text-center"><img src="images/ghana-flag.svg" alt="" /><label for="sid" class="form-label fw-bold fs-6 mx-1 mb-0" name="phone">PhoneNumber</label></p>
                <input
                  type="phonenumber"
                  class="form-control text-center mb-4 mt-0"
                  id="validationDefault03"
                  name = "fphone"
                  oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                  required
                  placeholder="024XXXXXXX"
                  maxLength="10"
                  autocomplete="off"
                />

                <div
                  class="d-grid"
                >
                  <button type="submit" name="forgotsubmit" class="btn btn-primary shadow-sm mb-3 mt-3">
                    Continue 
                  </button>
                </div>
              </div>

              
            </form>
          </div>
        </div>
      </div>
    </div>
</body>
</html>