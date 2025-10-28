<?php
include('db_conn.php');
include('scripts.php');
session_start();


if (isset($_POST['updateElection'])) {
    $ename = $_POST['ename'];
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    $stime = $_POST['stime'];
    $etime = $_POST['etime'];
    $a = rand(100000, 999999);
    $eid = "EL".$a;
    $Estatus = "Not Published";
    $Vstatus = "Closed";


    $stmt = $conn->prepare("UPDATE election_details SET Election_ID = ?, Election_Name = ?, Starting_Date = ?, Ending_Date = ?, Starting_Time = ?, Ending_Time = ?, Election_Status	= ?, Voting_Status	= ?");
    $stmt->bind_param("ssssssss", $eid, $ename, $sdate, $edate, $stime, $etime, $Estatus, $Vstatus);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Election Settings have been Updated Successfully";
        $_SESSION['status_code'] = "success";

        // Open and Close Automatically

        $query = "SELECT Election_ID, Starting_Date, Starting_Time, Ending_Time FROM election_details LIMIT 1"; // Adjust the query to select the relevant record

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $electionid = $row["Election_ID"];
            // Extract date and time values from the database
            $storedDate = $row["Starting_Date"];
            $storeStarttime = $row["Starting_Time"];
            $storedTime = $row["Ending_Time"];
            
            // Combine the stored date and time for comparison
            $storedDatetime = strtotime("$storedDate $storedTime");
            $currentDate = date("Y-m-d"); // Get the current date in the same format as storedDate
            date_default_timezone_set('Africa/Accra');
            $currentTime = date("H:i:s");

        // Compare the current date with the stored date
        if ($currentDate != $storedDate) {
            $_SESSION['status'] = "Please Set a Correct Date";
            $_SESSION['status_code'] = "error";
            header('Location: E_Settings.php');
            exit; // Stop further execution
        }else{

            if ($currentTime >= $storeStarttime && $currentTime <= $storedTime) {
                $Vstatus = "Open";
                $stmt = $conn->prepare("UPDATE election_details SET Voting_Status = ?");
                $stmt->bind_param("s", $Vstatus);
                $stmt->execute();
    
                $stmt = $conn->prepare("UPDATE voters_verifications SET Election_ID  = ?");
                $stmt->bind_param("s", $electionid);
                $stmt->execute();
    
                header('Location: E_Settings.php');
                exit; // Stop further execution
    
            } else{
                $_SESSION['status'] = "Please Check Your Starting And Ending Time";
                $_SESSION['status_code'] = "error";
                header('Location: E_Settings.php');
                exit; // Stop further execution
            }

        }
        
        
        
            
        }

        


        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "Updated Election Settings";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        $stmt->execute();

        
        header('Location: E_Settings.php');
        exit; // Stop further execution
    } else {
        $_SESSION['status'] = "Election Settings not Updated Successfully";
        $_SESSION['status_code'] = "error";
        header('Location: E_Settings.php');
        exit; // Stop further execution
    }
}

// Delete Election details
if (isset($_POST['electioniddelete'])) {
    $eid = $_POST['deleteelection'];

    $eid = "EL000000";
    $ename = "Election Name...";
    $sdate = "2023-06-01";
    $edate = "2023-06-01";
    $stime = "00:00:00";
    $etime = "00:00:00";
    $Estatus = "Not Published";
    $Vstatus = "Closed";

    $query = "UPDATE election_details SET Election_ID = '$eid', Election_Name = '$ename', Starting_Date = '$sdate', Ending_Date = '$edate', Starting_Time = '$stime', Ending_Time = '$etime', Election_Status = '$Estatus', Voting_Status = '$Vstatus'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $stmt = $conn->prepare("UPDATE voters_verifications SET Election_ID  = ?");
        $stmt->bind_param("s", $eid);
        $stmt->execute();

        $_SESSION['status'] = "Election Info Deleted Successfully";
        $_SESSION['status_code'] = "success";

        // Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "Deleted Election Setting";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        $stmt->execute();
        header('Location: E_Settings.php');
    } else {
        $_SESSION['status'] = "Election Info Not Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: E_Settings.php');
    }
}

// Open and Close Voting 

if (isset($_POST['openvotebtn'])) {
    $Vstatus = "Open";


    $stmt = $conn->prepare("UPDATE election_details SET Voting_Status = ?");
    $stmt->bind_param("s", $Vstatus);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Voting Period is Open Successfully";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "Open Voting";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        $stmt->execute();

        header('Location: E_Settings.php');
        exit; // Stop further execution
    } else {
        $_SESSION['status'] = "Voting Period Not Open";
        $_SESSION['status_code'] = "error";
        header('Location: E_Settings.php');
        exit; // Stop further execution
    }
}

    if (isset($_POST['closevotebtn'])) {
        $Vstatus = "Closed";
        
        // Compile the Overall Result
        $sql = "SELECT * FROM candidate_result";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Access individual columns
            $studentID = $row["Student_ID"];
            $totalVotes = $row["Total_Votes"];
            $VoteNo = $row["Voted_No"];
            $totalVoters = $row["Total_Voters"];
            
            // Calculate the percentage (make sure to handle division by zero)
            if ($totalVoters != 0) {
                $votePercentage = ($totalVotes / $totalVoters) * 100;
                $voteNoPercentage = ($VoteNo / $totalVoters) * 100;
            } else {
                $votePercentage = 0;
                $voteNoPercentage = 0;
            }
            
            // Update the Votes_Percentage column in the same row
            $updateSql = "UPDATE candidate_result SET Votes_Percentage = ?, Voted_No_Percentage = ? WHERE Student_ID = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("dds", $votePercentage, $voteNoPercentage, $studentID);
            $updateStmt->execute();
            
        }
    }

    $stmt = $conn->prepare("UPDATE election_details SET Voting_Status	= ?");
    $stmt->bind_param("s", $Vstatus);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Voting Period Closed❌";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "Voting Closed";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        $stmt->execute();

        header('Location: E_Settings.php');
        exit; // Stop further execution
    } else {
        $_SESSION['status'] = "Voting Period Not Closed";
        $_SESSION['status_code'] = "error";
        header('Location: E_Settings.php');
        exit; // Stop further execution
    }
}



?>