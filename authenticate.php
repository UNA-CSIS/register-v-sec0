<?php
// start session
session_start();

// login to the softball database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "softball";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// select password from users where username = <what the user typed in>
$sql = "SELECT password FROM users WHERE username = '" . $_POST["user"] . "'";
$result = $conn->query($sql);

// if no rows, then username is not valid (but don't tell Mallory) just send her back to the login
if (!($result->num_rows > 0)) {
    header("location: index.php");
} else {
    $row = $result->fetch_assoc();
    $stored_hash = $row["password"];
    // otherwise, password_verify(password from form, password from db)
    $given_pwd = $_POST["pwd"];
    if (password_verify($given_pwd, $stored_hash)) {
        // if good, put username in session, otherwise send back to login
        $_SESSION["username"] = $_POST["user"];
        header("location: games.php");
    } else {
        header("location: index.php");
    }
}





