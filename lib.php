<?php

require 'config.php';

/**
 * Queries the database.
 * 
 * Accepts an array of parameters where the first parameter
 * is the SQL query and subsequent parameters are variables
 * to be inserted into the query.
 *
 * @global $pdo The database connection object.
 *
 * @param $args {
 *      $sql The SQL string (with '?' placeholders if needed)
 *      $param1 Optional.
 *      $param2 Optional.
 *      ... The list of parameters to be inserted into SQL statement
 * }
 *
 * @return array A two-dimensional array of the rows retrieved
 **/

function query_db($args) {
    // Use the PDO object defined in config.php
    global $pdo;

    // Verify that the argument passed into the function is an array
    if(!is_array($args)) {
        exit("Argument is not an array.");
    }

    // Prepare the SQL statement and exit if the provided SQL is invalid
    if(!($sth = $pdo->prepare($args[0]))) {
        exit("SQL query provided is invalid.");
    }

    // Verify that the number of arguments passed matches the
    // number of placeholders in the query
    if(strlen($args[0]) - strlen(str_replace(str_split('?'), '', $args[0])) != (sizeof($args) - 1)) {
        exit("Number of arguments provided does not match number of placeholders in SQL query.");
    }

    // Remove the SQL string from the array so remaining values 
    // can be passed into SQL statement
    unset($args[0]);

    // Set the statement handler object to return an associative array
    $sth->setFetchMode(PDO::FETCH_ASSOC);

    // If the args array still has any values, use them to prepare the SQL statement
    if(sizeof($args) > 0) {
        $sth->execute(array_values($args));
    } else {
        $sth->execute();
    }

    return $sth->fetchAll();
}

/**
 * Generates a new SSH config file.
 *
 * Rebuilds the www-data SSH config file with current values from the clients table.
 * This function should be called after any changes are made to the clients table.
 *
 * @return boolean A value for success or failure.
 * */

function build_ssh_config() {
    // Use the PDO object defined in config.php
    global $pdo;

    // Set return value
    $success = false;

    // Query database to retrieve all relevant info from the clients table
    $sql = "SELECT ssh_alias, ip_address, ssh_username, ssh_key_name FROM clients";
    $results = query_db(array($sql));

    // Declare SSH config file path and key file path
    $file_path = "/home/www-data/.ssh/config";
    $backup_file_path = "/home/www-data/.ssh/config.bak";
    $key_path = "/home/www-data/.ssh/keys/";

    // If SSH config file already exists, rename it to make room for the new one
    if(file_exists($file_path)) {
        if(!rename($file_path, $backup_file_path)) {
            exit("Could not move SSH config file.");
        }
    }

    // Create new SSH config file and get the file handler object for it
    $fh = fopen($file_path, 'w');

    // Loop through the results and create an SSH config file entry for each
    foreach($results as $client) {
        $data = "Host " . $client['ssh_alias'] . "\n";
        $data .= "\tHostName\t " . $client['ip_address'] . "\n";
        $data .= "\tUser\t\t " . $client['ssh_username'] . "\n";
        $data .= "\tIdentityFile " . $key_path . $client['ssh_key_name'] . "\n\n";

        if(fwrite($fh, $data)) {
            $success = true;
        }
    }

    // Close the file when finished
    fclose($fh);

    return $success;
}
