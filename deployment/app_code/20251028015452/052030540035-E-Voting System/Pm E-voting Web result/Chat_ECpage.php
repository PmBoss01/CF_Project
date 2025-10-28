<?php
session_start();
include "scripts.php";

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Issue Report | Chat Polling Agent</title>
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
    .signupform{
      justify-content: center;
      align-items: center;
      border-radius: 30px;
      width: 100%;
      margin-top: 40px;
    }
    .btn{
      transition: box-shadow 0.3s ease;
    }
    .btn:hover{
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }
    .rectangular-bar {
      height: 70px; /* Adjust the height as needed */
      
    }

    .rectangular-bar.top {
      margin-bottom: 200px; /* Space between top bar and form */
      border-radius: 20px 20px 0 0;
      background-color: #737373; 
    }

    .rectangular-bar.bottom {
      margin-top: 100px; /* Space between bottom bar and form */
      border-radius: 0 0 20px 20px;
      background-color: #f5f5f5;
      
    }

    .chatuser{
      width: 100%;
      display: flex;
    }

    .chatuser img{
      height: 60px;
      width: 60px;
      border-radius: 60%;
      border: 5px solid #fff;
      margin-top: -41px;
      margin-left: 60px;

    }
    .custom-left {
        background-color: #f0f0f0; /* Set the desired background color */
        border-radius: 10px; /* Apply border-radius for rounded corners */
        display: block; /* Make it expand to fit content */
        padding: 7px; /* Add padding for spacing */
        min-width: auto; /* Set a minimum width */
        max-width: auto;
        text-align: right; /* Set a maximum width of 'auto' */
    }
    .custom-right {
        background-color: #7fffd4; /* Set the desired background color */
        border-radius: 10px; /* Apply border-radius for rounded corners */
        display: block; /* Make it expand to fit content */
        padding: 7px; /* Add padding for spacing */
        min-width: auto; /* Set a minimum width */
        max-width: auto; /* Set a maximum width of 'auto' */
        text-align: left;

        
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


  <div class="container mb-5">
      <div class="row justify-content-center">
      <div class="col-sm">
  <div class="signupform">
  
  <?php
          include('db_conn.php');
          $content = "";
          if (isset($_GET['content'])) {
            $content = urldecode($_GET['content']);
            
            
        } 
          $query = "SELECT * FROM polling_agent WHERE Agent_ID = '$content'";
          $query_run = mysqli_query($conn, $query)

          ?>
          <?php
                if (mysqli_num_rows($query_run) > 0) {
                  while ($row = mysqli_fetch_assoc($query_run)) {
                    $img = $row['Photo'];
                    $_SESSION['Agent_ID'] = $row['Agent_ID'];
                    $avail = $row['Agent_Availability'];
                    

                    ?>


          <div class="rectangular-bar top">
            <a href="EC_chatpage.php" class="text-light"><i class="fa fa-long-arrow-left" aria-hidden="true" style="font-size: 20px;margin-left:20px;margin-top: 25px;"></i></a>
            <div class="chatuser">
              <?php echo '<img src="data:image/png;base64,' . base64_encode($img) . '" alt="Image";>';?>
              <div style="margin-left: 12px;">
                <p class="text-light fw-normal mb-0" style="margin-top: -35px;"><?php echo $_SESSION['Agent_ID']; ?></p> 
                <p class="text-light fw-normal"><?php echo $avail ?></p>
              </div>
            </div>

            <div class="container-lg">
              <?php
            $aid = $_SESSION['Admin_ID'];
            $content = mysqli_real_escape_string($conn, $aid); // Escape the value to prevent SQL injection

            $query = "SELECT * FROM chats WHERE (Sender = '$aid' OR Receiver = '$content')";
            $query_run = mysqli_query($conn, $query);

            ?>

            <p class="text-center mt-2 mb-4">Messages are end-to-end encrypted. No one outside this chat can read them. <br>Your messages will appear here as you start chatting</p>

            <div>
              <div id="messageContainer">
                <?php
                if (mysqli_num_rows($query_run) > 0) {
                  while ($row = mysqli_fetch_array($query_run)) {
                    $Messages = $row['Messages'];
                    $Time_Delivered = $row['Time_Delivered'];
                    $sender = $row['Sender'];

                    ?>
                    <div>
                      <?php 
                      if ($sender == $aid) {
                        ?>
                        <p class="custom-right mt-2"><?php echo $Messages ?><span class="float-end mx-2 mt-2" style="font-size: 12px;"><?php echo $Time_Delivered ?><i class="fa fa-check text-success"></i></span></p>
                      <?php
                      } else {
                        ?>
                        <p class="custom-left mt-2"><?php echo $Messages ?><span class="float-start mt-2" style="font-size: 12px;"><?php echo $Time_Delivered ?><i class="fa fa-check text-success"></i></span></p>
                        <?php
                      }
                      ?>
                    </div>
                    <?php
                  }
                } else {
                  ?>
                  <p class="text-center text-success"><?php echo "No Messages"; ?></p>
                  <?php
                }  
                ?>
              </div>
            </div>
                </div>
                

              <!-- Top rectangular bar -->
                    <?php
              
                ?>
                <?php
                  }
                }else
                {
                  
                }
                  ?>    
   
    <div class="rectangular-bar bottom shadow">
    <form action="" method="post" id="messageForm">
    <div class="input-group container">
        <input type="text" class="form-control text-center" aria-label="Amount (to the nearest dollar)" placeholder="Type Your Message..." name="message" autocomplete="off" required>
        <button class="btn btn-success" type="submit" name="messagebtn"><i class="fa-solid fa-paper-plane"></i></button>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#messageForm').submit(function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        // Get the form data
        var formData = $(this).serialize();

        // Send an AJAX request to insert the message into the database
        $.ajax({
    type: 'POST',
    url: 'insert_messageEC.php',
    data: formData,
    success: function(response) {
        // Clear the input field
        $('input[name="message"]').val('');

        // Append the new message to the chat interface at the bottom
        $('#messageContainer').append(response); // Use #messageContainer here
        // Scroll to the bottom of the chat container to show the latest message
        $('#messageContainer').scrollTop($('#messageContainer')[0].scrollHeight);
    },
    error: function() {
        alert('Error sending the message.');
    }
});
    });
});
</script>


   
</div>

    </div> <!-- Bottom rectangular bar -->
  </div>
</div>

</div>
</body>
</html>

<?php
}else{
    $_SESSION['status'] = "Invalid Credentials";
    $_SESSION['status_code'] = "error";
    header("Location: AdminLogin.php");
    exit();
}
?>

<?php
include "scripts.php";
?>