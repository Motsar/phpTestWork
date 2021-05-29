<?php
include('./DB.php');

//check if request method is POST

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Check that required data is posted

    if (!empty($_POST['regName']) && !empty($_POST['regEmail']) && !empty($_POST['selectTown']) && !empty($_POST['selectDateTime'])) {

        //Get connection instance from DB object

        $db = DB::getConnection();

        //SQL query

        $sqlQuery = "INSERT INTO stargazers(Name,Email,Town,DateTime,Comment) VALUES (:name, :email, :selectTown, :selectDateTime , :comment )";

        //Prepare sql query with pso

        $query = $db->pdo->prepare($sqlQuery);

        //Sanitize data before sending data to DB

        $regName = filter_var($_POST['regName'], FILTER_SANITIZE_STRING);
        $regEmail = filter_var($_POST['regEmail'], FILTER_SANITIZE_EMAIL);
        $selectTown = filter_var($_POST['selectTown'], FILTER_SANITIZE_STRING);
        $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);

        //Bind SQL query params with sanitized data

        $query->bindParam(':name', $regName);
        $query->bindParam(':email', $regEmail);
        $query->bindParam(':selectTown', $selectTown);
        $query->bindParam(':selectDateTime', $_POST['selectDateTime']);
        $query->bindParam(':comment', $comment);

        //try catch for executing the query

        try {
            $query->execute();
            mail($_POST['regEmail'], "Stargazers in Estonia", "Hey " . $_POST['regName'] . ", you’ve been registered to the star observers event in " . $_POST['selectTown'] . " on " . date('d.m.Y', strtotime($_POST['selectDateTime'])) . " at " . date('H:i', strtotime($_POST['selectDateTime'])));
            echo '{"message":"You registered to the star observers event in ' . $selectTown . ' on ' . date('d.m.Y', strtotime($_POST['selectDateTime'])) . ' at ' . date('H:i', strtotime($_POST['selectDateTime'])) . ', a confirmation email has been sent to ' . $regEmail . '"}';
        } catch (PDOException $e) {
            $splitError = explode(" ", $e);
            if ($splitError[1] == "SQLSTATE[23000]:") {
                echo '{"error":"You have already registered to this event!"}';
            } else {
                echo '{"error":"Something went wrong!"}';
            }
        }
    }
}
