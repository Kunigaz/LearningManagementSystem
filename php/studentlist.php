<?php
//ty codingcage.com and w3schools.com

session_start();
require_once 'class.dbfunct.php';

$studentlist = new DBFUNCT();

$crnquery = $_POST['txt-crnquery'];

$stmt = $studentlist->runQuery("SELECT * FROM tblUsers WHERE CONCAT(userIDPrefix, userID) IN (SELECT stdntID FROM StudentReg WHERE crn=".$crnquery.")");
$stmt->execute(array());
$students = $stmt->fetchAll();

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

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
    </head>
    <body id="login">
        <div class="container">
            <?php echo "<h3>Students Enrolled in this course</h3>";?>
            <table>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                </tr>
                <?php
                    foreach($students as $row)
                    {
                ?>
                        <tr>
                        <td><font><?php echo $row['userIDPrefix'].$row['userID']; ?></font></td>
                        <td><font><?php echo $row['userFirstName']." ".$row['userLastName']; ?></font></td>
                        </tr>
                <?php
                    }
                ?>
            </table>
            <form method=post>
                <input type="text" name=""/>
                <input type="submit" value="Submit"/>
            </form>
        </div> <!-- /container -->
    </body>
</html>