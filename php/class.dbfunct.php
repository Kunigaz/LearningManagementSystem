<?php
//code from codingcage.com

//header, includes the DB connect configuration (dbconfig.php)
require_once 'dbconfig.php';

class DBFUNCT
{ 
    private $conn;
 
    //connect to the DB
    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }
 
    //execute query
    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
 
    //student self registration
    public function register($ufname,$ulname,$email,$upass)
    {
        try
        {       
            $password = md5($upass); //turns password into hash

            //"prapares" SQL statement for later use
            $stmt = $this->conn->prepare("INSERT INTO tblUsers(userFirstName,userLastName,userEmail,userPass) 
                                                    VALUES(:user_fname, :user_lname, :user_mail, :user_pass)");
   
            //binds the php variables passed through function to our SQL defined placeholders above
            $stmt->bindparam(":user_fname",$ufname);
            $stmt->bindparam(":user_lname",$ulname);
            $stmt->bindparam(":user_mail",$email);
            $stmt->bindparam(":user_pass",$password);
            $stmt->execute(); //executes the previously "prepared" SQL
            return $stmt;
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }  
 
    //registration call for admins
    public function adminRegister($prefix,$ufname,$ulname,$email,$upass)
    {
        try
        {       
            $password = md5($upass); //turns password into hash
            
            //preemptivly set user prefix based on type of user added
            switch($prefix)
            {
                case "admin":
                    $prefix = "000";
                    break;
                case "staff":
                    $prefix = "100";
                    break;
                default:
                    $prefix = "900";
            }
    
            //"prapares" SQL statement for later use
            $stmt = $this->conn->prepare("INSERT INTO tblUsers(userIDPrefix,userFirstName,userLastName,userEmail,userPass) 
                                                    VALUES(:user_acctType,:user_fname, :user_lname, :user_mail, :user_pass)");
       
            //binds the php variables passed through function to our SQL defined placeholders above
            $stmt->bindparam(":user_acctType",$prefix);
            $stmt->bindparam(":user_fname",$ufname);
            $stmt->bindparam(":user_lname",$ulname);
            $stmt->bindparam(":user_mail",$email);
            $stmt->bindparam(":user_pass",$password);
            $stmt->execute(); //executes the previously "prepared" SQL
            return $stmt;
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }
    
    //enroll in course as student
    public function enroll($crn,$studntid)
    {
        try
        {       
            //"prapares" SQL statement for later use
            $stmt = $this->conn->prepare("INSERT INTO StudentReg (crn,stdntID) 
                                                        VALUES(:crn_num, :std_id)");
            
            //binds the php variables passed through function to our SQL defined placeholders above
            $stmt->bindparam(":crn_num",$crn);
            $stmt->bindparam(":std_id",$studntid);
            $stmt->execute(); //executes the previously "prepared" SQL
            return $stmt;
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }
 
    //add course from admin page
    public function addCourse($crn,$subj,$subnum,$instr)
    {
        try
        {       
            //"prapares" SQL statement for later use
            $stmt = $this->conn->prepare("INSERT INTO Course (courseNum,courseSub,subjectNum,staffID) 
                                                        VALUES(:crs_num, :crs_subj, :crs_subnum, :crs_instr)");
            
            //binds the php variables passed through function to our SQL defined placeholders above
            $stmt->bindparam(":crs_num",$crn);
            $stmt->bindparam(":crs_subj",$subj);
            $stmt->bindparam(":crs_subnum",$subnum);
            $stmt->bindparam(":crs_instr",$instr);
            $stmt->execute(); //executes the previously "prepared" SQL
            return $stmt;
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }
 
    public function addGrade($crn, $id, $asngmt, $earned, $total)
    {
        try
        {       
            //"prapares" SQL statement for later use
            $stmt = $this->conn->prepare("INSERT INTO Grade (crn,stdntID,assignmentName,pntsGiven,pntsPossbl) 
                                                        VALUES(:crs_num, :std_id, :asgnmt_name, :pnts_earned, :pnts_pos)");
            
            //binds the php variables passed through function to our SQL defined placeholders above
            $stmt->bindparam(":crs_num",$crn);
            $stmt->bindparam(":std_id",$id);
            $stmt->bindparam(":asgnmt_name",$asngmt);
            $stmt->bindparam(":pnts_earned",$earned);
            $stmt->bindparam(":pnts_pos",$total);
            $stmt->execute(); //executes the previously "prepared" SQL
            return $stmt;
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }
    //function called when user trys to login
    public function login($email,$upass)
    {
        try
        {
            //prepare SQL statement
            $stmt = $this->conn->prepare("SELECT * FROM tblUsers WHERE userEmail=:email_id");
            $stmt->execute(array(":email_id"=>$email));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC); //returns the array indexed by column name as returned in $stmt
            
            if($stmt->rowCount() == 1)
            {
                if($userRow['userPass']==md5($upass)) //checks against the hash created at registration
                {
                    $_SESSION['userType'] = $userRow['userIDPrefix']; //needed to specify the users permissions
                    $_SESSION['userSession'] = $userRow['userID']; //sets session variable, can be used to verify user is logged in
                    $_SESSION['userName'] = $userRow['userFirstName']; //get first name
                    $_SESSION['userName'] .= " ";
                    $_SESSION['userName'] .= $userRow['userLastName']; //concatenate last name
                    return true;
                }
                else
                {
                    echo "Wrong password";
                    exit;
                }
            }
            else
            {
                echo "Error";
                exit;
            }  
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }
    
    public function logout()
    {
        //dump all session variables
        session_destroy();
        $_SESSION['userSession'] = false;
        header('Location: ../index.html');
    }
}
?>