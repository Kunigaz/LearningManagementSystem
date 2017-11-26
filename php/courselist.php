<?php
//ty codingcage.com and w3schools.com

session_start();
require_once 'class.dbfunct.php';

$courselist = new DBFUNCT();

$stdntid = $_SESSION['userType'] . $_SESSION['userSession'];

$stmt = $courselist->runQuery("SELECT * FROM Course");
$stmt->execute(array());
$courses = $stmt->fetchAll();
$num = $stmt->rowCount();

if(isset($_POST['btn-add']))
{
    $crn = $_POST['txt-crn'];
    $courselist->enroll($crn,$stdntid);
    
    print( "<p>Registration successful</p>" );
}
?>

<!DOCTYPE html>

<!--List of courses student is enrolled in-->

<html>
    <head>
        <title>Register for Courses</title>
        <link rel="stylesheet" type="text/css" href="../styles.css">
        
        <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
    </style>
    </head>
    <body id="login">
        <div class="container">
            <h2>Register for Courses</h2><hr />
            <table style = "background-color: #000; width: 50%;">
                <tr>
                    <th>CRN</th>
                    <th>Subject</th>
                    <th>Number</th>
                </tr>
                <?php
                    foreach( $courses as $row)
                    {
                ?>
                        <tr>
                        <td>
                        <font><?php echo $row['courseNum']; ?></font>
                        </td>
                        <td>
                        <font><?php echo $row['courseSub']; ?></font>
                        </td>
                        <td>
                        <font><?php echo $row['subjectNum']; ?></font>
                        </td>
                        </tr>
                <?php
                    }
                ?>
            </table>
        
        </br>
        
        <form method="post">
            Please Type CRN: <input type="text" name="txt-crn" style ="width: 200px;">
            <input class="btn-outline-light larger-btn" type="submit" name="btn-add" value="Add" style ="width: 200px;">
        </form>
        
        <form action='student.php'>
            <input class="btn-outline-light larger-btn" type='submit' name='btn-back' value='Back to Home' style ="width: 200px;">
        </form>

    </body>
</html>