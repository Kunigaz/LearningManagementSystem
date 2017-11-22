<?php
//ty codingcage.com and w3schools.com

session_start();
require_once 'class.dbfunct.php';

$student = new DBFUNCT();

$name = $_SESSION['userName'];
//concatenate staff's prefix and ID
$stuid = $_SESSION['userType'];
$stuid .= $_SESSION['userSession'];

//get courses associated to this staff
$stmt = $student->runQuery("SELECT * FROM Course WHERE courseNum IN (SELECT crn FROM StudentReg WHERE stdntID=:stu_id)");
$stmt->execute(array(':stu_id'=>$stuid));
$course = $stmt->fetchAll();
$num = $stmt->rowCount();
?>

<!DOCTYPE html>

<!-- Student's view -->

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
            <h2>Student Homepage</h2><hr />
            <?php echo "<h3>Welcome " . $name . "</h3>";?>
            <h3>Your Courses</h3>
            <table>
                <tr>
                    <th>CRN</th>
                    <th>Subject</th>
                    <th>Number</th>
                </tr>
                <?php
                    $i=0;
                    foreach( $course as $row)
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
            </table><hr />
            <form class="form-signin" method="post" action="courselist.php">
                <button class="btn btn-large btn-primary" type="submit" name="btn-enroll">Register classes</button>
            </form>
        </div> <!-- /container -->
    </body>
</html>