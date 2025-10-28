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
    <title>Polling Agent LogIn</title>
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
          <h5><a href="Homepage.php"><img src="images/logo.png" class="img-responsive" /></a>POLLING AGENT PORTAL</h5>
              <!--PHP For Admin Login-->
<?php


  if (isset($_POST['submitpAgent'])) {
    $pid = $_POST['pid'];
    $ppass = $_POST['ppass'];


    function validate($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    $pid = validate($_POST['pid']);
    $ppass = validate($_POST['ppass']);

    if (empty($pid)) {
      $_SESSION['status'] = "Polling Agent ID Is Required!";
      $_SESSION['status_code'] = "info";
      header("Location: polling_agent.php");
      ob_end_flush();
      exit();
    } elseif (empty($ppass)) {
      $_SESSION['status'] = "Polling Agent Password Is Required!";
      $_SESSION['status_code'] = "info";
      header("Location: polling_agent.php");
      ob_end_flush();
      exit();
    } else {
      $sql = "SELECT * FROM polling_agent WHERE Agent_ID = '$pid' AND Agent_Password = '$ppass'";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['Agent_ID'] === $pid && $row['Agent_Password'] === $ppass) {
          $_SESSION['Agent_ID'] = $row['Agent_ID'];
          $_SESSION['Agent_Password'] = $row['Agent_Password'];
          $_SESSION['status'] = "Login Successful!";
          $_SESSION['status_code'] = "success";

          $online = "Online";
          $agentid = $_SESSION['Agent_ID'];
          $agentpass = $_SESSION['Agent_Password'];


          $stmt = $conn->prepare("UPDATE polling_agent SET Agent_Availability = ? WHERE Agent_ID = ? AND Agent_Password = ?");
          $stmt->bind_param("sss", $online, $agentid, $agentpass);
          $stmt->execute();
      
          ////////////////////////////////////

          if(!empty($_POST["rememberMePoll"])) {
            setcookie ("pid",$_POST["pid"],time()+ (24*60*60));
            setcookie ("ppass",$_POST["ppass"],time()+ (24*60*60));

          } else {
            setcookie("pid","");
            setcookie("ppass","");
          }

          header("Location: ./polling_agent Fold/pollingagent_Page.php");
          ob_end_flush();
          exit();
        } else {
          $_SESSION['status'] = "Invalid Credentials!";
          $_SESSION['status_code'] = "error";
          header("Location: polling_agent.php");
          exit();
          ob_end_flush();
        }
      } else {
        $_SESSION['status'] = "Invalid Credentials!";
        $_SESSION['status_code'] = "error";
        header("Location: polling_agent.php");
        exit();
        ob_end_flush();
      }
    }
  }

?>
            <div class="alert alert-success alert-dismissible text-center" role="alert">
              <strong>Please,</strong> Enter Your Credentials
            </div>
              <i class="fa-solid fa-user"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Polling Agent ID</label>
            <input type="text" class="form-control mb-4" name="pid" placeholder="Enter Your Polling Agent ID" value="<?php if(isset($_COOKIE["pid"])) { echo $_COOKIE["pid"]; } ?>" required>
            
            <i class="fa-solid fa-unlock"></i><label for="acode" class="form-label fw-bold fs-6 mb-2 m-2">Password</label>
            <input type="password" class="form-control mb-4" name="ppass" placeholder="Enter Your Password" value="<?php if(isset($_COOKIE["ppass"])) { echo $_COOKIE["ppass"]; } ?>" required>

            <div class="row">
            <div class="col-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="rememberMePoll" id="invalidCheck">
                <label for="invalidCheck" class="form-check-label">
                  Remember me?
                </label>
              </div>

            </div>
            <div class="col-5">
              <a href="forgetpasspolling.php"class="text-decoration-none text-primary">Forgot Password?</a>
            </div>
           </div>

          <div class="d-flex justify-content-between mt-4 mb-2">
            <p class="mt-1 text-muted">Do not have Account? <a href="polling_SignUp.php" class="text-decoration-none">Sign Up</a></p>
            <button type="submit" class="btn btn-primary justify-content-md-end shadow" name="submitpAgent">Sign In</button>
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
