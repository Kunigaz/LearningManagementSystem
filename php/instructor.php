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

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
    </head>
    <body id="login">
        <div class="container">
            <h2>Instructor Homepage</h2><hr />
            <?php echo "<h3>Welcome " . $name . "</h3>";?>
            <h3>Your Courses</h3>
            <table>
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
            <form method="post">
                <input type="text" name="txtcrn" placeholder="Enter CRN for course roster you wish to view"/>
                <input type="submit" value="Submit" name="btn-crsrostr"/>
            </form>
        </div> <!-- /container -->
    </body>
</html>