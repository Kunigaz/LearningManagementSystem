<?php
session_start(); 
require_once 'class.user.php';
$user_home = new USER();

/**not checking login right now
if(!$user_home->is_logged_in())
{
 $user_home->redirect('index.php');
}*/

$stmt = $user_home->runQuery("SELECT * FROM tblUsers WHERE userID=:uid AND userIDPrefix=900");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<!-- Student view -->

<html>
  <head>
    <meta charset = "utf-8">
	<title>Student</title>
  </head>

  <body>
    <h1>I'm the student's home page</h1>
    <p>
	Display courses > assignments > grades <br>
	Option to add/drop courses <br>
	</p>
  </body>
</html>