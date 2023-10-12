<?php
	require('db.php');
	session_start();
	
	function authentication($type_of_user, $userId, $username, $password,$con)
	{
		$username = strtolower($username);
		$query = "SELECT * FROM Login WHERE username='$username' and password='".md5($password)."'";
		$result = mysqli_query($con,$query);// or die(mysql_error());
		$rows = mysqli_num_rows($result);
		
		if($rows==1)
		{
            if($type_of_user=="labtech")
			{
				$_SESSION['status']="Active";
				$_SESSION['username'] = $username;
				header("Location: labtech/labtechMain.php"); // Redirect user to admin/admin.html
			}
			
			else if($type_of_user=="doctor")
			{
				$_SESSION['status']="Active";
				$_SESSION['username'] = $username;
				header("Location: doctor/doctorMain.php"); // Redirect user to teacher/teacher.php
			}
			
			else if($type_of_user=="reception")
			{
				$_SESSION['status']="Active";
				$_SESSION['username'] = $username;
				header("Location: reception/receptionMain.php"); // Redirect user to student/student.php
			}
		
			else
				echo "<h3>Username/password is incorrect.</h3><br/>Click here to <a href='index.html'>Login</a></div>";
		}
		
		else
			echo "<h3>Username/password is incorrect.</h3><br/>Click here to <a href='index.html'>Login</a></div>";
	}
	
	
	if(isset($_POST['username'])){
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
	
		//authentication
		if(($_POST['submit'])=="reception login")
			authentication("reception","receptionId",$username,$password,$con);
			
		elseif(($_POST['submit'])=="doctor login")
			authentication("doctor","doctorId",$username,$password,$con);
			
		elseif(($_POST['submit'])=="labtech login")	
            authentication("labtech","labtechId",$username,$password,$con);
		
		else
			echo "<h3>Username/password is incorrect.</h3><br/>Click here to <a href='index.html'>Login</a>";
	}
	
	else
		echo "<h3>Username/password is incorrect.</h3><br/>Click here to <a href='index.html'>Login</a>";
?>


