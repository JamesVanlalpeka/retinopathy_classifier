<!DOCTYPE html>
<html>

<head>
    <title>Doctor Interface</title>
    
    <link rel="stylesheet" href="../style1.css">

    <style>
        body {
            font-family: Arial, sans-serif;
 ;
        }

        h1 {
            text-align: center;
        }

        form {
            text-align: center;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1>Doctor</h1>

    <!-- Patient ID Input Form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Enter Patient ID: <input type="text" name="pId">
        <input type="submit" name="submit" value="Submit" />
    </form>

    <?php
    require('../db.php');
    session_start();
    if ($_SESSION['status'] != "Active") {
        header("location:../index.html");
    }

    if (isset($_POST["submit"])) {
        $pId = $_POST['pId'];
        mysqli_select_db($con, "retinopathydb");
        $patientDetailQuery = "select * from patient where p_id = '$pId'";
        $patientDetail = mysqli_query($con, $patientDetailQuery);


        $recordDetailQuery = "select left_eye_result, right_eye_result from record where patient_id = '$pId'";
        $recordDetail = mysqli_query($con, $recordDetailQuery);
        while ($a = mysqli_fetch_array($recordDetail)) {
            $leftEyeResult = $a['left_eye_result'];
            $rightEyeResult = $a['right_eye_result'];
            
        }
        
        

        while ($row = mysqli_fetch_array($patientDetail)) {
            $pId = $row['p_id'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $contact = $row['contact'];
            $dob = $row['dob'];
            $gender = $row['gender'];
            $address = $row['address'];
        }
    ?>

        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Contact</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Address</th>
            </tr>
            <tr>
                <td><?php echo $fname; ?></td>
                <td><?php echo $lname; ?></td>
                <td><?php echo $contact; ?></td>
                <td><?php echo $dob; ?></td>
                <td><?php echo $gender; ?></td>
                <td><?php echo $address; ?></td>
            </tr>
        </table>
        <?php
        if($leftEyeResult != NULL){
echo "<br>";
        echo "<br>";
            echo "Left eye: $leftEyeResult";
            echo "<br>";
            echo "<br>";
            echo "Right eye: $rightEyeResult";
        }
        
        ?>
        <form action='' method='post'>
            <input type='hidden' name='pId' value='<?php echo $pId; ?>'>
            CTC Scan: <input type='checkbox' name='patientNeedCTC' value='active'>
            <input type='submit' name='submitPatientNeedCTC' value='Submit' />
        </form>

        <form action='' method='post'>
            <input type='hidden' name='pId' value='<?php echo $pId; ?>'>
            Reassign Doctor: <select name='doctorName'>
                <?php
                mysqli_select_db($con, "retinopathydb");
                $result = mysqli_query($con, "SELECT fname, lname from doctor");

                while ($row = mysqli_fetch_array($result)) {
                    echo "<option>" . $row['fname'] . " " . $row['lname'] . " </option>";
                }
                ?>
            </select>
            <input type='submit' name='submitReassignDoctor' value='Submit' />
        </form>

    <?php
    }

    if (isset($_POST['submitPatientNeedCTC']) && isset($_POST['pId'])) {
        $pId = $_POST['pId'];
        $queryCountRecordRow = mysqli_query($con, "select * from record");
        $rowcount = mysqli_num_rows($queryCountRecordRow);
        $rowcount = $rowcount + 1;
        $rID = "R" . $rowcount;
        $insertRecordQuery = "INSERT INTO record (r_id,status,patient_id) values('$rID', 'pending', '$pId')";
        mysqli_query($con, $insertRecordQuery);
        echo "Send.";
    }

    if (isset($_POST['submitReassignDoctor']) && isset($_POST['doctorName']) && isset($_POST['pId'])) {
        $doctorName = $_POST['doctorName'];
        $pId = $_POST['pId'];
        $doctorFandLName = array();
        $token = strtok($doctorName, " ");
        $i = 0;

        while ($token !== false) {
            $doctorFandLName[$i] = $token;
            $i++;
            $token = strtok(" ");
        }

        $doctorID = mysqli_query($con, "select emp_id from doctor where fname = '$doctorFandLName[0]' and lname = '$doctorFandLName[1]'");
        $docId = mysqli_fetch_array($doctorID);
        echo $docId[0];
        echo "Doctor Reassign Successful.";
        $updateDoctorQuery = "UPDATE patient set doctor_id = '$docId[0]' where p_id = '$pId'";
        mysqli_query($con, $updateDoctorQuery);
    }
    ?>

    <br>
    <br>
    
    <a href="../logout.php"><button>Logout</button></a>
</body>

</html>
