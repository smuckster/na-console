<?php

session_start();
session_destroy();

// Return to the login page
header('Location: login.php');
