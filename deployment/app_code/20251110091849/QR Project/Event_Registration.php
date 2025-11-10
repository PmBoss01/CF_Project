<?php
session_start();
include('db_conn.php');
?>

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

    <title>Admin Dashbard | Event Registration</title>
    <link rel="icon" href="img/toastlogo.png" alt="rounded-pill" />


    <script
      src="https://kit.fontawesome.com/48e15f0c7c.js"
      crossorigin="anonymous"
    ></script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400&display=swap");

      body {
        font-family: "Poppins", sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      .sidebar {
        height: 100%;
        width: 62px;
        position: fixed;
        top: 0;
        left: 0;
        background: linear-gradient(to top, #ff0000, #0000ff);
        padding-top: 20px;
        color: #f8f9fa;
      }

      .sidebar a {
        padding: 22px 15px;
        text-decoration: none;
        color: #f8f9fa;
        display: block;
        transition: 0.3s;
      }
      .sidebar i {
        font-size: 25px;
      }

      .sidebar a:hover {
        background-color: #f8f9fa;
        color: #000;
      }

      .content {
        margin-left: 70px;
        padding: 20px;
        margin-top: -35px;
      }
      .custom-shape {
        width: 100%;
        height: 100px;
        background: linear-gradient(to right, #ff0000, #0000ff);
        border-radius: 0 0 20px 20px; /* Border radius applied to top-left and bottom-left corners */
        color: #f8f9fa;
        text-align: center;
        line-height: 100px;
      }
      .dashboard {
        border-radius: 20px;
        margin-top: 25px;
      }
      .active {
        background-color: #f8f9fa;
        width: 100%;
        border: 0;
        border-radius: 0;
      }
      .active i {
        color: #000;
      }
      .signupform form{
        justify-content: center;
        align-items: center;
        border-radius: 0 0 20px 20px;
        width: 100%;
      }
      .btn {
        transition: box-shadow 0.3s ease;
      }
      .btn:hover {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }
      .uploadimg{
        width: 135px;
        height: 135px;
      }
       /* Responsive styles */
       @media screen and (max-width: 600px) {
         .uploadimg{
          width: 110px;
          height: 110px;
        }
      }
      @media screen and (max-width: 500px) {
         .uploadimg{
          width: 80px;
          height: 80px;
        }
      }
    </style>
  </head>
  <body class="bg-light">
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>

    <div class="sidebar">
      <div class="d-flex justify-content-center mt-4 mb-3">
      <p class="text-center" style="font-size: 10px">
          <img src="img/dash.png" alt="" style="width: 50px" />
        </p>
      </div>

      <a href="Admin.php" class="mb-1"
        ><i class="fa fa-tachometer" aria-hidden="true"></i>
      </a>
      <a href="Event_Registration.php" class="active mb-1"
        ><i class="fa-solid fa-user-pen"></i
      ></a>
      <a href="uploadList.php" class="mb-1"
        ><i class="fa-solid fa-cloud-arrow-up"></i
      ></a>
      <a href="Eventsinfo.php" class="mb-1"
        ><i class="fa-solid fa-registered"></i
      ></a>
      <a href="qrCodeGenerator.php"><i class="fa-solid fa-qrcode"></i></a>
    </div>

    <div class="content">
      <div class="custom-shape shadow" style="font-size: 20px">
        <i class="fa-solid fa-user-shield fs-4"></i> Administator Dashboard
      </div>

      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="signupform">
            <form action="ERegistrations_Conn.php" method="post" enctype="multipart/form-data" class="p-3 shadow-lg bg-light">
            <h5><a href="#" class="text-dark"><i class="fa fa-pencil mx-1" aria-hidden="true"></i></a>Event Registration</h5>
                <!--PHP For Admin Login-->
  
              <div class="alert alert-success alert-dismissible text-center" role="alert">
                <strong>Please,</strong> Please, Provide the Correct Informations
              </div>
                <i class="fa fa-pen"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Name Of The Event</label>
                <input type="text" class="form-control mb-1" id="Nevent" name="ename"  placeholder="Name of The Event (Event Type)" autocomplete="off" required>
  
                <div class="row">
                  <div class="col-7">
                      <i class="fa fa-user"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Name Of Person</label>
                      <input type="text" class="form-control text-center mb-2" id="person" name="nperson" placeholder="Name Of Person" autocomplete="off" required>
                  </div>
  
                  <div class="col-5">
                      <i class="fa fa-whatsapp"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Contact</label>
                      <input
                    type="phonenumber"
                    class="form-control text-center mb-2"
                    id="validationDefault03"
                    name = "fphone"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    required
                    placeholder="024XXXXXXX"
                    maxLength="10"
                    autocomplete="off"
                  />
  
                  </div>
  
                  <div class="col-8">
                    <i class="fa fa-picture-o"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Upload Event Image</label>
                    <input type="file" class="form-control mb-2" name="photo" id="imageInput" onchange="displayImage(event)"id="photos" accept=".PNG, .JPG, .JPEG" required>
                  </div>

                  <div class="col-4">
                    <p class="border text-center"><img src="" alt="Upload Image" id="previewImage" class="uploadimg"></p>
                  </div>
  
                  <div class="col-4">
                      <i class="fa fa-address-book-o"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Specify Gender</label>
                      <select class="form-select mb-2" name="gender" required>
                          <option selected disabled value="">~Select~</option>                        
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                          <option value="Custom">Custom</option>
                        </select>
                  </div>
  
  
                  <div class="col-4">
                      <i class="fa fa-clock"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Event Time</label>
                      <input type="time" class="form-control" name="time" id="time" required>
                  </div>
  
                  <div class="col-4">
                      <i class="fa fa-calendar-o"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Event Date</label>
                      <input type="date" class="form-control" name="date" id="date"required>
                  </div>
  
                </div>
               
              <div class="d-grid gap-2">
              <button type="submit" class="btn btn-light mt-3 mb-3 text-light" name="register" style="background: linear-gradient(to left, #ff0000, #0000ff);
              "><i class="fa fa-pencil-square mx-1"></i>Register Event</button>
            </div>
          </form>
  </div>
  </div>
  </div>

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
  </body>
</html>

<?php
include "alert.php";
?>
