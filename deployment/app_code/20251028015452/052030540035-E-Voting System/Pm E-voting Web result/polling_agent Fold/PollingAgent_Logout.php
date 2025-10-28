<?php
session_start();
include "db_conn.php";
if ($data = $_GET['data']){
    
    $offline = "Offline";
    $agentid = $_SESSION['Agent_ID'];
    $agentpass = $_SESSION['Agent_Password'];

    $stmt = $conn->prepare("UPDATE polling_agent SET Agent_Availability = ? WHERE Agent_ID = ? AND Agent_Password = ?");
    $stmt->bind_param("sss", $offline, $agentid, $agentpass);

    if ($stmt->execute()) {
        header("Location: ../polling_agent.php");
        exit; // Stop further execution
    } else {
      echo '';
    }
    
    }

session_unset();
session_destroy();

