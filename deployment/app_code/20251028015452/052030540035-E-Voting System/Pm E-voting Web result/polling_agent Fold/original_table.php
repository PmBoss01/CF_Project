<?php
include "db_conn.php";
?>
<table id="example" class="table table-responsive table-hover">
        <?php
        include('db_conn.php');
        $query = "SELECT * FROM admindetails";
        $query_run = mysqli_query($conn, $query)
        ?>
        <tbody>
            <?php
            if (mysqli_num_rows($query_run) > 0) {
                while ($row = mysqli_fetch_assoc($query_run)) {
                    $_SESSION['Admin_ID'] = $row['Admin_ID'];
                    $_SESSION['Ec_Availability'] = $row['Ec_Availability'];
                    ?>
                    <tr>
                    <td>
                    <a class="text-decoration-none text-black" href="Chat_page.php?content=<?php echo urlencode($row['Admin_ID']); ?>">
                        <?php echo $row['Admin_ID'] ?></td>
                        <?php
                        if ($_SESSION['Ec_Availability'] == "Online") {
                            ?>
                            <td class="text-success fw-bold" style="text-align: right;"><span
                                        class="spinner-grow spinner-grow-sm mx-1 fs-6" role="status"
                                        aria-hidden="true"></span><?php echo $_SESSION['Ec_Availability']; ?></td>
                            <?php
                        } else {
                            ?>
                            <td class="fw-bold text-muted" style="text-align: right;"><i
                                        class="fa fa-circle text-muted mx-1" style="font-size:14px;"></i><?php echo $_SESSION['Ec_Availability']; ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
            } else {
                echo "";
            }
            ?>
        </tbody>
    </table>

    