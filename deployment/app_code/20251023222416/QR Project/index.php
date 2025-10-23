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

    <title>Welcome to ePlan</title>
    <link rel="icon" href="img/toastlogo.png" alt="rounded-pill" />

    <script
      src="https://kit.fontawesome.com/48e15f0c7c.js"
      crossorigin="anonymous"
    ></script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400&display=swap");

      body {
        font-family: "Poppins", sans-serif;
        justify-content: center;
        align-items: center;
      }
      img {
        width: 100px;
        height: 500px;
      }
    </style>
  </head>
  <body>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>

    <div
      id="carouselExampleDark"
      class="carousel carousel-dark slide"
      data-bs-ride="carousel"
    >
      <div class="carousel-indicators">
        <button
          type="button"
          data-bs-target="#carouselExampleDark"
          data-bs-slide-to="0"
          class="active"
          aria-current="true"
          aria-label="Slide 1"
        ></button>
        <button
          type="button"
          data-bs-target="#carouselExampleDark"
          data-bs-slide-to="1"
          aria-label="Slide 2"
        ></button>
        <button
          type="button"
          data-bs-target="#carouselExampleDark"
          data-bs-slide-to="2"
          aria-label="Slide 3"
        ></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="20000">
          <img src="img/bg1.jpg" class="d-block w-100" alt="..." />
          <div class="carousel-caption d-none d-md-block text-center">
            <i class="fa fa-handshake text-light fs-3"></i>
    <h5 class="text-light">Welcome To myBes Event Plan!</h5>
    <p class="text-light" style="font-size: 12px;">Made By: myBesTecH</p>
</div>

        </div>
        <div class="carousel-item" data-bs-interval="2000">
          <img src="img/WD.jpg" class="d-block w-100" alt="..." />
          <!--<div class="carousel-caption d-none d-md-block">
            <h5>Second slide label</h5>
            <p>Some representative placeholder content for the second slide.</p>
          </div>-->
        </div>
        <div class="carousel-item">
          <img src="img/FN.jpg" class="d-block w-100" alt="..." />
          <!--<div class="carousel-caption d-none d-md-block">
            <h5>Third slide label</h5>
            <p>Some representative placeholder content for the third slide.</p>
          </div>-->
        </div>
      </div>
      <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#carouselExampleDark"
        data-bs-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#carouselExampleDark"
        data-bs-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <div>
      <p class="text-center mt-3 mb-0">SELECT YOUR EVENT CATEGORY</p>
    </div>

    <?php
include('db_conn.php');

$query = "SELECT * FROM registerevent";
$query_run = mysqli_query($conn, $query);

if (mysqli_num_rows($query_run) > 0) {
    $events = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
    ?>
    <div class="container">
        <div class="row">
            <?php
            foreach ($events as $event) {
            ?>
                <div class="col-6">
                    <a href="verification.php?event_name=<?php echo urlencode($event['Event_Name']); ?>" class="btn btn-link text-decoration-none text-dark fw-bold" style="width: 100%">
                        <i class="fa-regular fa-circle-right fa-beat"></i> <?php echo $event['Event_Name'] ?>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
<?php
} else {
  ?>  <p class='text-center mb-1' style="font-size: 40px;"><i class="fa-regular fa-face-rolling-eyes fa-shake"></i></p>
  <?php
    echo "<p class='text-center fw-bold text-muted'>Events Are Not Available!</p>";
}
?>


  </body>
</html>
