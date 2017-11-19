<?php
//ty codingcage.com

session_start();
require_once 'class.dbfunct.php';

$reg_user = new DBFUNCT();

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
        $msg = "<div class='alert alert-error'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Sorry !</strong>  email allready exists , Please Try another one
                </div>";
        }
    else
    {
        if($reg_user->register($ufname,$ulname,$email,$upass))//register user
        {   
            header('Location: ../login.html'); //if registration goes well, should redirct to sign in page
        }
        else //if DB throws exception
        {
            echo "sorry , Query could no execute...";
        }  
    }
}
?>