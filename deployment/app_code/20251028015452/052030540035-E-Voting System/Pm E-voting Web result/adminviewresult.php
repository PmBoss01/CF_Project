<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['Admin_ID']) && isset($_SESSION['Admin_Password'])){
  
  $last_activity = isset($_SESSION['last_activity']) ? $_SESSION['last_activity'] : time();
  $timeout = 900; // 15 minutes in seconds

  // Check if user has been inactive for more than the timeout period
  if (time() - $last_activity > $timeout) {
      // Destroy the session and redirect to the login page
      session_unset();
      session_destroy();
      header("Location: AdminLogin.php"); // Replace "login.php" with your actual login page URL
      exit;
  }

  // Update the last activity time
  $_SESSION['last_activity'] = time();

  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Admin View Results </title>
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
      .btn-print{
        font-size: 18px;
        padding-right: 23px;
        border-radius: 15px;
        margin-top: 30px;
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
        <img src="images/logo.png" class="img-responsive mt-2 mb-2" />
        <h5 class="mt-2">Pm E-Voting System</h5>
        </div>    
       
    </div>

    <div>
      <h4 class="text-center mt-4">Certified Candidate Results</h4>
      <h5 class="text-center mt-3"><i class="fas fa-eye mx-2"></i>EC View</h5>
    </div>

    <!---------->
    <div class="table-responsive">
      <table class="container table table-striped table-hover shadow mt-5">
      <?php
          $query = "SELECT * FROM voters_verifications";
          $query_run = mysqli_query($conn, $query)

          ?>
        <thead>
          <tr>
            <th>Registered Voters</th>
            <th>Registered Candidates</th>
            <th>Validation Made</th>
            <th>Validation Percentage(%)</th>
            <th>Total Voters</th>
            <th>Voters Percentage(%)</th>

          </tr>
        </thead>

        <tbody>
        <?php
                if (mysqli_num_rows($query_run) > 0) {
                  while ($row = mysqli_fetch_assoc($query_run)) {
                    
                ?>
          <tr>
            <td><?php echo $row['Registered_Students'] ?></td>
            <td><?php echo $row['Registered_Aspirants'] ?></td>
            <td><?php echo $row['Total_Validation'] ?></td>
            <td><?php echo $row['Validation_Percentage'] ?></td>
            <td><?php echo $row['Total_Voters'] ?></td>
            <td><?php echo $row['Voters_Percentage'] ?></td>
          </tr>

          <?php
                  }
                }else{
                  ?>
                  <tr>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                  </tr>
                  <?php
                }  

                 ?>
        </tbody>

      </table>
    </div>

    <div class="table-responsive">
      <table class="container table table-striped table-hover shadow mt-4 mb-5">
      <?php
          $query = "SELECT candidate_result.*
          FROM candidate_result
          JOIN portfolio ON candidate_result.Position = portfolio.Portfolio_Name
          ORDER BY portfolio.Sn";

          $result = mysqli_query($conn, $query);

          // Check if the query was successful
          if (!$result) {
              die("Error in SQL query: " . mysqli_error($conn));
          }

          ?>
        <thead>
          <tr>
            <th>Candidate Name</th>
            <th>Photo</th>
            <th>Portfolio</th>
            <th>Department</th>
            <th>Votes</th>
            <th>Votes Percentage(%)</th>
            <th>Voted.No</th>
            <th>Voted No Percentage(%)</th>
          </tr>
        </thead>

        <tbody>
        <?php
                if (mysqli_num_rows($query_run) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $img = $row['Student_Image'];
                    
              
                ?>
          <tr>
            <td><?php echo $row['Student_Name'] ?></td>
            <td class="tableimg"><?php echo '<img src="data:image/png;base64,' . base64_encode($img) . '" alt="Image">';?></td>
            <td><?php echo $row['Position'] ?></td>
            <td><?php echo $row['Department'] ?></td>
            <td><?php echo $row['Total_Votes'] ?></td>
            <td><?php echo $row['Votes_Percentage'] ?></td>
            <td><?php echo $row['Voted_No'] ?></td>
            <td><?php echo $row['Voted_No_Percentage'] ?></td></td>
          </tr>

          <?php
                  }
                }else
                {
                  ?>
                  <tr>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                  </tr>
                  <?php
                }  

                 ?>
        </tbody>
      </table>
    </div>
    
    <form action="uploadresult_conn.php" method="post">
    <div class="d-flex justify-content-center align-items-center">
    <div class="mb-3 form-check mt-3">
    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
    <label class="form-check-label" for="exampleCheck1">Audited and Ready to Publish / Remove Results</label>
  </div>

  <button type="submit" class="btn btn-success mx-2 shadow" name="yesPublish">Yes!! Publish</button>
  <button type="submit" class="btn btn-danger mx-2 shadow" name="removeresult">Remove Result</button>
          
        </div>
        <div>
        </form>
        <?php
          include('db_conn.php');
          $query = "SELECT * FROM election_details";
          $query_run = mysqli_query($conn, $query)

          ?>
          <?php
                if (mysqli_num_rows($query_run) > 0) {
                  while ($row = mysqli_fetch_assoc($query_run)) {
                    $Estatus = "Published";
                    if ($row['Election_Status'] === $Estatus){              
                ?>
        <p class="text-center mt-2" style="font-size: 17px; font-weight: bold;">Election Status: <span class="text-success">&nbsp;&nbsp;<?php echo $row['Election_Status']?></span></p>
        <?php
                }else{
                  ?>
                  <p class="text-center mt-2" style="font-size: 17px; font-weight: bold;">Election Status: <span class="text-danger">&nbsp;&nbsp;<?php echo $row['Election_Status']?></span></p>
                  <?php
                }
                  }
                }else
                {
                  echo "";
                }  

                 ?>
        </div>
        <p class="text-center";>
        <button type="submit" class="btn btn-outline-primary text-center btn-print" onclick="window.print()"><i class="fa fa-print mx-2" aria-hidden="true"></i>Print Report</button>
        </p>
  

    <div class="copyright">
      <p>
        Copyright © 2023 Pm E-Voting System. Made with <i class="fas fa-heart"></i>
        by Pm Tech Solutions
      </p>
    </div>

  </body>
</html>

<?php
}else{
    $_SESSION['status'] = "Invalid Admin Credentials";
    $_SESSION['status_code'] = "error";
    header("Location: Homepage.php");
    exit();
}
?>
<?php
include "scripts.php";
?>

 

