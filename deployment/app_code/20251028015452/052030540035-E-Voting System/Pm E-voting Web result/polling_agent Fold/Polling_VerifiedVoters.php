<?php
session_start();

if (isset($_SESSION['Agent_ID']) && isset($_SESSION['Agent_Password'])){
  
  $last_activity = isset($_SESSION['last_activity']) ? $_SESSION['last_activity'] : time();
  $timeout = 900; // 15 minutes in seconds

  // Check if user has been inactive for more than the timeout period
  if (time() - $last_activity > $timeout) {
      // Destroy the session and redirect to the login page
      session_unset();
      session_destroy();
      $_SESSION['status'] = "TimeOut, Page Is Currently Inactive";
      $_SESSION['status_code'] = "info";
      header("Location: ../polling_agent.php"); // Replace "login.php" with your actual login page URL
      exit;
  }

  // Update the last activity time
  $_SESSION['last_activity'] = time();

  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />

    <link rel="icon" href="../images/Site logo.png" alt="rounded-pill" />
    <title>Dashboard | Voters </title>

    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

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

      .userdb{
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        align-items: center;
      }
      .userdb img {
        height: 130px;
        width: 130px;
        border-radius: 60%;
        border: 7px solid #fff;

      }

      .searchdb {
        position: relative;
        width: 60%;
        justify-self: center;
        top:10px
      }
      .searchdb input {
        width: 100%;
        height: 40px;
        padding: 0 40px;
        font-size: 16px;
        outline: none;
        border: none;
        border-radius: 10px;
        background: #f5f5f5;
      }
      .searchdb i {
        position: absolute;
        right: 15px;
        top: 15px;
        cursor: pointer;
      }
      /*Sidebar styling*/
      .sidebardb {
        position: fixed;
        top: 60px;
        width: 260px;
        height: calc(100% - 60px);
        background: #737373;
        overflow-x: hidden;
        transition: all 0.5s ease;
        text-align: center;
        transition: width 0.5s;
      }
      .sidebardb ul {
        margin-top: 18px;
        margin-left: -50px;
      }
      .sidebardb ul li {
        width: 100%;
        list-style: none;
      }
      
      .sidebardb ul li:hover a {
        color: #737373;
        background: #fff;
        border: 0;
        border-radius: 0;
      }
      .sidebardb .dropdown-menu a{
        color: #000;
      }
      
      .sidebardb ul li a {
        width: 100%;
        text-decoration: none;
        color: #fff;
        height: 50px;
        display: flex;
        align-items: center;
        
      }
      .sidebardb ul li a i {
        min-width: 60px;
        font-size: 20px;
        text-align: center;
      }
      
      .maindb {
        position: absolute;
        top: 60px;
        width: calc(100% - 260px);
        left: 260px;
        min-height: calc(100vh - 60px);
        background: #fff;
      }
      
      
      
      .containerdb h4 {
        font-size: 18px;
      }
      .ovall{
        color: #fff;
      }
      .notify span{
        font-size: 9px;
      }

      .notify i{
        color: #000;
        font-size: 20px; 

      }
      .logodb i{
        font-size: 20px;
      }
      .rules{
        border-radius: 10px;
      }
      .rules h4{
        font-size: 26px;
      }
      .rules h2{
        margin-bottom: 5px;
        font-size: 20px;
        color: #666;
        text-align: center;
      }
      
      /*Responsive Small media*/
      @media (max-width:1115px){
        .sidebardb{
          width: 50px;
        }
        .sidebardb img{
          opacity: 0;
          width: 0px;
        }
        .sidebardb ul li i{
          color: #fff;
          font-size: 45px;
          margin-top: 0px;
        }
        .sidebardb ul {
        margin-top: 0px;
        }
        .sidebardb ul li i:hover {
        color: #299B63;
   }
        
        .maindb{
          left: 60px;
          width: calc(100% - 60px);
        }
        .tabledb{
          width: 100%;
        }
        
        .containerdb h4 {
          font-size: 15px;
        }
        
      }
      .modal.right .modal-dialog {
        position: fixed;
        width: 380px; /* Adjust this value based on your needs */
        right: 0;
        top: 160px;
        transform: translateY(-50%);
        margin-right:50px;

    }
    
    /* Optional: Increase the width of the modal content */
    .modal.right .modal-content {
        width: 100%;
    }
    
    
    </style>
  </head>
  <body class="bg-light">
    <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
  ></script> 

    <div class="containerdb bg-light">
      <div class="topbardb">
        <div class="logodb">
          <a href="PollingAgent_Logout.php?data=logout" class="text-decoration-none text-dark"><h4>Pm E-Voting System</h4></a>
        </div>
        <div class="searchdb">
          <input type="text" id="searchdb" placeholder="Search here" />
          <label for="search"><i class="fas fa-search"></i></label>
        </div>

        <div class="notify">
        <?php
          include "db_conn.php";
          $query = "SELECT * FROM polling_agent";
          $query_run = mysqli_query($conn, $query);
          
        ?>
        <?php
          if (mysqli_num_rows($query_run) > 0) 
            while ($row = mysqli_fetch_assoc($query_run)) {
              $msg= $row['Message_No'];
            }else{
              echo "";
            }
              ?>

        
    <a type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">

      <i class="fa-regular fa-message"></i>
        <span class="position-absolute top-14 start-76 translate-middle badge rounded-pill bg-danger">
          <?php echo $msg; ?>
        </span>
        <span class="visually-hidden">unread messages</span>

            </a>

            </div>
     
              
        
              <div class="userid">
        <?php
            include "db_conn.php";
            $aid = $_SESSION['Agent_ID'];
            $pass = $_SESSION['Agent_Password'];
            $query = "SELECT * FROM polling_agent WHERE Agent_ID = '$aid' && Agent_Password = '$pass'";
            $query_run = mysqli_query($conn, $query);

            if (mysqli_num_rows($query_run) > 0) {
              while ($row = mysqli_fetch_array($query_run)) {
                $img = $row['Agent_ID'];
          ?>
          <a href="polling_profile.php" class="text-decoration-none text-dark"><p class="mt-2"><?php echo $row['Agent_ID']; ?></p></a>

          <?php
                  }
                }else{
                  echo "";
                }  

          ?>
        </div>
      </div>

      <div class="sidebardb shadow" id="sidebardb">
      <div class="userdb">
        <?php
            include "db_conn.php";
            $aid = $_SESSION['Agent_ID'];
            $pass = $_SESSION['Agent_Password'];
            $query = "SELECT * FROM polling_agent WHERE Agent_ID = '$aid' && Agent_Password = '$pass'";
            $query_run = mysqli_query($conn, $query);

            if (mysqli_num_rows($query_run) > 0) {
              while ($row = mysqli_fetch_array($query_run)) {
                $img = $row['Photo'];
          ?>
          <div>
          <p class="text-center mt-3"><?php echo '<img src="data:image/png;base64,' . base64_encode($img) . '" alt="Image" class="mx-auto">';?></p>

          </div>

          <?php
                  }
                }else{
                  echo "";
                }  

          ?>
        </div>

        <ul class="mt-2">
          <li>
            <a href="pollingagent_Page.php" class="btn">
              <i class="fas fa-th-large"></i>
              <div>Dashboard</div>
            </a>
          </li>
          
          <li>
            <a class="btn mt-1 active" href="Polling_VerifiedVoters.php" style="background-color:#fff;width:100%;color:#737373;border:0;border-radius: 0;";>
              <i class="fa-solid fa-user" style="color:#737373";></i>
              <div>Voter Verification</div>
            </a>
          </li>
          
          <li>
            <a class="btn mt-1" href="Polling_VerifiedCan.php">
            <i class="fa fa-user-o"></i>
              <div>Verified Candidates</div>
            </a>
          </li>

          <li>
            <a class="btn mt-1" href="MonitorElection.php">
            <i class="fa-solid fa-laptop"></i>
              <div>Monitor Election</div>
            </a>
          </li>
          
          <li>
            <a class="btn mt-1" href="PollingAuditResults.php">
            <i class="fa-solid fa-eye"></i>
              <div>Audit Result</div>
            </a>
          </li>
          
          <li>
            <a class="btn mt-1" href="IssueReport.php">
            <i class="fa-solid fa-comments"></i>
              <div>Issue Report</div>
            </a>
          </li>
          <hr class="mb-0 mt-0 bg-white">
          <li>
            <a class="btn"  data-bs-toggle="modal" data-bs-target="#logout">
              <i class="fa fa-sign-out"></i>
              <div>LogOut</div>
            </a>
          </li>
        </ul>
      </div>

      

 
      <div>
      <div class="maindb bg-light" id="content">
        <div class="container-fluid">
          <div class="rules shadow p-3" style="margin-top: 50px;margin-bottom: 70px;">
          
          <h2><i class="fa-solid fa-user mx-2"></i>Verified Voters</h2>
          <table id="example" class="table table-striped table-hover table-responsive">
          <?php
          include('db_conn.php');
          $query = "SELECT * FROM votersdetails";
          $query_run = mysqli_query($conn, $query)

          ?>
              <thead>
                  <tr>
                    <th>Voter ID</th>
                    <th>Voter Name</th>
                    <th>Contact</th>
                    <th>Department</th>
                    <th>Voting Status</th>
                    <th>Voter Status</th>
                    
                    
                    
              </thead>
              <tbody>
                
              <?php
                if (mysqli_num_rows($query_run) > 0) {
                  while ($row = mysqli_fetch_assoc($query_run)) {
                    $Action = $row['Actions'];
              
                ?>
                <tr>
                  <td><?php echo $row['Student_ID'] ?></td>
                  <td><?php echo $row['Student_Name'] ?></td>
                  <td><?php echo $row['Contact'] ?></td>
                  <td><?php echo $row['Department'] ?></td>

                  <?php
                  if ($Action == "Voted"){
                    ?>
                    <td><label for="reg" class="bg-success text-white" style="border-radius: 5px;padding: 10px 15px;"><i class="fa-solid fa-check-to-slot m-1"></i>Voted</label></td>
                    <?php
                  }else{
                    ?>
                    <td><label for="reg" class="bg-danger text-white" style="border-radius: 5px;padding: 10px 13px;">Not Voted</label></td>
                    <?php
                  }
                  ?>

                  <td><label for="reg" class="bg-light text-success shadow" style="border-radius: 5px;padding: 10px 15px;"><i class="fa fa-check m-1"></i>Verified</label></td>
                
                  
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
                    
                  </tr>
                  <?php
                }  

                 ?>
              </tbody>
            </table>
          

          </div>
        </div>
            

                
                

             

                </div>

        </div>
      </div>
    </div>
    <div>
      
    </div>

    <!--Model for Message-->
    <?php
    $_SESSION['Agent_ID'] = $aid;
    $query = "SELECT * FROM polling_agent WHERE Agent_ID = '$aid'";
    $query_run = mysqli_query($conn, $query);

    ?>
  
    <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="staticBackdropLabel">Message From EC</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php
      $msgno ="0";
      $stmt = $conn->prepare("UPDATE polling_agent SET Message_No = ?");
      $stmt->bind_param("s",$msgno);
      $stmt->execute();

        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_assoc($query_run)) {
              ?>
              <p><?php echo $row['Messages'] ?></p>
              <p class="text-end"><?php echo $row['Message_Time'] ?></p>
              <?php

        }
        } else {
        echo "No Message";
        }
                ?>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Read</button>
      </div>
    </div>
  </div>
