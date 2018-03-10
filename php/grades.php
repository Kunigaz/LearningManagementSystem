<?php
//ty codingcage.com and w3schools.com 

session_start();
require_once 'class.dbfunct.php';

$grades = new DBFUNCT();
$gpa = 0;
$num = 0;
$stdntid = $_SESSION['userType'] . $_SESSION['userSession'];

$stmt = $grades->runQuery("SELECT crn FROM StudentReg WHERE stdntID=:stu_id");
$stmt->execute(array(':stu_id'=>$stdntid));
$listgrades = $stmt->fetchAll();


//if($stmt->rowCount() == 0)
//{
//    echo "No grades entered for this class yet.";
//}
// Turn off error reporting
error_reporting(0);
?>

<!DOCTYPE html>

<!--List of courses student is enrolled in-->

<html>
    <head>
        <title>Student Grades</title>
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
            <h2>Student Grades</h2><hr  />
            <?php
                foreach( $listgrades as $i)
                {
                    $earned = 0;
                    $total = 0;
                    $stmt = $grades->runQuery("SELECT assignmentName, pntsGiven, pntsPossbl FROM Grade WHERE stdntID=:stu_id AND crn=:crs_num");
                    $stmt->execute(array(':stu_id'=>$stdntid, ':crs_num'=>$i['crn']));
                    $crsgrade = $stmt->fetchAll();
                    ?>
                    
                    <table style = "background-color: #000; width: 50%;">
                    <?php
                    echo "CRN: " . $i['crn'];
                    foreach( $crsgrade as $j )
                    {
                        ?>
                        <tr>
                        <td><font><?php echo $j['assignmentName'].": "; ?></font></td>
                        <td><font><?php echo $j['pntsGiven']; ?></font></td>
                        <td><font><?php echo "/".$j['pntsPossbl']; ?></font></td>
                        </tr>
                      
                        <?php
                        $earned += $j['pntsGiven'];
                        $total += $j['pntsPossbl'];
                    }
                    
                    $final = (($earned/$total) * 100);
                    
                    if($final >= 90)
                        $gpa += 4.0;
                    else if ($final >= 80 && $final <90)
                        $gpa += 3.0;
                    else if ($final >= 70 && $final <80)
                        $gpa += 2.0;
                    else if ($final >= 60 && $final <70)
                        $gpa += 1.0;
                    else
                        $gpa += 0.0;
                        
                    ++$num;
                      
                    ?>
                    <tr><td><font><?php echo "Grade in class: " . (($earned/$total) * 100) . "%"; ?></font></td></tr>
                    
                    </table>
                    </br>
                    <?php
                }
                echo "Total GPA: " . ($gpa/$num);
            ?>
        </div>
        
        <div style = "display: inline;">
            <form action='student.php' style = "display: inline;">
                <input class="btn-outline-light larger-btn" type='submit' name='btn-back' value='Back to Home' style ="width: 200px;">
            </form>
        </div>
    </body>
</html>