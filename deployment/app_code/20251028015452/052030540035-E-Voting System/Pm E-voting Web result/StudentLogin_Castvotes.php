<?php
include "db_conn.php";
include "scripts.php";
session_start();


if (isset($_SESSION['Student_ID']) && isset($_SESSION['Serial_Code'])){
  
  $last_activity = isset($_SESSION['last_activity']) ? $_SESSION['last_activity'] : time();
  $timeout = 1800; // 30 minutes in seconds

  // Check if user has been inactive for more than the timeout period
  if (time() - $last_activity > $timeout) {
      // Destroy the session and redirect to the login page
      session_unset();
      session_destroy();
      $_SESSION['status'] = "TimeOut, Page Is Currently Inactive";
      $_SESSION['status_code'] = "info";
      header("Location: Studentcast_login.php"); // Replace "login.php" with your actual login page URL
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
    <title>Voter Dashboard | Vote</title>

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

      .searchdb {
        position: relative;
        width: 60%;
        justify-self: center;
        top:1px
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
        background: #006400;
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
      
            
      .maindb {
        position: absolute;
        top: 60px;
        width: calc(100% - 260px);
        left: 260px;
        min-height: calc(100vh - 60px);
        background: #fff;
      }
      table.table img {
      vertical-align: middle;
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
    td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
      table-layout: fixed;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
        }
        .col-6 button{
          transition: box-shadow 0.3s ease;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }
      .col-6 button:hover {
      /* Apply the shadow effect when hovering */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
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
          <a class="text-decoration-none text-dark"><h4>Pm E-Voting System</h4></a>
        </div>
        <div class="searchdb">
          <input type="text" id="searchdb" placeholder="Search here" />
          <label for="search"><i class="fas fa-search"></i></label>
        </div>

        <p class="mt-2 text-success fw-bold"><?php echo $_SESSION['sidpost'] ?></p>

      </div>

      <div class="userid">
       

       
     </div>



      <div class="sidebardb shadow" id="sidebardb">
      <img src="images/avatar.png" class="mx-auto d-block mt-3" style="width: 150px;height: 150px;">
      <p class="text-center text-light mt-3">Online</p>

      <!-- Add a data-confirm attribute to the Logout button -->
<p><a href="Studentcast_login.php" type="button" class="btn bg-light p-2" data-confirm="true"><i class="fa-solid fa-right-from-bracket mx-1"></i>LogOut</a></p>

<script>
  // Add an event listener to all elements with data-confirm attribute
  const confirmButtons = document.querySelectorAll('[data-confirm="true"]');
  confirmButtons.forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault(); // Prevent the default link behavior

      Swal.fire({
        text: "Are You Sure You want to LogOut?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6d6d6d',
        confirmButtonText: 'Yes, logout!'
      }).then((result) => {
        if (result.isConfirmed) {
          // Redirect to the logout page when confirmed
          window.location.href = "Studentcast_login.php";
        }
      });
    });
  });
</script>


      
      </div>
      
      <div>
      <div class="maindb bg-light">
        <!--Table-->
        <div class="container-fluid bg-light" style="margin-bottom: 150px;">
          <div class="tabledb shadow border-top" style="margin-top: 50px";>
            <h2><i class="fa-solid fa-check-to-slot mx-2"></i>VOTE FOR YOUR CANDIDATE</h2>
          </div>

          <div class="tabledb shadow border-top" style="margin-top: 30px;">

          <script>
        function handleRadioClick(radio) {
            // Uncheck the checkbox
            document.getElementById("myCheckbox").checked = false;
        }

        function handleCheckboxClick(checkbox) {
            // Uncheck both radio buttons
            document.getElementById("radio1").checked = false;
            document.getElementById("radio2").checked = false;
        }
    </script>

