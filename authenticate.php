<?php

require 'config.php';
require 'lib.php';

session_start();

if(!isset($_POST['username'], $_POST['password'])) {
    die("Please fill out both the username and password field!");
}

// Save the submitted username as a session variable
$_SESSION['username'] = htmlspecialchars($_POST['username']);

$sql = "SELECT * FROM users WHERE username = ?";

$results = query_db(array($sql, $_POST['username']));

if(sizeof($results) > 0) {
    if(password_verify($_POST['password'], $results[0]['password'])) {
        // User has successfully logged in.
        // Create session data for user.
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $results[0]['firstname'];
        $_SESSION['id'] = $results[0]['id'];
    } else {
        $_SESSION['loginerror'] = TRUE;
    }
} else {
    $_SESSION['loginerror'] = TRUE;
}

// Redirect user to index page.
header('Location: index.php');
exit();
