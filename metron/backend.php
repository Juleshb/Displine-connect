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


$guardianFirstName = $_POST["guardianFirstName"];
$guardianLastName = $_POST["guardianLastName"];
$relationship = $_POST["relationship"];
$guardianContactEmail = $_POST["guardianContactEmail"];
$guardianContactPhone = $_POST["guardianContactPhone"];


$sqlStudent = "INSERT INTO Student (FirstName, LastName, DateOfBirth, Gender)
               VALUES (?, ?, ?, ?)";

$sqlGuardian = "INSERT INTO Guardian (FirstName, LastName, Relationship, ContactEmail, ContactPhone)
                VALUES (?, ?, ?, ?, ?)";

$stmtStudent = $this->connect->prepare($sqlStudent);
$stmtStudent->bind_param("ssss", $studentFirstName, $studentLastName, $studentDateOfBirth, $gender);
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
    $message = "Hello " . $guardianFirstName . ",\n\n";
    $message .= "We are pleased to inform you that the student's information has been successfully saved.\n";
    $message .= "Student Name: " . $studentFirstName . " " . $studentLastName . "\n";

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

        $mail->send();

        $data = array("status" => "200", "message" => "Data saved successfully! Email sent to guardian.");
    } catch (Exception $e) {
        $data = array("status" => "200", "message" => "Data saved successfully! Failed to send email.");
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
//load student information
function load_stu_info(){
    $input = $_POST['keyword'];
    
    $stmt = $this->connect->prepare("SELECT * FROM student WHERE FirstName LIKE ? OR LastName LIKE ?");
    $inputParam = "%" . $input . "%";
    $stmt->bind_param("ss", $inputParam, $inputParam);
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = $result->fetch_all(MYSQLI_ASSOC);
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
		
}
?>
