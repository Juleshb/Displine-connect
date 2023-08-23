<?php
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client;



include ('../connection.php');
$connection = $conn;

class Students {
    private $connect;

    public function __construct() {
        global $connection;
        $this->connect = $connection;
    }


    function save_student() {
$studentFirstName = $_POST["studentFirstName"];
$studentLastName = $_POST["studentLastName"];
$studentDateOfBirth = $_POST["studentDateOfBirth"];
$gender = $_POST["gender"];
$registrationNumber = date("Y") . str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT);

include "../phpqrcode/qrlib.php";

$qr_code_directory = '../sIDqrcodes/';
$qr_code_data = $registrationNumber;
$qr_code_file = $qr_code_directory . $registrationNumber . '.png';
QRcode::png($qr_code_data, $qr_code_file, 'L', 4, 2);


$guardianFirstName = $_POST["guardianFirstName"];
$guardianLastName = $_POST["guardianLastName"];
$relationship = $_POST["relationship"];
$guardianContactEmail = $_POST["guardianContactEmail"];
$guardianContactPhone = $_POST["guardianContactPhone"];


$sqlStudent = "INSERT INTO Student (FirstName, LastName, DateOfBirth, Gender,studentNumber)
               VALUES (?, ?, ?, ?,?)";

$sqlGuardian = "INSERT INTO Guardian (FirstName, LastName, Relationship, ContactEmail, ContactPhone)
                VALUES (?, ?, ?, ?, ?)";

$stmtStudent = $this->connect->prepare($sqlStudent);
$stmtStudent->bind_param("sssss", $studentFirstName, $studentLastName, $studentDateOfBirth, $gender,$registrationNumber);
$stmtStudent->execute();
$studentID = $stmtStudent->insert_id;


$stmtGuardian = $this->connect->prepare($sqlGuardian);
$stmtGuardian->bind_param("sssss", $guardianFirstName, $guardianLastName, $relationship, $guardianContactEmail, $guardianContactPhone);
$stmtGuardian->execute();
$guardianID = $stmtGuardian->insert_id;


$sqlUpdateStudent = "UPDATE Student SET GuardianID = ? WHERE StudentID = ?";
$stmtUpdateStudent =$this->connect->prepare($sqlUpdateStudent);
$stmtUpdateStudent->bind_param("ii", $guardianID, $studentID);

if ($stmtUpdateStudent->execute()) {
    $to = $guardianContactEmail;
    $subject = "Student Information Saved";
    $message = '<html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .logo {
                max-width: 100px;
            }
            .footer {
                margin-top: 20px;
                padding-top: 10px;
                border-top: 1px solid #ccc;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">

            <h2> Hello'. $guardianFirstName . ',</h2>
            <p>We are pleased to inform you that the students information has been successfully saved.</p>
            <p><strong>Student Name:' . $studentFirstName . '' . $studentLastName . '</p>
			<p><strong>Student Number:' . $registrationNumber . '</p>
            <p>If you have any questions, please contact us at:</p>
            <p>Email: disciplineconnect@gmail.com<br>Phone: +250 792 445 913</p>
	
        </div>
        <div class="footer">
            &copy; 2023 Discipline Connect. All rights reserved.
        </div>
    </body>
    </html>';

   
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPSecure = "tls";
        $mail->SMTPAuth = true;
        $mail->Username = "disciplineconnect@gmail.com";
        $mail->Password = "ghkypfrobbgqrlpk";

        $mail->setFrom("disciplineconnect@gmail.com");
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->isHTML(true);

        $mail->send();

        $data = array("status" => "200", "message" => "Data saved successfully! Email sent to guardian.");
    } catch (Exception $e) {
        $data = array("status" => "500", "message" => "Data saved successfully! Failed to send email.");
    }

    $jsonData = json_encode($data);
    header('Content-Type: application/json');
    echo $jsonData;
} else {
    $data = array("status" => "500", "message" => "Failed to save data!");
    $jsonData = json_encode($data);
    header('Content-Type: application/json');
    echo $jsonData;
}


$stmtStudent->close();
$stmtGuardian->close();
$stmtUpdateStudent->close();
$this->connect->close();

    }
//search student
function load_stu_info(){
    $input = $_POST['keyword'];
    
    $stmt = $this->connect->prepare("SELECT * FROM student WHERE FirstName LIKE ? OR LastName LIKE ? OR studentNumber LIKE ? LIMIT 4");
    $inputParam = "%" . $input . "%";
    $stmt->bind_param("sss", $inputParam, $inputParam,$inputParam);
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $jsonData = json_encode($data);
    
    header('Content-Type: application/json');
    echo $jsonData;
}

