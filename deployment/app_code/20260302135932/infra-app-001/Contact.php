<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pm E-Voting System Contact</title>
    <link rel="icon" href="images/Site logo.png" alt="rounded-pill" />
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
        margin: 0;
        padding: 0;
        font-family: "Poppins", sans-serif;
        box-sizing: border-box;
      }
      #contact {
        margin-top: 60px;
      }
      body {
        background: #212529;
        color: #fff;
        font-family: "Poppins", sans-serif;
      }
      .contact-left {
        flex-basis: 35%;
      }

      .contact-right {
        flex-basis: 60%;
      }
      .contact-left p {
        margin-top: 20px;
      }
      .contact-left p i {
        color: #ff004f;
        margin-right: 25px;
        font-size: 25px;
      }
      .social-icons a {
        text-decoration: none;
        font-size: none;
        font-size: 30px;
        margin-right: 15px;
        color: #ababab;
        display: inline-block;
        transition: transform 0.5s;
      }
      .social-icons a:hover {
        color: #ff004f;
        transform: translateY(-5px);
      }
      .btn.btn2 {
        display: inline-block;
        background: #ff004f;
        color: #fff;
      }
      .contact-right form {
        width: 100%;
      }
      form input,
      form textarea {
        width: 100%;
        border: 0;
        outline: none;
        background: #080808;
        padding: 15px;
        margin: 15px 0;
        color: #fff;
        font-size: 18px;
        border-radius: 6px;
      }
      form .btn2 {
        padding: 14px 60px;
        font-size: 18px;
        margin-top: 20px;
        cursor: pointer;
      }
      .copyright {
        width: 100%;
        text-align: center;
        padding: 10px 0;
        background: #080808;
        font-weight: 100;
        margin-top: 73px;
        height: 50px;
      }
      .copyright p {
        font-family: "Poppins", sans-serif;
        font-weight: 300;
      }
      .copyright i {
        color: #ff004f;
      }
      span {
        color: #ff004f;
      }
      @media only screen and (max-width: 600px) {
        .contact-left,
        .contact-right {
          flex-basis: 100%;
        }
      }
    </style>
  </head>
  <body>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <!--Contact-->
    <div id="contact">
      <div class="container">
        <div class="row">
          <div class="contact-left">
            <h1 class="sub-title">Contact <span>Us</span></h1>
            <p><i class="fas fa-paper-plane"></i>mpemboateng2580@gmail.com</p>
            <p><i class="fas fa-phone-square-alt"></i>+233 55 571 0390</p>
            <div class="social-icons">
              <a href=""><i class="fab fa-facebook"></i></a>
              <a href=""><i class="fab fa-twitter-square"></i></a>
              <a href=""><i class="fab fa-instagram"></i></a>
              <a href=""><i class="fab fa-linkedin"></i></a>
              <a href=""><i class="fab fa-whatsapp"></i></a>
            </div>
          </div>
          <div class="contact-right">
            <form name="submit-to-google-sheet">
              <input type="text" name="Name" placeholder="Your Name" required />
              <input
                type="email"
                name="Email"
                placeholder="Your Email"
                required
              />
              <textarea
                name="Message"
                rows="6"
                placeholder="Your Message"
                required
              ></textarea>
      
              <button
                type="submit"
                class="btn btn2"
                data-bs-toggle="modal"
                data-bs-target="#message"
              >
                Submit
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="copyright">
      <p>
        Copyright © 2023 Pm E-Voting System. Made with
        <i class="fas fa-heart"></i>
        by Pm Tech Solutions
      </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      const scriptURL =
        "https://script.google.com/macros/s/AKfycbx0cXriErYlj82z8aQN7KEKGEyUo-DjgkxJosT9zzxi3yxfM-A7CFzTpN83Q1M4LKGg/exec";
      const form = document.forms["submit-to-google-sheet"];

      form.addEventListener("submit", (e) => {
        e.preventDefault();
        fetch(scriptURL, { method: "POST", body: new FormData(form) })
          .then((response) => {
            Swal.fire("Success!", "Message Sent Successfully!", "success");
            updateDatabase(); // Call the function to update the database
          })
          .catch((error) => {
            console.error("Error!", error.message);
            Swal.fire("Error!", "Failed to send message.", "error");
          });

        form.reset();
      });

      function updateDatabase() {
        fetch("update_database.php") // Assuming the PHP file is named "update_database.php"
          .then((response) => {
            if (response.ok) {
              console.log("Database updated successfully.");
            } else {
              throw new Error("Database update failed.");
            }
          })
          .catch((error) => {
            console.error("Error!", error.message);
          });
      }
    </script>
  </body>
</html>
