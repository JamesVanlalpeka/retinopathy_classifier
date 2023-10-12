<?php
    require('../db.php');
    session_start();
    if($_SESSION['status']!="Active")
    {
        header("location:../index.html");
    }

    $image = $_POST['image'];
    $pId = $_POST['pId'];

    $uploadQuery = "upload into record(lab_technician_id) values('LT1') where patient_id = '$pId'";
    mysqli_query($con, $patientDetailQuery);




?>
