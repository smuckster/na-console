<?php

include "../lib.php";

// Get all client information
$sql = "SELECT * FROM clients WHERE id = ?";
$results = query_db(array($sql, (string)$_POST['client']));
$client = $results[0];

// Begin client container div
echo "<div class='client-container'>";

// Begin client heading container
echo "<div class='client-heading-container'>";
echo "<span class='client-heading'>". $client['name'] . "</span>";
if($client['alt_name'] != '') {
    echo "<span class='client-heading-secondary'>(" . $client['alt_name'] . ")</span>";
}
echo "<span class='edit-button'>Edit Client Information</span>";
echo "</div>";

// Display client information
echo "<div class='client-info-container'>";
// Begin left column
echo "<div class='left-col'>";
echo "<p>Production URL: <a href='" . $client['production_url'] . "' target='_blank'>" . $client['production_url'] . "</a></p>";
echo "<p>Test URL: <a href='" . $client['test_url'] . "' target='_blank'>" . $client['test_url'] . "</a></p>";
echo "<p>Type of site: " . $client['site_type'] . "</p>";
echo "<p>Version: " . $client['site_version'] . "</p>";
echo "<p>Contact: " . $client['contact_name'] . "<a href='mailto:" . $client['contact_email'] . "'>(" . $client['contact_email'] . ")</a></p>";
echo "</div>";

// Begin right column
echo "<div class='right-col'>";
echo "<p>Instance ID: " . $client['instance_id'] . "</p>";
echo "<p>Server version: Ubuntu Server " . $client['server_version'] . "</p>";
echo "<p>PHP version: " . $client['php_version'] . "</p>";
echo "<p>Database: " . $client['database_name'] . "</p>";
echo "<p>SSL management: " . $client['ssl_mgmt'] . "</p>";
echo "</div>";

echo "<div class='client-notes'><h3>Notes:</h3><p>" . $client['notes'] . "</p></div>";
echo "<div class='upgrade-history'><h3>Upgrade history:</h3><p>" . $client['upgrade_history'] . "</p></div>";

// End client information
echo "</div>";

// Begin hidden form that replaces client info container when edit button is clicked
echo "<div class='client-edit-container'>";
echo "<form id='client-edit-form' method='post'>";
echo "<div class='form-contents'>";
echo "<div class='left-col'>";
echo "<label for='production_url'>Production URL:</label>";
echo "<input type='text' name='production_url' id='production_url' placeholder='{$client['production_url']}'><br>";
echo "<label for='test_url'>Test URL:</label>";
echo "<input type='text' name='test_url' id='test_url' value='{$client['test_url']}'><br>";
echo "<label for='site_type'>Type of site:</label>";
echo "<input type='text' name='site_type' id='site_type' value='{$client['site_type']}'><br>";
echo "<label for='site_version'>Version:</label>";
echo "<input type='text' name='site_version' id='site_version' value='{$client['site_version']}'><br>";
echo "<label for='contact_name'>Contact name:</label>";
echo "<input type='text' name='contact_name' id='contact_name' value='{$client['contact_name']}'><br>";
echo "<label for='contact_email'>Contact email:</label>";
echo "<input type='text' name='contact_email' id='contact_email' value='{$client['contact_email']}'><br>";
echo "</div>";
echo "<div class='right-col'>";
echo "<label for='instance_id'>Instance ID:</label>";
echo "<input type='text' name='instance_id' id='instance_id' value='{$client['instance_id']}'><br>";
echo "<label for='server_version'>Server version:</label>";
echo "<input type='text' name='server_version' id='server_version' value='{$client['server_version']}'><br>";
echo "<label for='database_name'>Database:</label>";
echo "<input type='text' name='database_name' id='database_name' value='{$client['database_name']}'><br>";
echo "<label for='ssl_mgmt'>SSL management:</label>";
echo "<input type='text' name='ssl_mgmt' id='ssl_mgmt' value='{$client['ssl_mgmt']}'><br>";
echo "</div></div>";
echo "<input type='submit' class='save-button' value='Save Changes'>";
echo "</form></div>";

// Begin the module grid
echo "<div id='module-grid'>";

// Get all modules
// Searches the python directory for files (ignoring directories), gets those filenames as a list,
// and iterates over them to create boxes on the main screen, with each script name as the id
$modules = preg_split('/[\s]+/', shell_exec("ls -pr ../mod | grep -v / | column"));

for($i = 0; $i<count($modules)-1; $i++) {
    echo "<div class='module' id='".substr($modules[$i], 0, -4)."'></div>";
}

// End client container and module grid divs
echo "</div></div>";
