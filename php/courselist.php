<?php
//ty codingcage.com and w3schools.com

session_start();
require_once 'class.dbfunct.php';

$courselist = new DBFUNCT();

$stdntid = $_SESSION['userType'];
$stdntid .= $_SESSION['userSession'];

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

<!-- Instructor's view -->

<html>
    
    <body>
        <table>
                <tr>
                    <th>CRN</th>
                    <th>Subject</th>
                    <th>Number</th>
                </tr>
                <?php
                    $i=0;
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
        
      <form method="post">
        CRN: <input type="text" name="txt-crn">
        <input type="submit" name="btn-add" value="Add">
      </form>

    </body>
</html>