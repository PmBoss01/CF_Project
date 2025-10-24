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

    <title>Admin Dashbard | QR Code</title>
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
      .signupform .qrback {
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
      #imgBox {
        width: 200px;
        border-radius: 5px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 1s;
      }
      #imgBox img {
        width: 200px;
        padding: 10px;
      }
      #imgBox.show-img {
        max-height: 300px;
        margin: 10px auto;
        border: 1px solid #d1d1d1;
      }
      .error {
        animation: shake 0.1s linear 10;
      }
      @keyframes shake {
        0% {
          transform: translateX(0);
        }
        25% {
          transform: translateX(-2px);
        }
        50% {
          transform: translateX(0);
        }
        75% {
          transform: translateX(20px);
        }
        100% {
          transform: translateX(0);
        }
      }
      button{
        background: linear-gradient(to right, #ff0000, #0000ff);

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
      <a href="Event_Registration.php" class="mb-1"
        ><i class="fa-solid fa-user-pen"></i
      ></a>
      <a href="uploadList.php" class="mb-1"
        ><i class="fa-solid fa-cloud-arrow-up"></i
      ></a>
      <a href="Eventsinfo.php" class="mb-1"
        ><i class="fa-solid fa-registered"></i
      ></a>
      <a href="qrCodeGenerator.php" class="active"><i class="fa-solid fa-qrcode"></i></a>
    </div>

    <div class="content">
      <div class="custom-shape shadow" style="font-size: 20px">
        <i class="fa-solid fa-user-shield fs-4"></i> Administator Dashboard
      </div>

      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="signupform">
            <div class="qrback p-3 shadow-lg bg-light">
            <h5><a href="#" class="text-dark"><i class="fa fa-qrcode mx-1" aria-hidden="true"></i></a>QR CODE GENERATOR</h5>
                <!--PHP For Admin Login-->
  
              <div class="alert alert-success alert-dismissible text-center" role="alert">
                <strong>Please,</strong> Enter URL To Generate QR Code
              </div>
                <i class="fa fa-exchange"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Enter Your URL</label>
                <input type="text" class="form-control" id="qrText" placeholder="https://" autocomplete="off" required>
  
                <div id="imgBox">
                  <img src="" id="qrImage">
                </div>
          
              <div class="d-grid gap-2">
              <button class="btn btn-light text-light mt-5 mb-3" onclick="generateQR()">Generate QR Code</button>
            </div>
          </div>
  </div>
  </div>
  </div>
  
  <script>
  
    let imgBox = document.getElementById("imgBox");
    let qrImage = document.getElementById("qrImage");
    let qrText = document.getElementById("qrText");
  
    function generateQR(){
      if(qrText.value.length > 0){
      qrImage.src = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" + qrText.value;
      imgBox.classList.add("show-img");
    }else{
      qrText.classList.add('error');
      setTimeout(()=> {
        qrText.classList.remove('error');
      }, 1000);
    }
  }
  </script>
    </div>
  </body>
</html>
