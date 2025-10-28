<?php
session_start();
include('db_conn.php');
include('scripts.php');
if(isset($_POST['input'])){

    $input = $_POST['input'];

    $query = "SELECT Student_ID, Student_Name, Contact, Department FROM votersdetails WHERE Student_ID  LIKE '{$input}%' OR Student_Name  LIKE '{$input}%' OR Contact  LIKE '{$input}%' OR Department  LIKE '{$input}%' LIMIT 1";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){?>
    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>Voter ID</th>
                <th>Voter Name</th>
                <th>Contact</th>
                <th>Department</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            <?php

            while ($row = mysqli_fetch_assoc($result)){
                $_SESSION['Student_ID'] = $row['Student_ID'];
                $_SESSION['Student_Name'] = $row['Student_Name'];
                $_SESSION['Contact'] = $row['Contact'];
                $_SESSION['Department'] = $row['Department'];

                ?>
                <tr>
                    <td><?php echo $_SESSION['Student_ID'];?></td>
                    <td><?php echo $_SESSION['Student_Name'];?></td>
                    <td><?php echo $_SESSION['Contact'];?></td>
                    <td><?php echo $_SESSION['Department'];?></td>
                    <td><label for="reg" class="bg-success text-white" style="border-radius: 5px;padding: 10px 15px;"><i class="fa fa-check m-1"></i>Verified</label></td>
                </tr>

                <?php
            }
            ?>
        </tbody>
    </table>
    <form action="Registrations_Conn.php" method="POST" enctype="multipart/form-data">

    <div class="row">
        <div class="col-6">
        <p class="mb-0 text-center"><i class="fa-solid fa-user"></i><label for="validationDefault04" class="form-label fw-bold fs-6 m-2" >Select Portfolio</label></p>
           <select id="validationDefault04" class="form-select mb-2" name="position" required>
            <option selected disabled value="">~Select~</option>
            <?php include 'Portfolio_SelectConn.php'; ?>
           </select>
        </div>

        <div class="col-6">
        <p class="text-center mb-0"><i class="fa fa-file-image-o"></i><label for="upad" class="form-label fw-bold fs-6 m-2">Upload Candidate Photo</label></p>
            <input type="file" class="form-control mb-1" name="photo" id="imageInput" onchange="displayImage(event)"id="photos" accept=".PNG, JPEG, JPG" required>
            <div id="uploadnotice" class="form-text mb-3">Upload Size: eg: <span style="color:#af0000;">135px X 135px</span>. Extension: <span style="color:#af0000;">.png .JPG .jpeg</span></div>
        </div>
        
        <div class="col-6">
            <p class="text-center"><label for="" class="form-label fs-6 fw-bold">Display Of Candidate Photo: <img src="" alt="Upload Image" id="previewImage" style="width: 135px;height:135px"></label></p>
        </div>

        <div class="col-6">
        <p class="text-end"><button type="submit" name="registercanbtn" class="btn btn-primary shadow">Register</button></p>
        </div>

    </div>
    </form>

    <?php

    }else{
        echo "<h6 class='text-danger text-center mt-3'> No data Found</h6>";
    }
}

?>

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