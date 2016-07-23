<?php
session_start();
?>
<html>
<head><title>Message Board</title>
<style type="text/css">
    table,th,td{
	    border:1.5px solid white;
		background-color:#505050;
		color:white;
		width:600px;
		
    }
    html {
    background-color:#888888;
    }	
	fieldset {
	background-color:#505050;
	color:white;
	width:600px;
	}
	a {
	color :#F00000 ;
	}
</style>
</head>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
if(isset($_GET['newMessage'])){
header("Location:http://localhost/project4/message.php");
exit;
}
if(isset($_GET['logout'])){
session_destroy();
header("Location:http://localhost/project4/login.php");
exit;
}
try {
  $dbname = "C:/wamp/www/project4/mydb.sqlite";
  $dbh = new PDO("sqlite:$dbname");
  $stmt = $dbh->prepare("select * from posts,users where posts.postedby=users.username");
  $stmt->execute();
    echo '<form method="GET" action="board.php">';
	echo '<fieldset>';
	echo '<legend><b>Message Board:</b></legend>';
	echo '<input type="submit" value="Logout" name="logout"/>';
	echo '<input type="submit" value="New Message" name="newMessage"/>';
	echo '</label>';
	echo '</fieldset>';
    echo '</form>';
	
    echo '<table>'; 
	//echo '<tr><th>Id</th><th>Message</th><th>Follows</th></tr>';
	while ($row = $stmt->fetch()) {
	  echo '<tr>';
	  echo '<td>Id: '.$row['id'].'  Follows: '.$row['follows'].'</td>';
	  echo '<td>'.$row['message'].'</br>'.$row['postedby'].'&nbsp;&nbsp'.$row['fullname'].'&nbsp;&nbsp'.$row['datetime'].'<br/>
	   <form method="GET" action="message.php">
	   <input type="submit" value="reply"/>
	   <input type="hidden" name="follows" value="'.$row['id'].'"></form></td>';
	 // <a href=http://localhost/project4/message.php?followsId='.$row['id'].'>Reply</a></td>';
	  
	 
	 // echo '<td></td>';

	  //echo '<td><a href=http://localhost/project4/message.php?followsId='.$row['id'].'>Reply</a></td>';
 	  echo '</tr>';
	}
	echo '</table>';
	
} catch (PDOException $e) {
  die();
}
?>
</body>
</html>
