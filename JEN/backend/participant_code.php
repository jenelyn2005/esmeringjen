<?php 

require_once '../connection.php';
require_once '../classes/Participants.php';

$participant = new Participant($conn);

if (isset($_POST['add_participant'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $city = $_POST['city'];

    if ($participant->addParticipant($first_name, $last_name, $email, $gender, $birthdate, $city)){
        header("Location: ../indexx.php");
    }
}

if (isset($_POST['delete_participant'])){
    $participants_id = filter_input(INPUT_POST, 'participants_id', FILTER_VALIDATE_INT);

    if ($participants_id !== false && $participants_id !== null && $participant->deleteParticipant($participants_id)){
        header("Location: ../indexx.php");
        exit;
    }
}

?>