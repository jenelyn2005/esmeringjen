<?php
class Participant {
    private $conn;

    // Fixed typo from fucntion to function
    public function __construct($conn){
            $this->conn = $conn;
    }

    // Fixed typo from fucntion to function
    public function getAllParticipants(){
        $query = "SELECT * FROM participants";
        $stmt = $this->conn->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function addParticipant($first_name,$last_name,$email,$gender,$birthdate,$city){

    $query = "insert into participants (first_name,last_name,email,gender,birthdate,city) values
    (:first_name, :last_name, :email, :gender, :birthdate, :city)";
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'gender' => $gender,
        'birthdate' => $birthdate,
        'city' => $city,
    ]);
    }

    public function deleteParticipant($participants_id){
        try {
            $this->conn->beginTransaction();

            $registrationQuery = "DELETE FROM registrations WHERE participants_id = :participants_id";
            $registrationStmt = $this->conn->prepare($registrationQuery);
            $registrationStmt->execute([
                'participants_id' => $participants_id,
            ]);

            $participantQuery = "DELETE FROM participants WHERE participants_id = :participants_id";
            $participantStmt = $this->conn->prepare($participantQuery);
            $participantStmt->execute([
                'participants_id' => $participants_id,
            ]);

            $this->conn->commit();
            return true;
        } catch (PDOException $exception) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }

            return false;
        }
    }

}
?>
