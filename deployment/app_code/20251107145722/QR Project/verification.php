<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />

    <title>Event Verification</title>
    <link rel="icon" href="img/toastlogo.png" alt="rounded-pill" />
    <script
      src="https://kit.fontawesome.com/48e15f0c7c.js"
      crossorigin="anonymous"
    ></script>

    <style>
            @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400&display=swap");
      @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap');  
        body {
          justify-content: center;
          align-items: center;
        }
        .container:hover img {
    transform: scale(1.1); /* You can adjust the scale factor as needed */
  }

  .container img {
    transition: transform 0.3s ease-out;
  }
  a{
    background: linear-gradient(to right, #ff0000, #0000ff);

  }
  img{
    height: 400px;
  }
        </style>
  </head>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>

    <?php
include('db_conn.php');

if (isset($_GET['event_name'])) {
    $event_name = $_GET['event_name']; // No need for htmlspecialchars here

    // Prepare the statement
    $query = "SELECT Photo FROM registerevent WHERE Event_Name = ?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "s", $event_name);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $img = $row['Photo'];
            ?>
            <div class="container d-flex justify-content-center mt-5">
                <span class="border border-secondary border-1 p-3">
                    <?php echo '<img src="data:image/png;base64,' . base64_encode($img) . '" alt="Image">'; ?>
                </span>
            </div>
            <?php
        }
    } else {
        echo "No Image Found";
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    ?>
    <p class="text-center mt-4" style="font-family: Dancing Script, cursive;
        font-size: 25px;font-style: normal;font-weight: <weight>;"><?php echo htmlspecialchars($event_name); ?></p>

<p class="text-center mt-4">
    <a href="ViewEventPDF.php?event_name=<?php echo urlencode($event_name); ?>" class="btn btn-primary btn-lg" style="font-family: Poppins, sans-serif; font-size: 18px; font-style: normal; font-weight: <weight>;">
        Proceed <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
    </a>
</p>

    <?php
} else {
    echo "Event name not provided.";
}


 
?>



  

  </body>
</html>

