<?php

    require('../db.php');
    session_start();
    if($_SESSION['status']!="Active")
    {
        header("location:../index.html");
    }

    extract($_POST);

    if(isset($_POST["rightEyeImg"])){
            $filename = $_FILES['rightEyeImg']['name'];
            $pId = $_POST['pId'];
            echo"$filename";
            echo"$pId";
    }else{
        echo"<p style='color:green;'>No diabetic retinopathy</p>";
        $insertRightCTCResultQuery = "update record set right_eye_result = 'No diabetic retinopathy' where patient_id = '$pId'";
        mysqli_query($con, $insertRightCTCResultQuery);
    }
 


?>