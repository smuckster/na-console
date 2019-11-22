<?php

require 'config.php';
require 'lib.php';

session_start();

// If user is not logged in already, redirect them to the login page
if(!isset($_SESSION['loggedin'])) {
    ob_start();
    header('Location: login.php');
    ob_end_flush();
    die();
}

// Begin rendering the page
include 'html/header.html';

// Left navigation menu
echo "<div class='left-nav'>";
echo "<div class='left-nav-content default-skin'>";

// Fill nav menu with list of clients
$sql = "SELECT * FROM clients GROUP BY name ASC";
$results = query_db(array($sql));
echo "<div class='left-nav-heading'>Clients (" . sizeof($results) . ")";
echo "<i class='fas fa-chevron-down'></i></div>";
echo "<i class='fas fa-plus-circle' id='add-client-button'></i>";
echo "<div class='speech-bubble'>Add a new client</div>";

// Begin client menu
echo "<div class='client-menu toggle-menu'>";
foreach($results as $result) {
    echo "<div class='client-menu-item' data-id='" . $result['id'] . "' data-name='" . $result['ssh_alias'] . "'>" . $result['name'] . "</div>";
}
// Close client menu and left nav divs
echo "</div></div></div>";

// Top navigation menu
echo "<div class='top-nav'>";
echo "<div class='logo-container'>";
echo "<h3 class='logo'>eClass4Learning</h3>";
echo "<p class='logo-text'>Network Administration Console</p></div>";
echo "<div class='top-nav-button' id='nav-profile-button'><i class='fas fa-user-circle'></i></div>";
echo "</div>";

echo "<div id='nav-profile-menu'>";
echo "<a class='profile-menu-item' href='profile.php' target='_self'>Profile</a>";
echo "<a class='profile-menu-item' href='logout.php' target='_self'>Logout</a></div>";

// Main page frame
echo "<div class='main-frame'>";

/* Fill the main frame with different content depending on which page the user requested
if(isset($_GET['page']) && $_GET['page'] != '') {
    switch($_GET['page']) {
        case 'profile':
            include "pages/profile.php";
            break;
        case 'client':
            include "pages/client.php";
            break;
    }
} else {
    // Load the dashboard
    include "pages/dashboard.php";
}*/
include "pages/dashboard.php";


// Close main page frame div
echo "</div>";

// Finish rendering the page
include 'html/footer.html';
