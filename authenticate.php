<?php
// start session
session_start();

// login to the softball database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "softball";

// select password from users where username = <what the user typed in>
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT password from users where username = '".$_POST["username"]."'";
$result = $conn->query($sql);

// if no rows, then username is not valid (but don't tell Mallory) just send her back to the login
if (!($result->num_rows > 0)) {
    header("location: index.php");
}

// otherwise, password_verify(password from form, password from db)
$result = $result->fetch_assoc();
$stored_password = $result['password'];

// if good, put username in session, otherwise send back to login
if (password_verify($_POST["password"], $stored_password)) {
    $SESSION['username'] = $_POST["username"];

}


