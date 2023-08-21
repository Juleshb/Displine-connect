<?php
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



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
		
}
?>
