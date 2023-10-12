<?php

    require('../db.php');
    session_start();
    if($_SESSION['status']!="Active")
    {
        header("location:../index.html");
    }

    extract($_POST);

    if(isset($_POST["uploadfile"])){
            $filename = $_FILES['uploadfile']['name'];
            $pId = $_POST['pId'];
            echo"$filename";
            echo"$pId";
    }else{
        echo"<p style='color:red;'>Severe diabetic retinopathy</p>";

        $insertLeftCTCResultQuery = "update record set left_eye_result = 'Severe diabetic retinopathy' where patient_id = '$pId'";
        mysqli_query($con, $insertLeftCTCResultQuery);
    }
 


?>