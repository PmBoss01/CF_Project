<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Serial Code</title>
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
        align-items: center;
        justify-content: center;
        min-width: 100vh;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
      }
    .signupform form{
        margin-top: 100px;
        border-radius: 20px;
    }
      
  </style>
</head>
<body>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
  ></script>

  <div class="container mt-5">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <div class="signupform">
            <form class="p-3 shadow-lg">
              <div
                class="container d-flex justify-content-center align-items-center mb-4"
              >
                <h6 class="display-6 fs-3 mt-2 mb-3fw-normal text-white">
                <i class="fa fa-check mx-2"></i>Code Verification
                </h6>
              </div>

            <div class="alert alert-success text-center" role="alert">
              <strong>Please,</strong> a code have been sent to your <strong> E-mail Address</strong>. Please, Enter the code for a new Serial Code to <strong>Sign In</strong>
            </div>

              <div class="container">
                <p class="text-center">
                <label for="email" class="form-label text-white">Enter the Code</label>
                </p>
                <input
                  type="number"
                  class="form-control text-center mb-4"
                  id="validationDefault03"
                  required
                  placeholder="Enter OPT Code"
                />

                <div
                  class="d-grid"
                >
                  <button type="submit" class="btn btn-primary shadow-lg mb-3 mt-3">
                    Submit 
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
</body>
</html>