<script>
        function handleRadioClick(radio) {
            // Get the radio buttons in the same row
            var radios = radio.closest('tr').querySelectorAll('input[type="radio"]');
            
            // Uncheck all other radio buttons in the same row
            radios.forEach(function (otherRadio) {
                if (otherRadio !== radio) {
                    otherRadio.checked = false;
                }
            });

            // Uncheck the checkbox
            document.getElementById("myCheckbox").checked = false;
        }

        function handleCheckboxClick(checkbox) {
            // Get all radio buttons in the same table
            var radios = document.querySelectorAll('input[type="radio"]');

            // Uncheck all radio buttons
            radios.forEach(function (radio) {
                radio.checked = false;
            });
        }
    </script>
    
          
            
            <?php
            include "db_conn.php";
            
            // Check if a portfolio index is provided in the URL (for example, when the button is clicked)
            if (isset($_GET['index'])) {
                $currentPortfolioIndex = intval($_GET['index']);
            } else {
                // Initial index is 1
                $currentPortfolioIndex = 1;
            }

            // SQL query to retrieve a portfolio based on the current index
            $query = "SELECT * FROM portfolio ORDER BY Sn LIMIT 1 OFFSET " . ($currentPortfolioIndex - 1);
            $result = mysqli_query($conn, $query);

            // Check if the query was successful
            if (!$result) {
                die("Error in SQL query: " . mysqli_error($conn));
            }

            // Check if there is a portfolio based on the current index
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                // Get the Sn value of the current portfolio
                $currentSn = $row['Sn'];

                // Get the portfolio name
                $portfolioName = mysqli_real_escape_string($conn, $row['Portfolio_Name']);

                // SQL query to retrieve candidate details corresponding to the current portfolio
                $query = "SELECT candidate_details.*
                        FROM candidate_details
                        WHERE Position = '$portfolioName'
                        ORDER BY Position"; // You can change the ORDER BY as needed

                $result = mysqli_query($conn, $query);

                // Check if the query was successful
                if (!$result) {
                    die("Error in SQL query: " . mysqli_error($conn));
                }

                // Count the number of candidates
                $numCandidates = mysqli_num_rows($result);

                // Display the candidate details
                while ($row = mysqli_fetch_assoc($result)) {
                  
                    // Output data (replace with your column names)
                    $sid = $row['Student_ID'];
                    $Cname = $row['Student_Name'];
                    $img = $row['Student_Image'];
                    $position = $row['Position'];
                    $_SESSION['Position'] = $row['Position'];


                    if($numCandidates == "1"){
                      ?>
                    <form action="" method="POST">
                        <table class="table table-striped table-hover table-responsive">
                          
                            <tbody>
                                <tr>
                                    <td class="text-center"><?php echo '<img src="data:image/png;base64,' . base64_encode($img) . '" alt="Image";>'; ?></td>
                                    <td><?php echo $Cname ?></td>
                                    <td class="fw-bold shadow-sm bg-light"><?php echo $position ?></td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="option" onclick="handleRadioClick(this)" id="radio1" value="yes">
                                            <label class="form-check-label" for="exampleRadios2">
                                                <span class="text-success">
                                                <input type="hidden" name="cid" value="<?php echo $sid ?>">
                                                  Select to Vote YES
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="option" onclick="handleRadioClick(this)" id="radio2" value="no">
                                            <label class="form-check-label" for="exampleRadios3">
                                                <span class="text-danger">
                                                <input type="hidden" name="cid" value="<?php echo $sid ?>">
                                                  Select to Vote NO
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

    
                    
                    <?php

                    }else{
                      
                      ?>
                      <form action="" method="POST">
                      <table class="table table-striped table-hover table-responsive">
                          <tbody>
                              <tr>
                                  
                                  <td class="text-center"><?php echo '<img src="data:image/png;base64,' . base64_encode($img) . '" alt="Image";>'; ?></td>
                                  <td><?php echo $Cname ?></td>
                                  <td class="fw-bold shadow-sm bg-light"><?php echo $position ?></td>
                                  <td>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="option" onclick="handleRadioClick(this)" id="radio3" value='<?php echo $sid ?>'>
                                          <label class="form-check-label" for="exampleRadios4">
                                          <input type="hidden" name="ccid" value="<?php echo $sid ?>">
                                          <span class="text-success">Select to Vote</span>
                                          </label>
                                      </div>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                      
                      <?php
                

                    }

                    
                }

                

                ?>

                  <div class="form-check d-flex justify-content-center mt-4">
                    <input class="form-check-input" type="checkbox" name="option" value="skip" id="myCheckbox" onclick="handleCheckboxClick(this)">
                    <label class="form-check-label mx-1" for="flexCheckDefault">
                      Do You Want to <span class="fw-bold text-danger">SKIP<i class="fa-solid fa-arrow-right mx-1"></i></span> this Position
                    </label>
                  </div>
                    
                    <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="submit" name="submit" class="btn btn-success text-light mt-4 mb-4" onclick="nextButtonClicked()">Next Position</button>
                    </div>
                    <?php
                  
                  ?>
                  </form>
                  <?php

                  // Check if there is a next portfolio
                $nextPortfolioIndex = $currentPortfolioIndex + 1;

                // Query for the next portfolio with a higher Sn value
                $query = "SELECT * FROM portfolio WHERE Sn > $currentSn ORDER BY Sn LIMIT 1";
                $nextResult = mysqli_query($conn, $query);

                // Check if the form is submitted
                if (isset($_POST['submit'])) {

                    if (!isset($_POST['option'])) {
                      $_SESSION['status'] = "Please, Select One of the Options";
                      $_SESSION['status_code'] = "info";

                  }else {
                      if ($nextResult && mysqli_num_rows($nextResult) > 0) {
                        // Get the next portfolio
                        $nextRow = mysqli_fetch_assoc($nextResult);
                        $nextPortfolioIndex = $nextRow['Sn'];

                        // Insertion of Votes
                        $cid = $_POST['cid'];
                        $option = $_POST['option'];
                        $vstatus = "Voted";
                        $selectedRowID = isset($_POST['option']) ? $_POST['option'] : null;

                        //First Position
                        $query = "SELECT * FROM portfolio ORDER BY Sn LIMIT 1";
                        $result = mysqli_query($conn, $query);

                        // Check if the query was successful
                        if (!$result) {
                            die("Error in SQL query: " . mysqli_error($conn));
                        }

                        // Check if there is a row (lowest Sn) in the portfolio table
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);

                            // Get the Sn value of the first row
                            $firstSn = $row['Sn'];

                            // SQL query to retrieve candidate details corresponding to the first Sn
                            $query = "SELECT candidate_details.*
                                      FROM candidate_details
                                      WHERE Position = '" . mysqli_real_escape_string($conn, $row['Portfolio_Name']) . "'
                                      ORDER BY Position"; // You can change the ORDER BY as needed

                            $result = mysqli_query($conn, $query);

                            // Check if the query was successful
                            if (!$result) {
                                die("Error in SQL query: " . mysqli_error($conn));
                            }

                            // Display the candidate details
                            while ($row = mysqli_fetch_assoc($result)) {
                              $firstpos = $row['Position'];
                                
                            }
                            /// Checking If that is the first portfolio
                            if($position === $firstpos){

                              if ($option === "yes" || $option === "no" || $option == "skip" || is_numeric($option)) {
                                // Update Total_Voters for all candidates regardless of the option chosen
                                $stmt = $conn->prepare("UPDATE candidate_result SET Total_Voters = Total_Voters + 1");
                                $stmt->execute();
    
                                // Update Student Status
                                $Vstatus = "Voted";
                                $sid = $_SESSION['sidpost'];
                                $stmt = $conn->prepare("UPDATE votersdetails SET Actions = ? WHERE Student_ID = ?");
                                $stmt->bind_param("ss",$Vstatus, $sid);
                                $stmt->execute();
                          } 
                            }
                            

                        }

                        
                        // For Yes 
                        if ($option === "yes") {
                          // Update Total_Vote for the selected candidate
                          $stmt = $conn->prepare("UPDATE candidate_result SET Total_Votes = Total_Votes + 1 WHERE Student_ID = ?");
                          $stmt->bind_param("s", $cid);
                          $stmt->execute();
                      
                          // Retrieve Total_Vote and Vote_Casted for the selected candidate
                          $stmt = $conn->prepare("SELECT Total_Votes, Total_Voters, Voted_No FROM candidate_result WHERE Student_ID = ?");
                          $stmt->bind_param("s", $cid);
                          $stmt->execute();
                          $stmt->bind_result($totalVote, $voteCasted, $totalvoteNo);
                          $stmt->fetch();
                          $stmt->close();
                      
                          // Calculate the percentage (make sure to handle division by zero)
                          if ($voteCasted != 0) {
                              $votePercentage = ($totalVote / $voteCasted) * 100;
                              $voteNoPercentage = ($totalvoteNo / $voteCasted) * 100;
                          } else {
                              $votePercentage = 0;
                              $voteNoPercentage = 0;
                          }
                      
                          // Update Vote_Casted and Vote_Percentage for the selected candidate
                          $stmt = $conn->prepare("UPDATE candidate_result SET Votes_Percentage = ?,  Voted_No_Percentage = ? WHERE Student_ID = ?");
                          $stmt->bind_param("dds",$votePercentage, $voteNoPercentage, $cid);
                          $stmt->execute();
              
                          

                      }elseif($option === "no"){
                        // Update Total_Vote for the selected candidate
                        $stmt = $conn->prepare("UPDATE candidate_result SET Voted_No = Voted_No + 1 WHERE Student_ID = ?");
                        $stmt->bind_param("s", $cid);
                        $stmt->execute();
            
                        // Retrieve Total_Vote and Vote_Casted for the selected candidate
                        $stmt = $conn->prepare("SELECT Total_Votes, Total_Voters, Voted_No FROM candidate_result WHERE Student_ID = ?");
                        $stmt->bind_param("s", $cid);
                        $stmt->execute();
                        $stmt->bind_result($totalVote, $voteCasted, $totalvoteNo);
                        $stmt->fetch();
                        $stmt->close();
                    
                        // Calculate the percentage (make sure to handle division by zero)
                        if ($voteCasted != 0) {
                            $votePercentage = ($totalVote / $voteCasted) * 100;
                            $voteNoPercentage = ($totalvoteNo / $voteCasted) * 100;
                        } else {
                            $votePercentage = 0;
                            $voteNoPercentage = 0;
                        }
                    
                        // Update Vote_Casted and Vote_Percentage for the selected candidate
                        $stmt = $conn->prepare("UPDATE candidate_result SET Votes_Percentage = ?,  Voted_No_Percentage = ? WHERE Student_ID = ?");
                        $stmt->bind_param("dds",$votePercentage, $voteNoPercentage, $cid);
                        $stmt->execute();

                      }

                      if (!is_null($selectedRowID)) {
                    
                        // Retrieve the current values of Total_Vote and Vote_Casted for the selected candidate
                        $stmt = $conn->prepare("SELECT Total_Votes, Total_Voters FROM candidate_result WHERE Student_ID  = ?");
                        $stmt->bind_param("s", $selectedRowID);
                        $stmt->execute();
                        $stmt->bind_result($totalVote, $voteCasted);
                        $stmt->fetch();
                        $stmt->close();
                    
                        // Update Total_Vote and Vote_Casted
                        $totalVote += 1;
                        $voteCasted += 1;
                    
                        // Calculate the percentage (make sure to handle division by zero)
                        if ($voteCasted != 0) {
                            $votePercentage = ($totalVote / $voteCasted) * 100;
                        } else {
                            $votePercentage = 0;
                        }
                    
                        // Update Total_Vote, Vote_Casted, and Vote_Percentage for the selected candidate
                        $stmt = $conn->prepare("UPDATE candidate_result SET Total_Votes = ?, Votes_Percentage = ? WHERE Student_ID = ?");
                        $stmt->bind_param("dds",$totalVote, $votePercentage, $selectedRowID);
                        $stmt->execute();

                    
                        // Close the database connection
                        $conn->close();

                    }

                        
                        // Create a button to fetch the next portfolio
                      echo '<script>window.location.href="StudentLogin_Castvotes.php?index=' . $nextPortfolioIndex . '";</script>';
                      
                    }else {

                     
                    // SQL query to retrieve the last row (highest Sn) from the portfolio table
                    $query = "SELECT * FROM portfolio ORDER BY Sn DESC LIMIT 1";
                    $result = mysqli_query($conn, $query);

                    // Check if the query was successful
                    if (!$result) {
                        die("Error in SQL query: " . mysqli_error($conn));
                    }

                    // Check if there is a last row (highest Sn) in the portfolio table
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);

                        // Get the Sn value of the last row
                        $lastSn = $row['Sn'];
                        

                        // SQL query to retrieve candidate details corresponding to the last Sn
                        $query = "SELECT candidate_details.*
                                  FROM candidate_details
                                  WHERE Position = '" . mysqli_real_escape_string($conn, $row['Portfolio_Name']) . "'
                                  ORDER BY Position"; // You can change the ORDER BY as needed

                        $result = mysqli_query($conn, $query);

                        // Check if the query was successful
                        if (!$result) {
                            die("Error in SQL query: " . mysqli_error($conn));
                        }

                        // Display the candidate details
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Output data (replace with your column names)
                            if($row['Position'] == $_SESSION['Position']){

                              $cid = $_POST['cid'];
                              $option = $_POST['option'];
                              $vstatus = "Voted";
                              $selectedRowID = isset($_POST['option']) ? $_POST['option'] : null;

                              //First Position
                        $query = "SELECT * FROM portfolio ORDER BY Sn LIMIT 1";
                        $result = mysqli_query($conn, $query);

                        // Check if the query was successful
                        if (!$result) {
                            die("Error in SQL query: " . mysqli_error($conn));
                        }

                        // Check if there is a row (lowest Sn) in the portfolio table
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);

                            // Get the Sn value of the first row
                            $firstSn = $row['Sn'];

                            // SQL query to retrieve candidate details corresponding to the first Sn
                            $query = "SELECT candidate_details.*
                                      FROM candidate_details
                                      WHERE Position = '" . mysqli_real_escape_string($conn, $row['Portfolio_Name']) . "'
                                      ORDER BY Position"; // You can change the ORDER BY as needed

                            $result = mysqli_query($conn, $query);

                            // Check if the query was successful
                            if (!$result) {
                                die("Error in SQL query: " . mysqli_error($conn));
                            }

                            // Display the candidate details
                            while ($row = mysqli_fetch_assoc($result)) {
                              $firstpos = $row['Position'];
                                
                            }
                            /// Checking If that is the first portfolio
                            if($position === $firstpos){

                              if ($option === "yes" || $option === "no" || $option == "skip" || is_numeric($option)) {
                                // Update Total_Voters for all candidates regardless of the option chosen
                                $stmt = $conn->prepare("UPDATE candidate_result SET Total_Voters = Total_Voters + 1");
                                $stmt->execute();
    
                                // Update Student Status
                                $Vstatus = "Voted";
                                $sid = $_SESSION['sidpost'];
                                $stmt = $conn->prepare("UPDATE votersdetails SET Actions = ? WHERE Student_ID = ?");
                                $stmt->bind_param("ss",$Vstatus, $sid);
                                $stmt->execute();
                          } 
                            }
                            

                        }

                            
                            // For Yes 
                            if ($option === "yes") {
                              // Update Total_Vote for the selected candidate
                              $stmt = $conn->prepare("UPDATE candidate_result SET Total_Votes = Total_Votes + 1 WHERE Student_ID = ?");
                              $stmt->bind_param("s", $cid);
                              $stmt->execute();
                          
                              // Retrieve Total_Vote and Vote_Casted for the selected candidate
                              $stmt = $conn->prepare("SELECT Total_Votes, Total_Voters, Voted_No FROM candidate_result WHERE Student_ID = ?");
                              $stmt->bind_param("s", $cid);
                              $stmt->execute();
                              $stmt->bind_result($totalVote, $voteCasted, $totalvoteNo);
                              $stmt->fetch();
                              $stmt->close();
                          
                              // Calculate the percentage (make sure to handle division by zero)
                              if ($voteCasted != 0) {
                                  $votePercentage = ($totalVote / $voteCasted) * 100;
                                  $voteNoPercentage = ($totalvoteNo / $voteCasted) * 100;
                              } else {
                                  $votePercentage = 0;
                                  $voteNoPercentage = 0;
                              }
                          
                              // Update Vote_Casted and Vote_Percentage for the selected candidate
                              $stmt = $conn->prepare("UPDATE candidate_result SET Votes_Percentage = ?,  Voted_No_Percentage = ? WHERE Student_ID = ?");
                              $stmt->bind_param("dds",$votePercentage, $voteNoPercentage, $cid);
                              $stmt->execute();
                  
                              
    
                          }elseif($option === "no"){
                            // Update Total_Vote for the selected candidate
                            $stmt = $conn->prepare("UPDATE candidate_result SET Voted_No = Voted_No + 1 WHERE Student_ID = ?");
                            $stmt->bind_param("s", $cid);
                            $stmt->execute();
                
                            // Retrieve Total_Vote and Vote_Casted for the selected candidate
                            $stmt = $conn->prepare("SELECT Total_Votes, Total_Voters, Voted_No FROM candidate_result WHERE Student_ID = ?");
                            $stmt->bind_param("s", $cid);
                            $stmt->execute();
                            $stmt->bind_result($totalVote, $voteCasted, $totalvoteNo);
                            $stmt->fetch();
                            $stmt->close();
                        
                            // Calculate the percentage (make sure to handle division by zero)
                            if ($voteCasted != 0) {
                                $votePercentage = ($totalVote / $voteCasted) * 100;
                                $voteNoPercentage = ($totalvoteNo / $voteCasted) * 100;
                            } else {
                                $votePercentage = 0;
                                $voteNoPercentage = 0;
                            }
                        
                            // Update Vote_Casted and Vote_Percentage for the selected candidate
                            $stmt = $conn->prepare("UPDATE candidate_result SET Votes_Percentage = ?,  Voted_No_Percentage = ? WHERE Student_ID = ?");
                            $stmt->bind_param("dds",$votePercentage, $voteNoPercentage, $cid);
                            $stmt->execute();
    
                          }
    
                          if (!is_null($selectedRowID)) {
                        
                            // Retrieve the current values of Total_Vote and Vote_Casted for the selected candidate
                            $stmt = $conn->prepare("SELECT Total_Votes, Total_Voters FROM candidate_result WHERE Student_ID  = ?");
                            $stmt->bind_param("s", $selectedRowID);
                            $stmt->execute();
                            $stmt->bind_result($totalVote, $voteCasted);
                            $stmt->fetch();
                            $stmt->close();
                        
                            // Update Total_Vote and Vote_Casted
                            $totalVote += 1;
                            $voteCasted += 1;
                        
                            // Calculate the percentage (make sure to handle division by zero)
                            if ($voteCasted != 0) {
                                $votePercentage = ($totalVote / $voteCasted) * 100;
                            } else {
                                $votePercentage = 0;
                            }
                        
                            // Update Total_Vote, Vote_Casted, and Vote_Percentage for the selected candidate
                            $stmt = $conn->prepare("UPDATE candidate_result SET Total_Votes = ?, Votes_Percentage = ? WHERE Student_ID = ?");
                            $stmt->bind_param("dds",$totalVote, $votePercentage, $selectedRowID);
                            $stmt->execute();
    
                        
                            // Close the database connection
                            $conn->close();
    
                        }
    

                              echo '<script>
                              Swal.fire({
                                  text: "You have Voted Successfully!",
                                  icon: "success",
                                  allowOutsideClick: false, // Prevent clicking outside to close
                                  confirmButtonText: "OK"
                              }).then(function(result) {
                                  if (result.isConfirmed) {
                                      window.location.href = "StudentCast_View.php";
                                  }
                              });
                          </script>';
      
                          
      

                            }

                        }

                         
                    } else {
                        echo "No last row data found in the portfolio table.";
                    }

                  }

                      
                  // Close the database connection
                  mysqli_close($conn);
                    }
                }}
                 

            ?>
          
           
          </div>

          

      </div>
    </div>
    <div>
      
    </div>


    
  </body>
</html>
<?php

}else{
    $_SESSION['status'] = "Invalid Credentials";
    $_SESSION['status_code'] = "error";
    header("Location: Studentcast_login.php");
    exit();
}
?>

<?php
include "scripts.php";
?>