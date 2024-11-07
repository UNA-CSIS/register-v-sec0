<?php
session_start(); // session start here...

// get all 3 strings from the form (and scrub w/ validation function)
$password = $_POST['pwd'];
$repeat_password = $_POST['repeat'];
$user = $_POST['user'];

// make sure that the two password values match!
if (!($password == $repeat_password)) {
    echo "Bad username/password <br>";
} else {
    // making hash from password
    $hash = password_hash($password, PASSWORD_DEFAULT);

// connecting to db
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "softball";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
    }

// checking if user exist already
    $sql = "SELECT username FROM users WHERE username = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Bad username/password <br>";
    } else {
        $sql = "INSERT INTO users (username, password) VALUES ('$user', '$hash')";
        if ($conn->query($sql) === TRUE) {
            header('Location: index.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// fallback for mistakes
echo "<a href='register.php'>Go Back</a>";

