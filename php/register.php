<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

/**not checking if they are logged in
if($reg_user->is_logged_in()!="")
{
 $reg_user->redirect('home.php');
}
*/

//if user clicks "Complete Registration" button
if(isset($_POST['btn-register']))
{
 $ufname = trim($_POST['txtufname']);
 $ulname = trim($_POST['txtulname']);
 $email = trim($_POST['txtemail']);
 $upass = trim($_POST['txtpass']);
 
 $stmt = $reg_user->runQuery("SELECT * FROM tblUsers WHERE userEmail=:email_id");//check if email is already registered
 $stmt->execute(array(":email_id"=>$email));
 
 //if email is registered then do if statement else register the user
 if($stmt->rowCount() > 0)
 {
    $msg = "
        <div class='alert alert-error'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong>  email allready exists , Please Try another one
     </div>
     ";
 }
 else
 {
  if($reg_user->register($ufname,$ulname,$email,$upass))//register user
  {   
   echo "Registration complete"; //if registration goes well, should redirct to sign in page
  }
  else //if DB throws exception
  {
   echo "sorry , Query could no execute...";
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
    <?php if(isset($msg)) echo $msg;  ?>
      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Register</h2><hr />
        <input type="text" class="input-block-level" placeholder="First name" name="txtufname" required />
        <input type="text" class="input-block-level" placeholder="Last name" name="txtulname" required />
        <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
        <input type="password" class="input-block-level" placeholder="Password" name="txtpass" required />
      <hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-register">Complete Registration</button>
        <a href="login.php" style="float:right;" class="btn btn-large">Login</a>
      </form>

    </div> <!-- /container -->
  </body>
</html>