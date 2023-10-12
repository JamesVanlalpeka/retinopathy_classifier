<!DOCTYPE html>
<html>

<head>
    <title>Receptionist Interface</title>


        <link rel="stylesheet" href="../style1.css">

    <style>

        

        h1 {
            text-align: center;
        }

        form {
            max-width: 35%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 90%;
            padding: 10px 10px;
            
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        select {
            height: 36px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
        }

       

        a {
            display: block;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>ADD THE PATIENTS DETAILS</h1>
    <?php
    require('../db.php');
    session_start();
    if ($_SESSION['status'] != "Active") {
        header("location:../index.html");
    }

    if (isset($_POST["submit"])) {
        $fname = $_POST["fn"];
        $lname = $_POST["ln"];
        $contactNum = $_POST["contact"];
        $dob = $_POST["dob"];
        $gender = $_POST["gender"];
        $address = $_POST["address"];
        $doctorName = $_POST["doctorName"];

        // Extracting doctor first name and last name from variable $doctorName into array index 0 and 1
        $doctorFandLName = array();
        $token = strtok($doctorName, " ");
        $i = 0;

        while ($token !== false) {
            $doctorFandLName[$i] = $token;
            $i++;
            $token = strtok(" ");
        }

        // Code to get the doctor id using doctor name for foreign key in patient table
        $doctorID = mysqli_query($con, "select emp_id from doctor where fname = '$doctorFandLName[0]' and lname = '$doctorFandLName[1]'");
        $docId = mysqli_fetch_array($doctorID);

        // Code to get the number of rows from the patient table to calculate the patient ID.
        $queryCountPatientRow = mysqli_query($con, "select * from patient");
        $rowcount = mysqli_num_rows($queryCountPatientRow);
        $rowcount = $rowcount + 1;
        $pID = "P" . $rowcount;

        $insertPatientQuery = "INSERT INTO patient values('$pID', '$fname', '$lname', '$contactNum', '$dob', '$gender', '$address', '$docId[0]')";

        mysqli_query($con, $insertPatientQuery);
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="fn">First name:</label>
        <input type="text" id="fn" name="fn" required>

        <label for="ln">Last Name:</label>
        <input type="text" id="ln" name="ln" required>

        <label for="contact">Contact:</label>
        <input type="number" id="contact" name="contact" required>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Others">Others</option>
        </select>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>

        <label for="doctorName">Select Doctor:</label>
        <select id="doctorName" name="doctorName" required>
            <!-- PHP function for retrieving doctor name in HTML select tag -->
            <?php
            mysqli_select_db($con, "retinopathydb");
            $result = mysqli_query($con, "SELECT fname, lname from doctor");

            while ($row = mysqli_fetch_array($result)) {
                echo "<option>" . $row['fname'] . " " . $row['lname'] . " </option>";
            }
            ?>
        </select>

        <input type="submit" name="submit" value="Submit" />
        <input type="reset" value="Reset">
    </form>

    <br>
    <br>
    <a href="../logout.php"><button>Logout</button></a>
</body>

</html>
