<?php
//ty codingcage.com and w3schools.com

session_start();
require_once 'class.dbfunct.php';

$faculty = new DBFUNCT();

$name = $_SESSION['userName'];
//concatenate staff's prefix and ID
$staffid = $_SESSION['userType'];
$staffid .= $_SESSION['userSession'];

//get courses associated to this staff
$stmt = $faculty->runQuery("SELECT * FROM Course WHERE staffID=".$staffid);
$stmt->execute();
$course = $stmt->fetch(PDO::FETCH_ASSOC);

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
              <tr>
                <td>
                <?php
                    echo $course['courseNum'];
                ?>
                </td>
                <td>
                <?php
                    echo $course['courseSub'];
                ?>
                </td>
                <td>
                <?php
                    echo $course['subjectNum'];
                ?>
                </td>
              </tr>
            </table>
        </div> <!-- /container -->
    </body>
</html>