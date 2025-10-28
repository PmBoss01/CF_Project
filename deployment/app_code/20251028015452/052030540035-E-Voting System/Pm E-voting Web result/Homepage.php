<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Pm E-Voting System</title>
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
      }
      
      #navbarNav li {
        list-style-type: none;
        display: inline-block;
        margin: 2px;
        line-height: 25px;
        font-family: 'Poppins', sans-serif;

      }
      #navbarNav ul li a {
        text-decoration: none;
        color: black;
        font-size: 15px;
        padding: 6px 18px;
        transition: 0.4s all ease-out;
      }
  
      #navbarNav ul li a.active,
      #navbarNav ul li a:hover {
        background: #ff004f;
        color: #fff;
        border-radius: 4px;
        transition: 0.4s all ease-in-out;
      }

      .big-head{
        margin: 50px 0px;
        font-family: 'Poppins', sans-serif;
      }
  
      .big-text{
        margin: 10px 0;
        font-size: 27px;
        font-family: 'Poppins', sans-serif;
      }

      .big-text span{
        color: #ff004f;
        font-size: 30px;
      }
      .btn {
        font-size: 18px;
        font-weight: 400;
        border-radius: 15px;
        outline: none;
        width: 100px;
        margin: 20px 120px;
      }
      .container-lg{
        margin-top: 150px;
      }
      .container-lg .big-head{
        margin-top: 80px;
      }
      #login {
        font-family: 'Poppins', sans-serif;
      }
      .modal-footer .btn{
        margin: 20px;
      }
      .row a{
        color: #ff004f;
      }
      #adminlogin {
        font-family: 'Poppins', sans-serif;
      }
      .container-lg .text-head{
        font-size: 15px;
      }
      .big-head a{
        background-color:#68c9d0;
        color: #fff;
        transition: box-shadow 0.3s ease;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }
      .big-head a:hover {
      /* Apply the shadow effect when hovering */
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
    }
      
      
      
    </style>
  </head>
  <body class="bg-light">
    
    <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
  ></script>    
  <header>
      <!--Navbar-->
      <div>
        
      <nav
        class="navbar fixed-top navbar-expand-sm navbar-dark p-md-1 shadow" style="background-color: #68c9d0;"
      >
        <div class="container-fluid">
        <h5>Pm E-Voting System</h5>          
        <button
          class="navbar-toggler shadow-sm mb-1"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
          
          <div class="collapse navbar-collapse" id="navbarNav">
            <div class="mx-auto"></div>
            <ul class="navbar-nav mt-2 mb-3">
              <li class="nav-item">
                <a href="Homepage.php" class="active nav-link">HOME</a>
              </li>
              <li class="nav-item">
                <a href="Our Services.html" class="nav-link">SERVICES</a>
              </li>
              <li class="nav-item">
                <a href="Contact.php" class="nav-link">CONTACT</a>
              </li>
              <li class="nav-item">
                <a href="About Us.html" class="nav-link">ABOUT US</a>
              </li>
              <li class="nav-item">
                <a href="users.php" class="nav-link"><i class="fa-solid fa-user mx-1" aria-hidden="true"></i>USERS</a>
              </li>
              <div>
              </div>
            </ul>
          </div>
        </div>
      </nav>
      </div>
    </header>


    <div class="container-lg">
      <div class="row">
        <div class="big-head col-sm-6">
          <h6 class="text-head display-6">Pm Tech Solutions</h6>

        <p class="big-text text display-6 fw-normal">
          <span>Hello,</span> <br />Welcome to Pm E-Voting System web....
        </p>
        <p class="para ln-base">Do You Want to cast Votes and View Aspirant Results? <b class="fw-bold" style="color:#68c9d0";>Sign In Now</b></p>
        <a class="btn" href="StudentCast_View.php">Sign In</a>
        </div>
        
        <div class="sideimg col-sm-6">
          <img src="images/side img.png">
  
        </div>
      </div>
    </div>

  </body>
</html>

<?php
include "scripts.php";
?>






