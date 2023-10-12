<?php
    require('../db.php');
    session_start();
    if($_SESSION['status']!="Active")
    {
        header("location:../index.html");
    }
?>

<!DOCTYPE html>
<html>
<head>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <link rel="stylesheet" href="../style1.css">


    <style>
    
        /* Style for the page container */
        .page-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        /* Style for the header */
        h1 {
            color: #007bff;
        }

        /* Style for the patient form */
        .patient-form {
            margin-bottom: 20px;
        }

        /* Style for the patient details table */
        .patient-details {
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
            border-collapse: collapse;
            text-align: left;
        }

        .patient-details td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        /* Style for the image upload form */
        .image-form {
            margin: 20px auto;
            text-align: center;
        }

        .image-form label {
            display: block;
            margin-bottom: 10px;
        }

        .image-form input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .image-form button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

      

    
    </style>

    <!-- <script>

        function SubmitFormData() {
            var image = $("#leftEyeImg").val();
            var pId = $("#pId").val();
            
            console.log(image);
            console.log(pId);
            console.log("Hello world!");

            $.post("uploadimage.php", { image: image, pId: pId },
                function(data) {
                    // $('#results').php(data);
                    $('#leftEyeForm')[0].reset();
                }
            );
        }
    </script> -->

    <script>
        $("#submit").click( function() {
        
            $.post( $("#leftEyeForm").attr("action"),
            $("#leftEyeForm :input").serializeArray(),
                function(info) {
            
                    $("#response").empty();
                    $("#response").html(info);
                
                }
            );
        
            $("#leftEyeForm").submit( function() {
                return false;  
            });
        });
    
    </script>


</head>
<body>
    <div class="page-container">
        <h1>Lab Technician</h1>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="patient-form">
            <label for="pId">Enter Patient ID:</label>
            <input type="text" id="pId" name="pId">
            <input type="submit" name="submit" value="Submit"> 
        </form>

        <?php
            if(isset($_POST["submit"])){
                $patientId = $_POST['pId'];
                $patientDetailQuery = "select * from patient INNER JOIN record on patient.p_id = record.patient_id where record.patient_id= '$patientId'";
                $patientDetail = mysqli_query($con, $patientDetailQuery);

                if($row = mysqli_fetch_array($patientDetail)){
                    $pId = $row['p_id'];
                    $fname = $row['fname'];
                    $lname = $row['lname'];
                    $contact = $row['contact'];
                    $dob = $row['dob'];
                    $gender = $row['gender'];
                    $address = $row['address'];

                    echo "<table class='patient-details'>";
                        echo "<tr><td>Name:</td><td>$fname $lname</td></tr>";
                        echo "<tr><td>Contact:</td><td>$contact</td></tr>";
                        echo "<tr><td>Date of Birth:</td><td>$dob</td></tr>";
                        echo "<tr><td>Gender:</td><td>$gender</td></tr>";
                        echo "<tr><td>Address:</td><td>$address</td></tr>";
                    echo "</table>";


                    // form to diagnostic left eye ctc image
                    echo "<form action='#' method='post' id='leftEyeForm' class='image-form' enctype='multipart/form-data'>";
                        echo "<label for='leftEyeImg'>Select Left-eye image:</label>";
                        echo "<input type='file' name='uploadfile' value='' />";
                        echo "<input type='hidden' name='pId' value='$pId'>";
                        echo "<button type='submit'>Diagnostic</button>";
                        echo "<div id='error_msg'></div>";
                    echo "</form>";
                    echo"<div id='results'>";
                    echo"    </div>";

                    // form to diagnostic right eye ctc image
                    echo "<form action='#' method='post' id='rightEyeForm' class='image-form' enctype='multipart/form-data'>";
                        echo "<label for='rightEyeImg'>Select Right-eye image:</label>";
                        echo "<input type='file' name='rightEyeImg'>";
                        echo "<input type='hidden' name='pId' value='$pId'>";
                        echo "<button type='submit'>Diagnostic</button>";
                        echo "<div id='error_msg'></div>";
                    echo "</form>";
                    echo"<div id='results'>";
                    echo"    </div>";
                } else {
                    echo "Patient is not registered for CTC scan.";
                }
            }


         

        ?>

        <br>
        <br>
            <a href="../logout.php"><button>Logout</button></a>

    </div>
</body>
<script src="action.js"></script>

</html>
