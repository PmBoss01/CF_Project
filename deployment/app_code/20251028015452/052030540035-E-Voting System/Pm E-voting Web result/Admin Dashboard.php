<?php
session_start();

if (isset($_SESSION['Admin_ID']) && isset($_SESSION['Admin_Password'])){
  
  $last_activity = isset($_SESSION['last_activity']) ? $_SESSION['last_activity'] : time();
  $timeout = 900; // 15 minutes in seconds

  // Check if user has been inactive for more than the timeout period
  if (time() - $last_activity > $timeout) {
      // Destroy the session and redirect to the login page
      session_unset();
      session_destroy();
      $_SESSION['status'] = "TimeOut, Page Is Currently Inactive";
      $_SESSION['status_code'] = "info";
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

    <link rel="icon" href="images/Site logo.png" alt="rounded-pill" />
    <title>Dashboard</title>

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

      .userdb {
        position: relative;
        width: 40px;
        height: 40px;
        margin-left: 15px;
      }
      .userdb img {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        object-fit: cover;
        border-radius: 60%;
        border: 2px solid #299B63;

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
        background: #299B63;
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
        color: #299B63;
        background: #fff;
        border: 0;
        border-radius: 0;
      }
      .sidebardb .dropdown-menu a{
        color: #000;
      }
      .dropdown-menu ul li:hover a {
        color: #299B63;
        background: #fff;
        border: 0;
        border-radius: 0;
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
      .cardsdb {
        width: 100%;
        padding: 35px 20px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 20px;
      }
      .cardsdb .carddb {
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 10px;
        box-shadow: 0 7px 25px 0 rgba(0, 0, 0, 0.08);
      }
      .cardsdb .carddb:hover {
        background-color: #299B63;
      }
      .cardsdb .carddb:hover .numberdb {
        color: #fff;
      }
      .cardsdb .carddb:hover .numberdbb {
        color: #fff;
      }

      .cardsdb .carddb:hover .card-numberdb {
        color: #fff;
      }
      .cardsdb .carddb:hover .icon-boxdb {
        color: #fff;
      }
      .numberdb {
        font-size: 35px;
        font-weight: 400;
        font-family: "Poppins", sans-serif;
        color: #299B63;
      }
      .card-namedb {
        color: #888;
        font-weight: 600;
      }
      .icon-boxdb {
        font-size: 45px;
        color: #299B63;
      }
      img{
        border-radius: 10%;
      }
      
      .tabledb{
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
        width: 100%;
        margin-top: 50px;
      }
      .tabledb h2{
        margin-bottom: 5px;
        font-size: 20px;
        color: #666;
        text-align: center;
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
          <a href="adminlogout.php?data=logout" class="text-decoration-none text-dark"><h4>Pm E-Voting System</h4></a>
        </div>
        <div class="searchdb">
          <input type="text" id="searchdb" placeholder="Search here" />
          <label for="search"><i class="fas fa-search"></i></label>
        </div>

        <div class="notify">
        <?php
          include "db_conn.php";
          $query = "SELECT * FROM voters_verifications";
          $query_run = mysqli_query($conn, $query);
          
        ?>
        <?php
          if (mysqli_num_rows($query_run) > 0) 
            while ($row = mysqli_fetch_assoc($query_run)) {
              $notifications = $row['Notifications'];
              ?>

        <?php
        if ($row['Notifications'] === "0"){
          ?>
          <a href="Notificationbell_conn.php?id=123" target="_blank" name="bell">
      <i class="fa-regular fa-bell"></i>
        <span class="position-absolute top-14 start-76 translate-middle badge rounded-pill bg-danger">
          <?php echo $row['Notifications']; ?>
          <span class="visually-hidden">unread messages</span>
        </span>
      </a>

          <?php

        }else{
          ?>



          <a id="notificationLink" href="Notificationbell_conn.php?id=123" target="_blank" name="bell">
          <i class="fa-regular fa-bell fa-shake"></i>
          <span class="position-absolute top-14 start-76 translate-middle badge rounded-pill bg-danger">
            <?php echo $row['Notifications']; ?>
            <span class="visually-hidden">unread messages</span>
          </span>
        </a>

          <?php
        }
        ?>
      

            </div>
      <?php
      

        }else{
          echo "";
        }
                
        
        ?>
        
              
        
        <div class="userdb">
        <?php
            include "db_conn.php";
            $aid = $_SESSION['Admin_ID'];
            $pass = $_SESSION['Admin_Password'];
            $query = "SELECT * FROM admindetails WHERE Admin_ID = '$aid' && Admin_Password = '$pass'";
            $query_run = mysqli_query($conn, $query);

            if (mysqli_num_rows($query_run) > 0) {
              while ($row = mysqli_fetch_array($query_run)) {
                $img = $row['Admin_Image'];
          ?>

          <a data-bs-toggle="modal" data-bs-target="#dashboard" style="cursor:pointer;"><?php echo '<img src="data:image/png;base64,' . base64_encode($img) . '" alt="Image">';?></a>
          <?php
                  }
                }else{
                  echo "No Record Found";
                }  

          ?>
        </div>
      </div>

      <div class="sidebardb shadow" id="sidebardb">
      <img src="images/logo2.png" class="mx-auto d-block mt-2">

        <ul class="mt-2">
          <li>
            <a href="Admin Dashboard.php" class="active btn" style="background-color:#fff;width:100%;color:#299B63;border:0;border-radius: 0;";>
              <i class="fas fa-th-large" style="color:#299B63";></i>
              <div>Dashboard</div>
            </a>
          </li>
          <li>
            <a href="#" class="btn dropdown-toggle mt-1" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user"></i>
              <div>Registration</div>
            </a>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="Add_adminDash.php">New User</a></li>
            <li><a class="dropdown-item" href="voter_Registration.php">Voters</a></li>
            <li><a class="dropdown-item" href="can_Registration.php">Candidate</a></li>
          </ul>
          </li>
          
          <li>
            <a class="btn mt-1" href="viewaspresult_conn.php?data=viewResult">
              <i class="fa-solid fa-file"></i>
              <div>View Aspirant Result</div>
            </a>
          </li>
          <li>
            <a href="#" class="btn dropdown-toggle mt-1" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-cog"></i>
              <div>General Settings</div>
            </a>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="E_Settings.php">Election Settings</a></li>
            <li><a class="dropdown-item" href="portfolio.php">Add Portfolio</a></li>
            <li><a class="dropdown-item" href="department.php">Add Department</a></li>
          </ul>
          </li>
          <li>
            <a href="#" class="btn dropdown-toggle mt-1" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-check"></i>
              <div>Manage Records</div>
            </a>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="managevoters.php">Voters</a></li>
            <li><a class="dropdown-item" href="managecandidate.php">Candidates</a></li>
            <li><a class="dropdown-item" href="managepollingAgents.php">Polling Agents</a></li>
          </ul>
          </li>
          <li>
            <a class="btn" href="Profile_SettingsDash.php">
              <i class="fas fa-user-cog"></i>
              <div>Profile Settings</div>
            </a>
          </li>
          
          <li>
            <a class="btn mt-1" href="Active_log.php">
            <i class="fa fa-thumb-tack" aria-hidden="true"></i>
              <div>Activity Logs</div>
            </a>
          </li>
          <li>
            <a class="btn mt-1" href="Helpadmin_conn.php?data=helpaspirant">
              <i class="fa fa-question-circle"></i>
              <div>Help?</div>
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
      <!--Total Vote Casted-->
      <?php
            // SQL query to retrieve the Total_Voters column from the candidate_result table
              $sql = "SELECT Total_Voters FROM candidate_result LIMIT 1";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                // Fetch the value of the Total_Voters column
                $row = $result->fetch_assoc();
                $totalVoters = $row["Total_Voters"];

              }
            ?>



      <?php
        include "db_conn.php";

      /////////////////

      $columnToCount = "Validations";
      $valueToCount = "validated";

      // Construct the SQL query to count rows where the specified column has the specified value
      $sql = "SELECT COUNT(*) AS count FROM votersdetails WHERE $columnToCount = '$valueToCount'";

      // Execute the query
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // Retrieve the count
          $row = $result->fetch_assoc();
          $_SESSION["count"] = $row["count"];
          $validcount = $_SESSION["count"];

      } 




      //////////        
      
        $tableNames = ["votersdetails", "candidate_details", "department", "portfolio", "polling_agent", "admindetails", "chats"];  // Add your new table names

        foreach ($tableNames as $tableName) {
            $sql = "SELECT COUNT(*) as rowCount FROM $tableName";
            $result = mysqli_query($conn, $sql);
        
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $rowCount = $row['rowCount'];
        
                // Store the total row count in a session variable
                $_SESSION[$tableName . "_count"] = $rowCount;
                  echo "";
            } else {
                echo "";
            }
        }
        
        // Retrieve the total row counts for all tables outside the loop
        $votersdetails_count = $_SESSION['votersdetails_count'];
        $candidate_details_count = $_SESSION['candidate_details_count'];
        $department_count = $_SESSION['department_count'];
        $portfolio_count = $_SESSION['portfolio_count'];
        $polling_agent_count = $_SESSION['polling_agent_count'];
        $EC_count = $_SESSION['admindetails_count'];
        $chats_count = $_SESSION['chats_count'];
        $admindetails_count = $_SESSION['admindetails_count'];
        $validcount = $_SESSION["count"];


        $totalVoterpercentage = ($totalVoters/$votersdetails_count) * 100;
        $totalvalidcount = ($validcount/$votersdetails_count) * 100;

        // Update the voters_verifications table with the counts
        $stmt = $conn->prepare("UPDATE voters_verifications SET Registered_Students = ?, Portfolio = ?, Department = ?, Total_Voters = ?, Voters_Percentage = ?, Total_Validation = ?, Validation_Percentage = ?, Registered_Aspirants = ?, Polling_Agents = ?"); // Replace your_condition_here with the appropriate condition
        $stmt->bind_param("sssssssss", $votersdetails_count, $portfolio_count, $department_count, $totalVoters, $totalVoterpercentage, $validcount, $totalvalidcount, $candidate_details_count, $polling_agent_count);
        $stmt->execute();

        $query = "SELECT * FROM voters_verifications";
        $query_run = mysqli_query($conn, $query);

        ?>

        <div class="cardsdb bg-light">
            <div class="carddb shadow">
                <div class="card-contentdb">
                    <?php
                    if (mysqli_num_rows($query_run) > 0) {
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            ?>
                            <div class="numberdb"><?php echo $row['Registered_Students'] ?></div>
                            <div class="card-numberdb">Registered Voters</div>
                        </div>
                        <div class="icon-boxdb">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
            </div>

            

            <div class="carddb shadow">
                <div class="card-contentdb">
                    <div class="numberdb"><?php echo $row['Views'] ?></div>
                    <div class="card-numberdb">Views</div>
                </div>
                <div class="icon-boxdb">
                    <i class="fas fa-eye"></i>
                </div>
            </div>

            <div class="carddb shadow">
                <div class="card-contentdb">
                    <div class="numberdb"><?php echo $totalVoters ?></div>
                    <div class="card-numberdb">Votes Cast</div>
                </div>
                <div class="icon-boxdb">
                    <i class="fa fa-thumbs-o-up"></i>
                </div>
            </div>

            <div class="carddb shadow">
                <div class="card-contentdb">
                    <div class="numberdb"><?php echo $row['Registered_Aspirants'] ?></div>
                    <div class="card-numberdb">Total Candidates</div>
                </div>
                <div class="icon-boxdb">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            
            <!--Portfolio-->
            <div class="carddb shadow">
                <div class="card-contentdb">
                    <div class="numberdb"><?php echo $row['Portfolio'] ?></div>
                    <div class="card-numberdb">Portfolios</div>
                </div>
                <div class="icon-boxdb">
                <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>

            <div class="carddb shadow">
                <div class="card-contentdb">
                    <div class="numberdb"><?php echo $row['Department'] ?></div>
                    <div class="card-numberdb">Departments</div>
                </div>
                <div class="icon-boxdb">
                <i class="fa-solid fa-building-columns"></i>
                </div>
            </div>

            <div class="carddb shadow">
                <div class="card-contentdb">
                    <div class="numberdb"><?php echo $row['Polling_Agents'] ?></div>
                    <div class="card-numberdb">Polling Agents</div>
                </div>
                <div class="icon-boxdb">
                <i class="fa-solid fa-user-tag"></i>
                </div>
            </div>

            <div class="carddb shadow">
                <div class="card-contentdb">
                    <div class="numberdb"><?php echo $admindetails_count ?></div>
                    <div class="card-numberdb">Registered EC</div>
                </div>
                <div class="icon-boxdb">
                <i class="fa-solid fa-user-group"></i>
                </div>
            </div>

            <div class="carddb shadow">
                <div class="card-contentdb">
                    <div class="numberdb"><?php echo $_SESSION["count"] ?></div>
                    <div class="card-numberdb">Validations Made</div>
                </div>
                <div class="icon-boxdb">
                <i class="fa-solid fa-clipboard-check"></i>
                </div>
            </div>


            <?php
                        }
                    } else {
                        echo "No Record Found";
                    }
                    ?>

          <?php
                    include "db_conn.php";
                    $query = "SELECT * FROM election_details";
                    $query_run = mysqli_query($conn, $query);
                    
                  ?>
                  <?php
                    if (mysqli_num_rows($query_run) > 0) 
                      while ($row = mysqli_fetch_assoc($query_run)) {
                        $Vstatus = $row['Voting_Status'];
                        $Estatus = $row['Election_Status'];
                        
                        ?>

              
              <div class="carddb shadow">
                <div class="card-contentdb">
                    <div class="numberdb mt-1" style="font-size: 25px;"><?php echo $row['Election_ID'] ?></div>
                    <div class="card-numberdb mt-3">Election ID</div>
                </div>
                <div class="icon-boxdb">
                  <i class="fa-solid fa-user-pen"></i>
                </div>
            </div>

            <div class="carddb shadow">
                <div class="card-contentdb">
                    <div class="numberdb" style="font-size: 25px;"><?php echo $row['Starting_Date'] ?></div>
                    <div class="card-numberdb mt-3">Start Date</div>
                </div>
                <div class="icon-boxdb">
                <i class="fa-sharp fa-regular fa-calendar"></i>
                </div>
            </div>

            

            <div class="carddb shadow">
                <div class="card-contentdb">
                    <div class="numberdb" style="font-size: 25px;"><?php echo $row['Starting_Time'] ?></div>
                    <div class="card-numberdb mt-3">Start Time</div>
                </div>
                <div class="icon-boxdb">
                    <i class="fa-sharp fa-solid fa-clock"></i>
                </div>
            </div>

            <div class="carddb shadow">
                <div class="card-contentdb">
                    <div class="numberdb" style="font-size: 25px;"><?php echo $row['Ending_Time'] ?></div>
                    <div class="card-numberdb mt-3">End Time</div>
                </div>
                <div class="icon-boxdb">
                <i class="fa-sharp fa-solid fa-clock"></i>
                </div>
            </div>

            <div class="carddb shadow">
                <div class="card-contentdb">
                <?php
                    if ($Estatus == "Published"){
                  ?>
                    <div class="numberdb" style="font-size: 20px;"><?php echo $row['Election_Status'] ?></div>
                    <?php
                    } else{
                      ?>
                      <div class="numberdb text-danger" style="font-size: 20px;"><?php echo $row['Election_Status'] ?></div>
                      <?php
                    }
                    ?>
                    <div class="card-numberdb mt-3">Election Result</div>
                </div>
                <div class="icon-boxdb">
                <i class="fa-solid fa-e"></i><i class="fa-solid fa-check-to-slot fs-4"></i>
                </div>
            </div>

            <div class="carddb shadow">
                <div class="card-contentdb">
                  <?php
                    if ($Vstatus == "Open"){
                  ?>
                    <div class="numberdb" style="font-size: 21px;"><?php echo $row['Voting_Status'] ?></div>
                    <?php
                    } else{
                      ?>
                      <div class="numberdb text-danger" style="font-size: 21px;"><?php echo $row['Voting_Status'] ?></div>
                      <?php
                    }
                    ?>
                    <div class="card-numberdb mt-3">Voting Period</div>
                    
                </div>
                <div class="icon-boxdb">
                <i class="fa-solid fa-check-to-slot"></i>
                </div>
            </div>

            <div class="carddb shadow">
                <div class="card-contentdb">
                    <div class="numberdb"><i class="fa fa-cog" aria-hidden="true"></i></div>
                    <div class="card-numberdb">PmTecH</div>
                </div>
                <div class="icon-boxdb">
                    <img src="images/pm.png" alt="">
                </div>
            </div>

            <?php
      

        }else{
          echo "No record";
        }
                
        
        ?>
        <?php
        ?>
                    


                </div>


      
        

        </div>
      </div>
    </div>
    <div>
      
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
            <h5 class="modal-title" id="ModalLabel"><i class="fa-solid fa-user mx-2" aria-hidden="true"></i>EC Profile</h5>
          </div>
          <div class="modal-body mt-1">

            <div class="container">
            <table class="table" style="width=100%">
            <?php
            include "db_conn.php";
            $aid = $_SESSION['Admin_ID'];
            $pass = $_SESSION['Admin_Password'];
            $query = "SELECT * FROM admindetails WHERE Admin_ID = '$aid' && Admin_Password = '$pass'";
            $query_run = mysqli_query($conn, $query);

          ?>
           <tbody>
           <?php
                if (mysqli_num_rows($query_run) > 0) {
                  while ($row = mysqli_fetch_array($query_run)) {
                    $img = $row['Admin_Image'];
      
                ?>
            <tr>
            <td class="tableimg"><?php echo '<img src="data:image/png;base64,' . base64_encode($img) . '" alt="Image" style: width="135px";>';?></td>
              <td>
              <h5 class="mt-4">EC ID</h5>
              <p class="text-success fw-bold"><?php echo $row['Admin_ID'] ?></p>
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
            <a class="btn btn-danger" href="adminlogout.php?data=logout" >LogOut</a>
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
    header("Location: AdminLogin.php");
    exit();
}
?>
<?php
include "scripts.php";
?>