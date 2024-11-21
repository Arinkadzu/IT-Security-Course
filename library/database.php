<?php
require_once 'config.php';

// Establish a connection using MySQLi
$dbConn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, 3306);
if (!$dbConn) {
    die('Connection failed: ' . mysqli_connect_error());
}
// Function to execute a query
function dbQuery($sql)
{
    global $dbConn;
    $result = mysqli_query($dbConn, $sql) or die(mysqli_error($dbConn));
    return $result;
}

// Function to get the number of affected rows
function dbAffectedRows()
{
    global $dbConn;
    return mysqli_affected_rows($dbConn);
}

// Fetch a result row as an array
function dbFetchArray($result, $resultType = MYSQLI_NUM)
{
    return mysqli_fetch_array($result, $resultType);
}

// Fetch a result row as an associative array
function dbFetchAssoc($result)
{
    return mysqli_fetch_assoc($result);
}

// Fetch a result row as a numeric array
function dbFetchRow($result)
{
    return mysqli_fetch_row($result);
}

// Free the memory associated with a result
function dbFreeResult($result)
{
    return mysqli_free_result($result);
}

// Get the number of rows in a result
function dbNumRows($result)
{
    return mysqli_num_rows($result);
}

// Select a different database
function dbSelect($dbName)
{
    global $dbConn;
    return mysqli_select_db($dbConn, $dbName);
}

// Get the last inserted ID
function dbInsertId()
{
    global $dbConn;
    return mysqli_insert_id($dbConn);
}
?>
