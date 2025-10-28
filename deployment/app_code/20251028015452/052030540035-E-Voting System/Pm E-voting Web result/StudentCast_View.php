<?php
ob_start();
include "db_conn.php";
include "scripts.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Voter | Cast_View</title>
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
      margin-top: 100px;
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
          <h5><a href="Homepage.php"><img src="images/logo.png" class="img-responsive" /></a>SELECT YOUR PREFERENCE</h5>
              <!--PHP For Admin Login-->
<?php


  if (isset($_POST['studentselectbtn'])) {
    $student = $_POST['student'];

    if ($student == "Cast Your Vote") {
      $_SESSION['status'] = "Please, SignIn To Cast Votes";
      $_SESSION['status_code'] = "info";
      header("Location: Studentcast_login.php");
      ob_end_flush();
      exit();
    }elseif($student == "View Election Results"){
      $_SESSION['status'] = "Please, SignIn To View Election Results";
      $_SESSION['status_code'] = "info";
      header("Location: StudentLogin.php");
      ob_end_flush();
      exit();
    }
  }

?>
            <div class="alert alert-success alert-dismissible text-center" role="alert">
              <strong>Please,</strong> Select Your Preference
            </div>
              <i class="fa-solid fa-graduation-cap"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Select Your Type</label>
              <select id="validationDefault04" class="form-select" name="student" required>
                <option selected disabled value="">~Select~</option>
                <option value="Cast Your Vote">Cast Votes</option>
                <option value="View Election Results">View Election Results</option>
            </select>
        
            <div class="d-grid gap-2">
            <button class="btn btn-primary mt-5 mb-3" type="submit" name="studentselectbtn">OK</button>
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
