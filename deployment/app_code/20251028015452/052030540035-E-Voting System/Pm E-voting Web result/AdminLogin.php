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
    <title>EC LogIn</title>
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

  <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="signupform">
          <form action="" method="post" class="p-3 shadow-lg bg-light">
          <h5><a href="Homepage.php"><img src="images/logo.png" class="img-responsive" /></a>EC LOGIN PORTAL</h5>
              <!--PHP For Admin Login-->
<?php

  if (isset($_POST['submitAdmin'])) {
    $aid = $_POST['aid'];
    $pass = $_POST['pass'];

    function validate($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    $aid = validate($_POST['aid']);
    $pass = validate($_POST['pass']);

    if (empty($aid)) {
      $_SESSION['status'] = "EC ID Is Required!";
      $_SESSION['status_code'] = "info";
      header("Location: AdminLogin.php");
      ob_end_flush();
      exit();
    } elseif (empty($pass)) {
      $_SESSION['status'] = "Password Is Required!";
      $_SESSION['status_code'] = "info";
      header("Location: AdminLogin.php");
      ob_end_flush();
      exit();
    } else {
      $sql = "SELECT * FROM admindetails WHERE Admin_ID = '$aid' AND Admin_Password = '$pass'";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['Admin_ID'] === $aid && $row['Admin_Password'] === $pass) {
          $_SESSION['Admin_ID'] = $row['Admin_ID'];
          $_SESSION['Admin_Password'] = $row['Admin_Password'];
          $_SESSION['status'] = "Login Successful!";
          $_SESSION['status_code'] = "success";

          $online = "Online";
          $ECid = $_SESSION['Admin_ID'];
          $ECpass = $_SESSION['Admin_Password'];


          $stmt = $conn->prepare("UPDATE admindetails SET Ec_Availability = ? WHERE Admin_ID = ? AND Admin_Password = ?");
          $stmt->bind_param("sss", $online, $ECid, $ECpass);
          $stmt->execute();
      

          //Insert Activity Logs for Admin
          $adminid = $_SESSION['Admin_ID'];
          $activity_log = "Login Successful";
          $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
          $currentDateTime = date('Y-m-d H:i:s');

          $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
          $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
          if ($stmt->execute()) {
            echo '';
          } else {
            echo '';
          }
      
          if(!empty($_POST["rememberMeAdm"])) {
            setcookie ("aid",$_POST["aid"],time()+ (24*60*60));
            setcookie ("pass",$_POST["pass"],time()+ (24*60*60));

          } else {
            setcookie("aid","");
            setcookie("pass","");
          }

         
          header("Location: Admin Dashboard.php");
          ob_end_flush();
          exit();
        } else {
          $_SESSION['status'] = "Invalid Credentials!";
          $_SESSION['status_code'] = "error";
          header("Location: AdminLogin.php");
          exit();
          ob_end_flush();
        }
      } else {
        $_SESSION['status'] = "Invalid Credentials!";
        $_SESSION['status_code'] = "error";
        header("Location: AdminLogin.php");
        exit();
        ob_end_flush();
      }
    }
  }

?>
            <div class="alert alert-success alert-dismissible text-center" role="alert">
              <strong>Please,</strong> Enter Your Credentials
            </div>
              <i class="fa-solid fa-user"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">EC ID</label>
            <input type="text" class="form-control mb-4" name="aid" placeholder="Enter Your EC ID" value="<?php if(isset($_COOKIE["aid"])) { echo $_COOKIE["aid"]; } ?>" required>
            
            <i class="fa-solid fa-unlock"></i><label for="acode" class="form-label fw-bold fs-6 mb-2 m-2">Password</label>
            <input type="password" class="form-control mb-4" name="pass" placeholder="Enter Your Password" value="<?php if(isset($_COOKIE["pass"])) { echo $_COOKIE["pass"]; } ?>" required>

            <div class="row">
            <div class="col-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="rememberMeAdm" id="invalidCheck">
                <label for="invalidCheck" class="form-check-label">
                  Remember me?
                </label>
              </div>

            </div>
            <div class="col-5">
              <a href="forgetpass.php"class="text-decoration-none text-primary">Forgot Password?</a>
            </div>
           </div>

          <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3 mb-2">
            <button type="submit" class="btn btn-primary justify-content-md-end shadow" name="submitAdmin">Sign In</button>
          </div>
            </form>
</div>
</div>
</div>
</body>
</html>

<?php
include "scripts.php";
?>
