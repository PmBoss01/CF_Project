<?php
session_start();
include "db_conn.php";
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

    <title>Admin Dashbard | Event Details</title>
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
      .text-img img{
        height: 350px;
      }
      .text-uploadimg img{
        height: 135px;
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
      <a href="Eventsinfo.php" class="active mb-1"
        ><i class="fa-solid fa-registered"></i
      ></a>
      <a href="qrCodeGenerator.php"><i class="fa-solid fa-qrcode"></i></a>
    </div>

    <div class="content">
      <div class="custom-shape shadow" style="font-size: 20px">
        <i class="fa-solid fa-user-shield fs-4"></i> Administator Dashboard
      </div>
    </div>

    <p class="text-center mt-3 fw-bold" style="font-size: 20px">
      <i class="fa-solid fa-clipboard-list mx-1"></i>List Of All The Events
      Registered
    </p>

    <!---------->

    <div>
    <table class="container table table-striped table-hover shadow mt-4 mb-5">
        <?php
        include('db_conn.php');
        $query = "SELECT * FROM registerevent";
        $query_run = mysqli_query($conn, $query);
        ?>
        <thead>
            <tr>
                <th>Event ID</th>
                <th>Event Name</th>
                <th>Person's Name</th>
                <th>Event Image</th>
                <th>Event Time</th>
                <th>Event Date</th>
                <th>View Upload</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>

        <tbody>
            <?php
            if (mysqli_num_rows($query_run) > 0) {
                while ($row = mysqli_fetch_assoc($query_run)) {
                    $img = $row['Photo'];
                    $_SESSION['eid'] = $row['Event_ID'];
            ?>
                    <tr>
                        <td><?php echo $row['Event_ID'] ?></td>
                        <td><?php echo $row['Event_Name'] ?></td>
                        <td><?php echo $row['Person_Name'] ?></td>
                        <td>
                            <a class="btn text-dark" name="showImagebtn" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['Event_ID']; ?>">Show Image <i class="fa-solid fa-images fa-beat-fade"></i></a>
                        </td>
                        <td><?php echo $row['Event_Time'] ?></td>
                        <td><?php echo $row['Event_Date'] ?></td>
                        <td>
                        <a href="EventPDF.php?event_id=<?php echo $row['Event_ID']; ?>" class="text-dark text-decoration-none" target="_blank">
                            <i class="fa-solid fa-eye"></i> View PDF
                        </a>
                    </td>
                        <td>
                            <button type="button" class="btn bg-success text-light" data-bs-toggle="modal" data-bs-target="#exampleModalToggle<?php echo $row['Event_ID']; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                            </button>
                        </td>
                        <td>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $row['Event_ID']; ?>" class="btn bg-danger text-light">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal<?php echo $row['Event_ID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-images"></i> Event Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                
                                <p class="text-center mb-2"><i class="fa-solid fa-images"></i> Image Of: <span class="fw-bold"><?php echo $row['Event_Name'] ?></span></p>
                                <p class="text-center text-img"><?php echo '<img src="data:image/png;base64,' . base64_encode($img) . '" alt="Image">'; ?></p>
              
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Modal For Update-->
                    <form action="UpdateEventInfo_Conn.php" method="post" enctype="multipart/form-data">
                    <div class="modal fade" id="exampleModalToggle<?php echo $row['Event_ID']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalToggleLabel"><i class="fa-solid fa-user-pen"></i> Update Event Info</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <div class="row">
                        <p class="text-center mb-0 border p-2"><label for="ano" class="form-label fw-bold text-muted fs-6 mb-2 m-2">-- Event ID: <span class="text-success"><?php echo $row['Event_ID'] ?></span>--</label></p>

                        <div class="col-12">
                        <i class="fa fa-pen"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Name Of The Event</label>
                        <input type="text" class="form-control mb-1" id="Nevent" name="ename" value="<?php echo $row['Event_Name']?>" autocomplete="off">
                          
                        </div>
                                <div class="col-8">
                                    <i class="fa fa-user"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Name Of Person</label>
                                    <input type="text" class="form-control text-center mb-2" id="person" name="nperson" value="<?php echo $row['Person_Name']?>" autocomplete="off">
                                </div>
                
                                <div class="col-4">
                                    <i class="fa fa-whatsapp"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Contact</label>
                                    <input
                                  type="phonenumber"
                                  class="form-control text-center mb-2"
                                  id="validationDefault03"
                                  name = "fphone"
                                  oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                  value="<?php echo $row['Contact']?>"
                                  maxLength="10"
                                  autocomplete="off"
                                />
                                </div>

                                <div class="col-7">
                                  <i class="fa fa-picture-o"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Upload Event Image</label>
                                  <input type="file" class="form-control mb-2" name="photo" id="imageInput<?php echo $row['Event_ID']; ?>" data-event-id="<?php echo $row['Event_ID']; ?>" onchange="displayImage(event)" accept=".PNG, .JPG, .JPEG">
                                </div>

                                <div class="col-5">
                                    <i class="fa fa-address-book-o"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Specify Gender</label>
                                    <select class="form-select mb-2" name="gender">
                                        <option selected value="<?php echo $row['Gender']?>">Chosen: <?php echo $row['Gender']?></option>                        
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Custom">Custom</option>
                                      </select>
                                </div>

                                <div class="col-6">
                                    <i class="fa fa-clock"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Event Time</label>
                                    <input type="time" class="form-control" name="time" value="<?php echo $row['Event_Time'] ?>">
                                </div>
                
                                <div class="col-6">
                                    <i class="fa fa-calendar-o"></i><label for="ano" class="form-label fw-bold fs-6 mb-2 m-2">Event Date</label>
                                    <input type="date" class="form-control" name="date" value="<?php echo $row['Event_Date'] ?>">
                                </div>

                                <div class="col-5">
                                <label for="ano" class="form-label fw-bold fs-6 mb-2 m-2"><i class="fa-solid fa-images"></i> Event Image</label>
                                <p class="text-center border text-uploadimg"><?php echo '<img src="data:image/png;base64,' . base64_encode($img) . '" alt="Image">'; ?></p>
                                </div>

                                <div class="col-2">
                                  <p class="text-center fs-3" style="margin-top: 95px;"><i class="fa-solid fa-right-left fa-flip"></i></p>
                                </div>


                                <div class="col-5">
                                <label for="ano" class="form-label fw-bold fs-6 mb-2 m-2 "><i class="fa-solid fa-images"></i> Event Image</label>
                                <p class="border text-center">
                                <img src="" alt="Upload Image" id="previewImage<?php echo $row['Event_ID']; ?>" style="width: 135px; height: 135px">
                                </p>
                            </div>


                      </div>
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-success" type="button" data-bs-target="#<?php echo $row['Event_ID']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fa-solid fa-user-pen"></i> Update</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--Modal 2-->
                  <div class="modal fade" id="<?php echo $row['Event_ID']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalToggleLabel2"><i class="fa-solid fa-user-pen"></i> Update Confirmation</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <p class="text-center mt-3 mb-3 mx-2" style="font-size: 17px;"> Are You Sure You Want To <span class="fw-bold">Update <i class="fa-solid fa-pen fa-shake text-success"></i></span> Event Info ?</p>
                        </div>
                        <div class="modal-footer">
                          <input type="hidden" name="Updateid" value="<?php echo $row['Event_ID']; ?>">
                        <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Close</button>
                        <button type="submit" name="eventupdatebtn" class="btn btn-success"><i class="fa-solid fa-user-pen"></i> Yes, Update</button>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  </form>

                  <!--Delete Confirmation-->
                  <!-- Modal -->
              <div class="modal fade" id="staticBackdrop<?php echo $row['Event_ID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel"><i class="fa-solid fa-trash"></i> Confirmation</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <p class="text-center mt-3 mb-3 mx-2" style="font-size: 17px;"> Are You Sure You Want To <span class="fw-bold">Delete <i class="fa-solid fa-trash fa-bounce text-danger"></i></span> Event Info ?</p>
                    </div>
                    <div class="modal-footer">
                    <form action="deleteEvent_conn.php" method="post">
                    <input type="hidden" name="deleteid" value="<?php echo $row['Event_ID']; ?>">
                      <div class="d-flex justify-content-end">
                      <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Close</button>
                      <button type="submit" name="eventdeletebtn" class="btn btn-danger"><i class="fa-solid fa-thumbs-up"></i> Yes, Delete</button>
                      </div>
                      </form>

                    </div>
                  </div>
                </div>
              </div>


            <?php
                }
            } else {
            ?>
                <tr>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                    <td>No Records</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    function displayImage(event) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function() {
        var imgElement = document.getElementById('previewImage' + input.dataset.eventId);
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
include('alert.php');
?>
