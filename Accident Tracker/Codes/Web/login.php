<?php
$Email=$_POST['Email'];
$Password=$_POST['Password'];





	$con=mysqli_connect("localhost","id6924693_test123","admin123","id6924693_test");
	if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    //you need to exit the script, if there is an error
    exit();
}
	$result=mysqli_query($con,"SELECT * FROM `login` WHERE `Email`='$Email' && `Password`='$Password' ");
	$count=mysqli_num_rows($result);
	echo $count;
		if ($count==1) {
			echo "login success";
		include_once 'dashboard.html';
		}
		else
		{
	        echo " ";
		include_once 'loginuser.php';
	
		}
?>