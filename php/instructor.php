<?php
//ty codingcage.com and w3schools.com

session_start();
require_once 'class.dbfunct.php';

$faculty = new DBFUNCT();

$name = $_SESSION['userName'];
//concatenate staff's prefix and ID
$staffid = $_SESSION['userType'] . $_SESSION['userSession'];

//get courses associated to this staff
$stmt = $faculty->runQuery("SELECT * FROM Course WHERE staffID=:staff_id");
$stmt->execute(array(':staff_id'=>$staffid));
$course = $stmt->fetchAll();

if(isset($_POST['btn-crsrostr'])){
    $_SESSION['crn'] = $_POST['txtcrn'];
    header('Location: studentlist.php');   
}

if(isset($_POST['btn-logout']))
{
    $faculty->logout();
}
?>

<!DOCTYPE html>

<!-- Instructor's view -->

<html>
    <head>
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
    
    <link rel="stylesheet" type="text/css" href="../styles.css">
    </head>
    <body id="login">
        <div class="container">
            <h2>Instructor Homepage</h2><hr />
            <?php echo "<h3>Welcome " . $name . "</h3>";?>
            <h3>Your Courses</h3>
            <table style = "background-color: #000; width: 50%;">
                <tr>
                    <th>CRN</th>
                    <th>Subject</th>
                    <th>Number</th>
                </tr>
                <?php
                    foreach( $course as $row)
                    {
                ?>
                        <tr>
                        <td><font><?php echo $row['courseNum']; ?></font></td>
                        <td><font><?php echo $row['courseSub']; ?></font></td>
                        <td><font><?php echo $row['subjectNum']; ?></font></td>
                        </tr>
                <?php
                    }
                ?>
            </table>
            
            </br>
            
            <form method="post" style = "display: inline;">
                <input type="text" name="txtcrn" placeholder="Enter CRN for course roster you wish to view" style ="width: 500px;"/>
                <input class="btn-outline-light larger-btn" type="submit" value="Submit" name="btn-crsrostr" style ="width: 200px;"/>
            </form>
            
            <form method="post" style = "display: inline;">
                    
                <input class="btn-outline-light larger-btn" type="Submit" value="Logout" name="btn-logout" style ="width: 200px;">
                    
            </form>
            
        </div> <!-- /container -->
    </body>
</html>