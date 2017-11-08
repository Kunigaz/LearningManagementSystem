<?php
session_start();
require_once 'class.dbfunct.php';

$admin = new DBFUNCT();

//if user clicks "Submit Registration" button
if(isset($_POST['btn-register']))
{ 
    $prefix = trim($_POST['acctType']);
    $ufname = trim($_POST['txtufname']);
    $ulname = trim($_POST['txtulname']);
    $email = trim($_POST['txtemail']);
    $upass = trim($_POST['txtpass']);
    
    $stmt = $admin->runQuery("SELECT * FROM tblUsers WHERE userEmail=:email_id");//check if email is already registered
    $stmt->execute(array(":email_id"=>$email));
    
    //if email is registered then do if statement else register the user
    if($stmt->rowCount() > 0)
    {
        $msg = "<div class='alert alert-error'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Sorry!</strong>  email allready exists , Please Try another one
                </div>";
    }
    else
    {
        if($admin->adminRegister($prefix,$ufname,$ulname,$email,$upass))//register user
        {   
            header('Location: ../adminview.html'); //if registration goes well
        }
        else //if DB throws exception
        {
            echo "sorry, Query could no execute...";
        }  
    }
}

//if user clicks "Add Course" button
if(isset($_POST['btn-addCourse']))
{
    $crn = trim($_POST['txtcrn']);
    $sub = trim($_POST['crssubj']);
    $subnum = trim($_POST['txtsubnum']);
    $instr = trim($_POST['txtinstrID']);
    
    $stmt = $admin->runQuery("SELECT * FROM Course WHERE courseNum=:crn_id");//check course is already registered
    $stmt->execute(array(":crn_id"=>$crn));
    
    //if crn already exists then do if statement else register the course
    if($stmt->rowCount() > 0)
    {
        $msg = "<div class='alert alert-error'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Sorry!</strong>  Course number already exists. Please Try another one
                </div>";
    }
    else
    {
        if($admin->addCourse($crn,$sub,$subnum,$instr))//register user
        {   
            header('Location: ../adminview.html'); //if registration goes well
        }
        else //if DB throws exception
        {
            echo "sorry, Query could no execute...";
        }  
    }
}
?>
