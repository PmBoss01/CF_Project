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

    <title>Admin Dashbard</title>
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
        border-radius: 0 0 20px 20px;
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

      <a href="Admin.php" class="active mb-1"
        ><i class="fa fa-tachometer" aria-hidden="true"></i>
      </a>
      <a href="Event_Registration.php" class="mb-1"
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
        <div class="dashboard p-2 shadow">
          <p class="text-center mt-4" style="font-size: 20px">
          <i class="fa-regular fa-handshake"></i> Welcome To ePlan Admin
            Dashboard
          </p>

          <div class="container-lg">
            <div class="row">
              <div class="col-4 mb-3 mt-3">
                <img src="img/dash.png" class="img-fluid" alt="" />
              </div>
              <div class="col-8 mt-5">
                <p class="text-center">
                  <i class="fa fa-tachometer" aria-hidden="true"></i>
                  <i class="fa-solid fa-user-pen"></i>
                  <i class="fa-solid fa-cloud-arrow-up"></i>
                  <i class="fa-solid fa-registered"></i>
                  <i class="fa-solid fa-qrcode"></i>
                </p>
                <p style="text-align: justify; margin-top: 21px">
                  The admin dashboard streamlines event management, allowing
                  administrators to easily register new events and upload PDF
                  outlines. It empowers real-time manipulation of event details
                  and enhances interaction by generating QR codes. Attendees can
                  scan codes for direct access to relevant PDF pages, optimizing
                  the overall event experience.
                </p>
                <p style="font-size: 12px" class="text-end">
                  <i class="fa-solid fa-laptop"></i> Made By:
                  <a href="#" class="text-decoration-none" class="fw-bold"
                    >myBesTecH</a
                  >
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
