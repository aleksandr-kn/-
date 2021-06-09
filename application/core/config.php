<?php
// Database credentials. 

function create_connection()
{
    $credentials = parse_ini_file(ROOTPATH . "/application/database/connect.ini");

    /* Attempt to connect to PostgreSQL database */
    $db = pg_connect("host={$credentials['host']} port={$credentials['port']} dbname={$credentials['db']} user={$credentials['user']} password={$credentials['password']}");

    // Check connection
    if ($db === false) {
        die("ERROR: Could not connect. ");
    }

    return $db;
}