</div>
    
    <!--Admin Modal-->
    <div>
      <div
      class="modal right fade"
      id="dashboard"
      tabindex="-1"
      aria-labelledby="ModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog shadow">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel"><i class="fa-solid fa-user mx-2" aria-hidden="true"></i>Polling Agent Profile</h5>
          </div>
          <div class="modal-body mt-1">

            <div class="container">
            <table class="table" style="width=100%">
            <?php
            include "db_conn.php";
            $aid = $_SESSION['Agent_ID'];
            $pass = $_SESSION['Agent_Password'];
            $query = "SELECT * FROM polling_agent WHERE Agent_ID = '$aid' && Agent_Password = '$pass'";
            $query_run = mysqli_query($conn, $query);

          ?>
           <tbody>
           <?php
                if (mysqli_num_rows($query_run) > 0) {
                  while ($row = mysqli_fetch_array($query_run)) {
                    $img = $row['Photo'];
      
                ?>
            <tr>
            <td class="tableimg"><?php echo '<img src="data:image/png;base64,' . base64_encode($img) . '" alt="Image" style: width="135px";>';?></td>
              <td>
              <h5 class="mt-4">Agent ID</h5>
              <p class="text-success fw-bold"><?php echo $row['Agent_ID'] ?></p>
              </td>
            </tr>
            
           </tbody>
           <?php
                  }
                }else{
                  echo "No Record Found";
                }  

                 ?>

           </table>

            </div>

          </div>
          
        </div>
      </div>
    </div>

    </div>

    <script>
    $('#dashboard').modal('show');
</script>

     <!--LogOut-->

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
            <p class="text-center text-danger" style="font-size: 25px;";><i class="fas fa-sign-out"></i></p>
            <p class="text-center">Are you sure you want to <b class="text-danger">LogOut</b> ?</p>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <a class="btn btn-danger" href="PollingAgent_Logout.php?data=logout" >LogOut</a>
          </div>
        </div>
      </div>
    </div>

    </div>

     <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
     <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

     <script>
      $(document).ready(function () {
        $('#example').DataTable();
      });
     </script>
    

  </body>
</html>
<?php
}else{
    $_SESSION['status'] = "TimeOut, Page Is Currently Inactive";
    $_SESSION['status_code'] = "info";
    header("Location: ../polling_agent.php");
    exit();
}
?>
<?php
include "scripts.php";
?>
