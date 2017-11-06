<?php
//code from codingcage.com

//header, includes the DB connect configuration (dbconfig.php)
require_once 'dbconfig.php';

class USER
{ 

 private $conn;
 
 //connect to the DB
 public function __construct()
 {
  $database = new Database();
  $db = $database->dbConnection();
  $this->conn = $db;
 }
 
 //execute query
 public function runQuery($sql)
 {
  $stmt = $this->conn->prepare($sql);
  return $stmt;
 }
 
 //returns row id of last row inserted into DB
 public function lasdID()
 {
  $stmt = $this->conn->lastInsertId();
  return $stmt;
 }
 
 //register new user
 public function register($ufname,$ulname,$email,$upass)
 {
  try
  {       
   $password = md5($upass); //turns password into hash

   //"prapares" SQL statement for later use
   $stmt = $this->conn->prepare("INSERT INTO tblUsers(userFirstName,userLastName,userEmail,userPass) 
                                                VALUES(:user_fname, :user_lname, :user_mail, :user_pass)");
   
   //binds the php variables passed through function to our SQL defined placeholders above
   $stmt->bindparam(":user_fname",$ufname);
   $stmt->bindparam(":user_lname",$ulname);
   $stmt->bindparam(":user_mail",$email);
   $stmt->bindparam(":user_pass",$password);
   $stmt->execute(); //executes the previously "prepared" SQL
   return $stmt;
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }
 
 //function called when user trys to login
 public function login($email,$upass)
 {
  try
  {
   //prepare SQL statement
   $stmt = $this->conn->prepare("SELECT * FROM tblUsers WHERE userEmail=:email_id");
   $stmt->execute(array(":email_id"=>$email));
   $userRow=$stmt->fetch(PDO::FETCH_ASSOC); //returns the array indexed by column name as returned in $stmt
   
   if($stmt->rowCount() == 1)
   {
        if($userRow['userPass']==md5($upass)) //checks against the hash created at registration
        {
          $_SESSION['userType'] = $userRow['userIDPrefix']; //needed to specify the users permissions
          $_SESSION['userSession'] = $userRow['userID']; //sets session variable, can be used to verify user is logged in
          return true;
        }
        else
        {
          echo "Wrong password";
          exit;
        }
   }
   else
   {
     echo "Error";
     exit;
   }  
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }
 
 /* 
 public function is_logged_in()
 {
  if(isset($_SESSION['userSession']))
  {
   return true;
  }
 }
 */
 
 public function redirect($url)
 {
  header("Location: $url");
 }
 
 public function logout()
 {
  session_destroy();
  $_SESSION['userSession'] = false;
 }
 
 function send_mail($email,$message,$subject)
 {      
  require_once('mailer/class.phpmailer.php');
  $mail = new PHPMailer();
  $mail->IsSMTP(); 
  $mail->SMTPDebug  = 0;                     
  $mail->SMTPAuth   = true;                  
  $mail->SMTPSecure = "ssl";                 
  $mail->Host       = "smtp.gmail.com";      
  $mail->Port       = 465;             
  $mail->AddAddress($email);
  $mail->Username="yourgmailid@gmail.com";  
  $mail->Password="yourgmailpassword";            
  $mail->SetFrom('you@yourdomain.com','Coding Cage');
  $mail->AddReplyTo("you@yourdomain.com","Coding Cage");
  $mail->Subject    = $subject;
  $mail->MsgHTML($message);
  $mail->Send();
 }
}