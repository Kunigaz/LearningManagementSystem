<?php
//ty codingcage.com
session_start();
require_once 'class.dbfunct.php';
$user_login = new DBFUNCT();

if(isset($_POST['btn-login']))
{
    $email = trim($_POST['email']);
    $upass = trim($_POST['password']);
    
    if($user_login->login($email,$upass))
    {
        $idType = $_SESSION['userType'];
        
        switch($idType)
        {
            case "000":
                header("Location: ../adminview.html");
                break;
            case "100":
                header("Location: instructor.php");
                break;
            case "900":
                header("Location: ../studentview.html");
                break;
            default:
                echo "Please login back in.";
        }
    }else
    {
        header('Location: ../index.html');
    }
}
?>