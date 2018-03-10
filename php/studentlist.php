<?php
//ty codingcage.com and w3schools.com

session_start();
require_once 'class.dbfunct.php';

$studentlist = new DBFUNCT();

$crn = $_SESSION['crn'];

//SQL query to get list of enrolled students
$stmt = $studentlist->runQuery("SELECT * FROM tblUsers 
                                    WHERE CONCAT(userIDPrefix, userID) 
                                    IN (SELECT stdntID FROM StudentReg 
                                            WHERE crn=".$crn.")");
$stmt->execute(array());
$students = $stmt->fetchAll();

if(isset($_POST['btn-grade']))
{
    $id = trim($_POST['txtstdid']);
    $asngmt = trim($_POST['txtasgnmt']);
    $earned = trim($_POST['txtpnts']);
    $total = trim($_POST['txttotal']);
    
    $studentlist->addGrade($crn, $id, $asngmt, $earned, $total);
    
    echo "<p>Grade added successfully</p>";
}
?>

<!DOCTYPE html>

<!-- Instructor's view, list of students enrolled in their course -->

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
            <?php echo "<h3>Students Enrolled in this course</h3>";?>
            <table style = "background-color: #000; width: 50%;">
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                </tr>
                <?php
                    foreach($students as $row)
                    {
                ?>
                        <tr>
                        <td><font><?php echo $row['userIDPrefix'] .$row['userID']; ?></font></td>
                        <td><font><?php echo $row['userFirstName'] . " " . $row['userLastName']; ?></font></td>
                        </tr>
                <?php
                    }
                ?>
            </table>
            <form method=post style = "display: inline;">
                <h3>Give student grade:</h3>
                <input type="text" name="txtstdid" placeholder="Student ID"/>
                <input type="text" name="txtasgnmt" placeholder="Assignment Name"/>
                <input type="text" name="txtpnts" placeholder="Points Earned"/>
                <input type="text" name="txttotal" placeholder="Points Possible"/>
                <input class="btn-outline-light larger-btn" type="submit" name="btn-grade" value="Submit" style = "width: 100px"/>
            </form>
            
            <form action='instructor.php'>
                <input class="btn-outline-light larger-btn" type='submit' name='btn-back' value='Back to Home' style ="width: 200px;">
            </form>
        </div> <!-- /container -->
    </body>
</html>