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
    <title>Issue Report | EC</title>

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
      .chatprofile{
        width: 100%;
        display: flex;
        justify-content: left;
        align-items: left;
      }
      .chatprofile img {
        height: 80px;
        width: 80px;
        border-radius: 60%;
        border: 5px solid #737373;

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
      .status label{
        color: #fff;
        font-size: 17px;
        padding: 10px 15px;
        border-radius: 5px;
        margin-top: 40px;
        padding-right: 25px;
        
      }
      .status-btn button{
        margin-top: 40px;
      }
      .status span{
        margin-right: 10px;
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
    .tableimg img{
      width: 135px;
      height: 135px;
    }
    
    /* Optional: Increase the width of the modal content */
    .modal.right .modal-content {
        width: 100%;
    }
    .rules{
        border-radius: 10px;
      }
      .rules h4{
        font-size: 26px;
      }
      .rules h4{
        margin-bottom: 5px;
        color: #666;
        text-align: center;
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
              ?>

        
<a href="Notificationbell_conn.php?id=123" target="_blank" name="bell">
<i class="fa-regular fa-bell"></i>
  <span class="position-absolute top-14 start-76 translate-middle badge rounded-pill bg-danger">
    <?php echo $row['Notifications']; ?>
    <span class="visually-hidden">unread messages</span>
  </span>
</a>

            </div>
      <?php
      

        }else{
          echo "No record";
        }
                
        
        ?>
        <?php
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
      <!--<i class="fa fa-bars" id="menubtn"></i>-->

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
            <a class="btn mt-1" href="Helpadmin_conn.php?data=helpaspirant"a>
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
      <div class="maindb bg-light">
        <!--Table-->
        <div class="container-fluid bg-light">
        <div class="row justify-content-center">
          <div class="rules shadow p-3 col-5 bg-light" style="margin-top: 50px;">
          
          <h4 class="m-2 fs-5"><i class="fa-solid fa-comments m-1"></i>EC Issue Reported</h4>

          <div class="d-flex justify-content-between mb-0">

          <div class="chatprofile">
        <?php
            include "db_conn.php";
            $aid = $_SESSION['Admin_ID'];
            $pass = $_SESSION['Admin_Password'];
            $query = "SELECT * FROM admindetails WHERE Admin_ID = '$aid' && Admin_Password = '$pass'";
            $query_run = mysqli_query($conn, $query);

            if (mysqli_num_rows($query_run) > 0) {
              while ($row = mysqli_fetch_array($query_run)) {
                $img = $row['Admin_Image'];
                $_SESSION['Admin_ID'] = $row['Admin_ID'];
                $_SESSION['Ec_Availability'] = $row['Ec_Availability'];
          ?>
            <div class="d-flex">
          <p class="mx-3 mb-0"><?php echo '<img src="data:image/png;base64,' . base64_encode($img) . '" alt="Image" class="mx-auto">';?></p>
          <p class="mt-3 mx-3"><?php echo $_SESSION['Admin_ID'] ?> <br>
          <span class="fw-bold" style="color: #299B63;"><?php echo $_SESSION['Ec_Availability']?></span>
          </p>
          </div>

          <?php
                  }
                }else{
                  echo "";
                }  

          ?>
        </div>
        
        <div><a type="button" href="adminlogout.php?data=logout" class="btn btn-secondary mx-2 mt-3 mb-0 shadow">LogOut</a></div>
            
              
            </div>
            <hr>

            <div class="input-group mb-3">
            <input type="text" class="form-control text-center" id="live_search" autocomplete="off" placeholder="Search...">
            <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
          </div>
          
          <div id="searchresult">
    <table id="example" class="table table-responsive table-hover">
        <?php
        include('db_conn.php');
        $query = "SELECT * FROM polling_agent";
        $query_run = mysqli_query($conn, $query);
        ?>
        <tbody>
            <?php
            if (mysqli_num_rows($query_run) > 0) {
                while ($row = mysqli_fetch_assoc($query_run)) {
                    $_SESSION['Agent_ID'] = $row['Agent_ID'];
                    $_SESSION['Agent_Availability'] = $row['Agent_Availability'];
                    ?>
                    <tr>
                        <td>
                            <a class="text-decoration-none text-black" href="Chat_ECpage.php?content=<?php echo $row['Agent_ID']; ?>">
                                <?php echo $row['Agent_ID'] ?>
                            </a>
                        </td>
                        <?php
                        if ($_SESSION['Agent_Availability'] == "Online") {
                            ?>
                            <td class="text-success fw-bold" style="text-align: right;">
                                <span class="spinner-grow spinner-grow-sm mx-1 fs-6" role="status" aria-hidden="true"></span>
                                <?php echo $_SESSION['Agent_Availability']; ?>
                            </td>
                            <?php
                        } else {
                            ?>
                            <td class="fw-bold text-muted" style="text-align: right;">
                                <i class="fa fa-circle text-muted mx-1" style="font-size:14px;"></i>
                                <?php echo $_SESSION['Agent_Availability']; ?>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='2'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#live_search").keyup(function () {
            var input = $(this).val();

            if (input != "") {
                $.ajax({
                    url: "livesearch4.php",
                    method: "POST",
                    data: {input: input},

                    success: function (data) {
                        $("#searchresult").html(data);
                        $("#searchresult").css("display", "block");
                    }
                });
            } else {
                // Reload the original table content when the input is empty
                $.ajax({
                    url: "original_tableEC.php", // Change this to the actual URL of your PHP script that generates the original table
                    method: "POST",
                    success: function (data) {
                        $("#searchresult").html(data);
                        $("#searchresult").css("display", "block");
                    }
                });
            }
        });
    });
</script>
          

          
      </div>
    </div>
    <div>
      
    </div>

    <script>
  function displayImage(event) {
  var input = event.target;
  var reader = new FileReader();

  reader.onload = function() {
    var imgElement = document.getElementById('previewImage');
    imgElement.src = reader.result;
  }

  if (input.files && input.files[0]) {
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
    
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
            <p class="text-center text-danger fs-3"><i class="fas fa-sign-out"></i></p>
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