//loadstudent info
function load_student_info(){
    $stu = $_POST['stu'];
    
    $stmt = $this->connect->prepare("SELECT student.*, guardian.*
        FROM student 
        JOIN guardian ON student.GuardianID = guardian.GuardianID
        WHERE student.studentNumber = ?");
   
    $stmt->bind_param("s", $stu); // Bind the parameter
    $stmt->execute();
    
    $result = $stmt->get_result(); // Get the result set
    $data = $result->fetch_all(MYSQLI_ASSOC); // Fetch the rows as an associative array
    
    $jsonData = json_encode($data);
    header('Content-Type: application/json');
    echo $jsonData;   
}

// Submit student permission

function submit_permission() {
    $permissionType = $_POST["permissionType"];
    $permissionDate = $_POST["permissionDate"];
    $expireddate = $_POST["expireddate"];
    $permissionReason = $_POST["permissionReason"];
    $guardianContact = $_POST["guardianContact"];
    $approverName = $_POST["approverName"];
    $emergencyContact = $_POST["emergencyContact"];
    $comments = $_POST["comments"];
    $confirm = isset($_POST["confirm"]) ? 1 : 0;

   
    $studentID = $_POST["pstudentid"]; 
    $studentname= $_POST["pstudentname"]; 
    $parentname = $_POST["pparentname"]; 

  
    $insertPermissionQuery = "INSERT INTO permissions (studentID, permissionType, permissionDate, permissionReason, guardianContact, approverName, emergencyContact, comments, confirm,expireddate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
    
    $stmt =  $this->connect->prepare($insertPermissionQuery);
    $stmt->bind_param("issssssssi", $studentID, $permissionType, $permissionDate, $permissionReason, $guardianContact, $approverName, $emergencyContact, $comments, $confirm, $expireddate);
    
    if ($stmt->execute()) {

        $sid    = "AC470f2bb04f1b7e0336397209aef5121e";
        $token  = "a453e0661c796af1ce285015ab7be31c";
        $twilio = new Client($sid, $token);
    
        $message = $twilio->messages
          ->create("+250792445913", // to
            array(
              "from" => "+14706889058",
              "body" => "Mubyeyi dufatanije kurera turabamenyeshako umwana wanyu $studentname yahawe uruhusha kuva $permissionDate rukazarangira $expireddate tubashimiye imikoranire myiza. ubundi busobanuro mwabusanga kuri email yanyu Murakoze!,
             "
            )
          );
    
         $messid=($message->sid);



        $to = $guardianContact;
        $subject = "Confirmation of Student's Permission Request";
        $message = '<html>
        <head>
        <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        p {
            margin: 0 0 1em;
            color: #555;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
        strong {
            color: #333;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            text-align: center;
        }
        </style>
       </head>
        <body>
      <div class="container">

        <p>Dear ' .  $parentname . ',</p>

        <p>We hope this email finds you well. We would like to inform you that the permission request for your child,' . $studentname . ', has been successfully reviewed and confirmed.</p>

        <p>Here are the details of the permission request:</p>
        
        <ul>
            <li><strong>Permission Type:</strong> ' . $permissionType . '</li>
            <li><strong>Date and Time:</strong> ' . $permissionDate  . '</li>
            <li><strong>Expired Date and Time:</strong> ' . $expireddate . '</li>
            <li><strong>Purpose/Reason:</strong> ' .  $permissionReason . '</li>
            <li><strong>Approver Name:</strong> ' . $approverName  . '</li>
            <li><strong>Emergency Contact:</strong> ' . $emergencyContact  . '</li>
            <li><strong>Additional Comments:</strong> ' .  $comments . '</li>
        </ul>

        <p>We would like to reassure you that we take every precaution to ensure the safety and well-being of our students during the permission activities. Your childs safety is our top priority.</p>

        <p>If you have any questions or concerns regarding the permission, please feel free to reach out to us at ' . $emergencyContact  . '.</p>

        <p>Thank you for entrusting us with your childs education and safety. We look forward to providing them with valuable experiences through these permissions.</p>

        <p>Best regards,<br>
        

          </div>
            <div class="footer">
             &copy; 2023 Discipline Connect. All rights reserved.
              </div>
        </body>
        </html>';
    
       
        $mail = new PHPMailer(true);
        // try {
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->SMTPSecure = "tls";
            $mail->SMTPAuth = true;
            $mail->Username = "disciplineconnect@gmail.com";
            $mail->Password = "ghkypfrobbgqrlpk";
    
            $mail->setFrom("disciplineconnect@gmail.com");
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->isHTML(true);
    
            $mail->send();
    
            $data = array("messageID"=>$messid,"status" => "200", "message" => "Permission confirmed successfully!! Email and SMS sent to guardian.");
            $jsonData = json_encode($data);
            header('Content-Type: application/json');
            echo $jsonData;
    } else {
    // Prepare JSON response for failure
          $data = array("status" => "500", "message" => "Permission not saved!");
          $jsonData = json_encode($data);
          header('Content-Type: application/json');
         echo $jsonData;
     }

}

}

$student = new Students();
$action = $_POST['action'];
switch ($action) {
    case 'register':
        $student->save_student();
        break;
	case 'searchst':
    	$student->load_stu_info();
	    break;
    case 'loadstdnt':
        $student->load_student_info();
        break;
    case 'submitpermission':
        $student->submit_permission();
        break;
		
}
?>