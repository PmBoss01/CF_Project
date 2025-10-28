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
    <title>Voter | View Results</title>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
          <h5><a href="Homepage.php"><img src="images/logo.png" class="img-responsive" /></a>VOTER LOGIN (VIEW RESULTS)</h5>


<!--PHP For Student Login-->
<?php

if (isset($_POST['stulogin'])) {
    $sid = $_POST['sid'];
    $scode = $_POST['scode'];

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $sid = validate($_POST['sid']);
    $scode = validate($_POST['scode']);

    if (empty($sid)) {
        $_SESSION['status'] = "Voter ID is Required!";
        $_SESSION['status_code'] = "info";
        header("Location: StudentLogin.php");
        ob_end_flush();
        exit();
    } elseif (empty($scode)) {
        $_SESSION['status'] = "Serial Code is Required!";
        $_SESSION['status_code'] = "info";
        header("Location: StudentLogin.php");
        ob_end_flush();
        exit();
    } else {
        $sql = "SELECT * FROM votersdetails WHERE Student_ID = '$sid' AND Serial_Code = '$scode'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['Student_ID'] === $sid && $row['Serial_Code'] === $scode) {
                $_SESSION['Student_ID'] = $row['Student_ID'];
                $_SESSION['Serial_Code'] = $row['Serial_Code'];

                $sql = "SELECT Views FROM voters_verifications";
                $query_run = mysqli_query($conn, $sql);

                $query = "UPDATE voters_verifications SET Views = (Views + 1)";
                $query_run = mysqli_query($conn, $query);

                if (!empty($_POST["rememberMeStu"])) {
                    setcookie("sid", $_POST["sid"], time() + 24 * 60 * 60);
                    setcookie("scode", $_POST["scode"], time() + (24 * 60 * 60));
                } else {
                    setcookie("sid", "");
                    setcookie("scode", "");
                }

                $mysql = "SELECT * FROM election_details";
                $result = mysqli_query($conn, $mysql);
                $Estatus = "Published";

                if (mysqli_num_rows($result) === 1) {
                    $row = mysqli_fetch_assoc($result);
                    if ($row['Election_Status'] === $Estatus) {
                        $_SESSION['status'] = "Login Successful!";
                        $_SESSION['status_code'] = "success";
                        header("Location: Aspirantresult.php");
                        ob_end_flush();
                        exit();
                    } else{
                        $_SESSION['status'] = "Login Successful!";
                        $_SESSION['status_code'] = "success";
                        header("Location: Not_Publish_Result.php");
                        ob_end_flush();
                        exit();
                    }
                }
            } else {
                $_SESSION['status'] = "Invalid Credentials!";
                $_SESSION['status_code'] = "error";
                header("Location: StudentLogin.php");
                ob_end_flush();
                exit();
            }
        } else {
            $_SESSION['status'] = "Invalid Credentials";
            $_SESSION['status_code'] = "error";
            header("Location: StudentLogin.php");
            ob_end_flush();
            exit();
        }
    }
}
?>

<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
  <strong>Please,</strong> Enter Your Credentials
  
</div>
  <i class="fa-solid fa-graduation-cap"></i><label for="sid" class="form-label fw-bold fs-6 mb-2 m-2" name="sname">Voter ID</label>
<input type="text" class="form-control mb-4" oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="sid" placeholder="Enter Your Voter ID" value="<?php if(isset($_COOKIE["sid"])) { echo $_COOKIE["sid"]; } ?>" maxlength="12" required>

<i class="fa-solid fa-key"></i><label for="scode" class="form-label fw-bold fs-6 mb-2 m-2">Serial Code</label>
<input type="password" class="form-control mb-4" name="scode" placeholder="Enter Your Serial Code" value="<?php if(isset($_COOKIE["scode"])) { echo $_COOKIE["scode"]; } ?>" required>

<div class="row">
<div class="col-md-6">
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="rememberMeStu" id="invalidCheck2">
    <label for="invalidCheck2" class="form-check-label">
      Remember me?
    </label>
  </div>
</div>

<div class="col-md-6">
  <a href="forgetsc.php" class="text-decoration-none">Forgot Serial Code?</a>
</div>
</div>

<div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3 mb-2">
<button class="btn btn-primary" name="stulogin" type="submit" >Sign In</button>
</div>
</form>  
</div>
</div>

            
          </div>
        </div>
      
</body>
</html>

<?php
include "scripts.php";
?>