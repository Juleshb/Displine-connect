<?php
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

if($stmtUpdateStudent->execute()){
	$data = array("status"=>"200","message" => "Data saved successfully!");
	$jsonData = json_encode($data);
	header('Content-Type: application/json');
	echo $jsonData; 
} else {
	$data = array("status"=>"500","message" => "Failed to save data!");
	$jsonData = json_encode($data);
	header('Content-Type: application/json');
	echo $jsonData; 
}



$stmtStudent->close();
$stmtGuardian->close();
$stmtUpdateStudent->close();
$this->connect->close();

    }

}

$student = new Students();
$action = $_POST['action'];
switch ($action) {
    case 'register':
        $student->save_student();
        break;
}
?>
