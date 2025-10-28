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
    <title>Polling Agent ID</title>
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
    .col-6 img{
      width: 135px;
      height: 135px;
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
          <?php
          include('db_conn.php');
          $studentID = $_SESSION['Student_ID'];
          $query = "SELECT * FROM polling_agent WHERE Student_ID = '$studentID'";
          $query_run = mysqli_query($conn, $query)

          ?>
          <form action="" method="post" class="p-3 shadow-lg bg-light">
          <?php
                if (mysqli_num_rows($query_run) > 0) {
                  while ($row = mysqli_fetch_assoc($query_run)) {
                    $img = $row['Photo'];
              
                ?>
          <h5 class="text-center"><img src="images/logo.png" class="img-responsive" />Pm E-Vote</h5>
              <p class="text-center fs-6 mb-0 mb-1"> Election (Polling Agent ID Card)</p>
              <div class="container-fluid">
                <div class="row">
                    <div class="col-6">
                        <p><?php echo '<img src="data:image/png;base64,' . base64_encode($img) . '" alt="Image";>';?></p>
                    </div>

                    <div class="col-6">

                        <label for="name" class="form-label fw-bold mb-0">Student Name</label>
                        <p class="mt-0 mb-0"><?php echo $row['Student_Name'] ?></p>

                        <label for="name" class="form-label fw-bold mb-0">Candidate Name</label>
                        <p class="mt-0 mb-0"><?php echo $row['Candidate_Name'] ?></p>

                        <label for="name" class="form-label fw-bold mb-0">Department</label>
                        <p class="mt-0 mb-0"><?php echo $row['Department'] ?></p>
                    </div>

                    <div class="col-12 d-flex mt-3">
                      <label for="name" class="form-label fw-bold mb-0 mt-1">Student ID: </label>
                        <p class="mt-1 mb-0 mx-2"><?php echo $row['Student_ID'] ?><span class="mx-1">>>>>>></span></p>
                        <label for="" class="form-label bg-success text-white" style="padding: 5px;border-radius:5px;">PmTecH</label>
                    </div>
                </div>

              </div>

              <?php
                  }
                }else
                {
                  ?>
                  <?php echo"No Info Found"; ?>
                  <?php
                }  

                 ?>


              
            </form>

            <div class="d-flex justify-content-center mt-5">
                      <p class="m-2">Do You Want to Print ID?</p> 
                      <button class="btn btn-info" onclick="window.print()"><i class="fa fa-print m-1"></i>Print ID</button>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                    <a href="Homepage.php" class="btn btn-light m-1"><i class="fa fa-home m-1"></i>Home</a>
                      <a href="polling_agent.php" class="btn btn-light m-1"><i class="fa fa-sign-in m-1"></i>LogIn</a>
                    </div>

        </div>
        </div>
        </div>
        </body>
        </html>

        <?php
        include "scripts.php";
        ?>
