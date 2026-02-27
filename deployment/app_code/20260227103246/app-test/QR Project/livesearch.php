<?php
session_start();
include('db_conn.php');
include('alert.php');

?>
<style>

</style>
<?php

if(isset($_POST['input'])){

    $input = $_POST['input'];

    $query = "SELECT Event_ID, Event_Name, Person_Name, Contact, Upload_Status FROM registerevent WHERE Event_ID LIKE '{$input}%' OR Event_Name LIKE '{$input}%' OR Contact LIKE '{$input}%' OR Person_Name LIKE '{$input}%' LIMIT 1";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){?>
    <table class="table table-bordered table-striped mt-4 shadow-sm">
        <thead>
            <tr>
                <th>Event ID</th>
                <th>Event Name</th>
                <th>Person's Name</th>
                <th><i class="fa-brands fa-whatsapp"></i> Contact</th>
                <th>Event File</th>   
                
            </tr>
        </thead>

        <tbody>
            <?php

            while ($row = mysqli_fetch_assoc($result)){
                $_SESSION['Event_ID'] = $row['Event_ID'];
                $_SESSION['Event_Name'] = $row['Event_Name'];
                $_SESSION['Person_Name'] = $row['Person_Name'];
                $_SESSION['Contact'] = $row['Contact'];
                $_SESSION['Upload_Status'] = $row['Upload_Status'];

                ?>
                <tr>
                    <td><?php echo $_SESSION['Event_ID'];?></td>
                    <td><?php echo $_SESSION['Event_Name'];?></td>
                    <td><?php echo $_SESSION['Person_Name'];?></td>
                    <td><a href="https://wa.me/<?php echo $_SESSION['Contact'];?>" class="text-decoration-none text-dark" target="_blank"><?php echo $_SESSION['Contact'];?></a></td>
                    <?php
                  if ($_SESSION['Upload_Status'] == "Uploaded"){
                    ?>
                    <td class="text-center"><label for="valid" class="bg-success text-white" style="border-radius: 5px;padding: 10px 15px;"><i class="fa-regular fa-circle-check fa-beat-fade"></i> Uploaded</label></td>
                    <?php
                    }else{
                        ?>
                    <td class="text-center"><label for="valid" class="bg-danger text-white" style="border-radius: 5px;padding: 9px 12px;"><i class="fa-sharp fa-regular fa-circle-xmark fa-flip"></i> Not Yet</label></td>
                        <?php
                      }
                      ?>
                </tr>

                <?php
            }
            ?>
        </tbody>
    </table>

    
    <form action="Uploadpdf_Conn.php" method="POST" enctype="multipart/form-data" class="mb-3">

    <p class="text-center mt-4 fw-bold">Select the PDF File and CLick On Upload</p>
        <div class="d-flex justify-content-center">
            <div class="row">
                <div class="col-10">
                <input type="file" name="pdfdocument" class="form-control" accept=".pdf" required>
                </div>
            </div>

            <div class="col-2">
            <button type="submit" class="btn btn-light text-light mx-2" name="uploadpdfbtn" ><i class="fa fa-upload" aria-hidden="true"></i>
        Upload</button>
            </div>
        
        </div>        
    </form>
    
    


    <!---->
    <div class="d-flex justify-content-end">
    <button type="button" class="btn btn-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    <i class="fa-solid fa-comment-sms fa-bounce text-secondary"></i>
</button>
    </div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa-solid fa-comment-sms"></i> Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-center mt-3 mb-3 mx-2" style="font-size: 18px;"><i class="fa-regular fa-paper-plane"></i> Confirm to Send <span class="fw-bold">SMS</span> to the Recipient</p>
      </div>
      <div class="modal-footer">
        <form action="sendsms_conn.php" method="post">
        <input type="hidden" name="eid" value="<?php echo $_SESSION['Contact']; ?>">
        <input type="hidden" name="pname" value="<?php echo $_SESSION['Person_Name']; ?>">
        <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-danger mx-2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Close</button>
        <button type="submit" name="smsbtn" class="btn btn-success"><i class="fa-solid fa-thumbs-up"></i> Yes, Send</button>
        </div>
        </form>

      </div>
    </div>
  </div>
</div>

    <?php

    }else{
        echo "<h6 class='text-danger text-center mt-3'> No data Found</h6>";
    }
}

?>
