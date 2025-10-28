<?php
session_start();
include('db_conn.php');
include('scripts.php');
if(isset($_POST['input'])){

    $input = $_POST['input'];

    $query = "SELECT Agent_ID, Agent_Availability FROM polling_agent WHERE Agent_ID LIKE '{$input}%'";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){?>
    <table class="table table-responsiver table-hover mt-4">
       
            <?php

            while ($row = mysqli_fetch_assoc($result)){
                $_SESSION['Agent_ID'] = $row['Agent_ID'];
                $_SESSION['Agent_Availability'] = $row['Agent_Availability'];
                

                ?>
                <tr>
                <td>
                    <a class="text-decoration-none text-black" href="Chat_ECpage.php?content=<?php echo urlencode($row['Agent_ID']); ?>">
                        <?php echo $row['Agent_ID'] ?></td>
                     <?php
                     if ($_SESSION['Agent_Availability'] == "Online"){
                        ?>
                        <td class="text-success fw-bold" style="text-align: right;"><span class="spinner-grow spinner-grow-sm mx-1 fs-6" role="status" aria-hidden="true"></span><?php echo $_SESSION['Agent_Availability'];?></td>
                        <?php
                     } else{
                        ?>
                        <td class="fw-bold text-muted"  style="text-align: right;"><i class="fa fa-circle text-muted mx-1" style="font-size:14px;"></i><?php echo $_SESSION['Agent_Availability'];?></td>
                        <?php
                     }
                     ?>
                </tr>

                <?php
            }
            ?>
        </tbody>
    </table>

    <?php

    }else{
        echo "<h6 class='text-danger text-center mt-3'> No data Found</h6>";
    }
}

?>