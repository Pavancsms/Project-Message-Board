<?php
session_start();
?>
<html>
<head><title>Register</title>
<style type="text/css">
    html {
    background-color:#888888;
    }	
	fieldset {
	background-color:#505050;
	color:white;
	}
	a {
	color :#F00000 ;
	}
	form {
        width: 500px;
        clear: both;
    }
   input {
        width: 100%;
        clear: both;
    }
</style>
</head>
<body>

<form method="GET" action="register.php">
<fieldset>
<legend><b>Register:</b></legend>
<label><b>User Name:</b>
<input type ="text" name="userName"/>
</label>
<br/>
<label><b>Full Name:</b>
<input type ="text" name="fullName"/>
</label>
<br/>
<label><b>Email:</b>
<input type ="text" name="email"/>
</label>
<br/>
<label><b>Password:</b>
<input type="password" name="password"/>
</label>
<br/>
<br/>
<input type="submit" value="Register" name="register"/>
</fieldset>
</form>

<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
if(isset($_GET['register'])){
	$userName = $_GET['userName'];
	$fullName = $_GET['fullName'];
	$email = $_GET['email'];
	$password = md5($_GET['password']);
	try{
		$dbname = "C:/wamp/www/project4/mydb.sqlite";
		$dbh = new PDO("sqlite:$dbname");
		$dbh->beginTransaction();
		$dbh->exec("insert into users values('$userName','$password','$fullName','$email')")
				or die(print_r("Error! UserName already taken please select a different username", true));
		header("Location:login.php");
		exit;
		$dbh->commit();
		}catch(PDOException $e){
		print "Error!: " . $e->getMessage() . "<br/>";
		  die();
		}
}
?> 
</body>
</html>
