<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

/**not verifying the user is logged in until the rest of the app is functioning**
if($user_login->is_logged_in()!="")
{
 $user_login->redirect('home.php');
}
*/

if(isset($_POST['btn-login']))
{
 $email = trim($_POST['txtemail']);
 $upass = trim($_POST['txtupass']);
 
 if($user_login->login($email,$upass))
 {
   $idType = $_SESSION['userType'];

   switch($idType)
   {
      case "000":
         $user_login->redirect('adminview.php');
         break;
      case "100":
         $user_login->redirect('staffview.php');
         break;
      case "900":
         $user_login->redirect('studentview.php');
         break;
      default:
         echo "Please login back in.";
   }
 }
}
?>

<!DOCTYPE html>
<html>
  <head>
    
  </head>
  <body id="login">
    <div class="container">
  <?php 
  if(isset($_GET['inactive']))
  {
   ?>
            <div class='alert alert-error'>
    <button class='close' data-dismiss='alert'>&times;</button>
    <strong>Sorry!</strong> This Account is not Activated Go to your Inbox and Activate it. 
   </div>
            <?php
  }
  ?>
        <form class="form-signin" method="post">
        <?php
        if(isset($_GET['error']))
  {
   ?>
            <div class='alert alert-success'>
    <button class='close' data-dismiss='alert'>&times;</button>
    <strong>Wrong Details!</strong> 
   </div>
            <?php
  }
  ?>
        <h2 class="form-signin-heading">LogIn.</h2><hr />
        <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
        <input type="password" class="input-block-level" placeholder="Password" name="txtupass" required />
      <hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-login">Login</button>
        <a href="register.php" style="float:right;" class="btn btn-large">Register</a><hr />
        <a href="fpass.php">Lost your Password ? </a>
      </form>

    </div> <!-- /container -->
  </body>
</html>