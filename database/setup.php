<?php

// Check if mysqli extension is loaded
if (!extension_loaded('mysqli')) {
    die("Error: The mysqli extension is not loaded. Please enable it in your php.ini file.\n");
}

$config = require_once __DIR__ . '/../config/database.php';

// Connect to MySQL server
$conn = new mysqli($config['host'], $config['username'], $config['password']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\nPlease check your database credentials in config/database.php\n");
}

// Create database if it doesn't exist
$dbname = $config['dbname'];
$sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";
if ($conn->query($sql) === TRUE) {
    echo "Database '$dbname' created successfully or already exists.\n";
} else {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Read the SQL schema
$schema = file_get_contents(__DIR__ . '/schema.sql');

// Execute the multi-query
if ($conn->multi_query($schema)) {
    do {
        // Store first result set
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->next_result());
    echo "Tables created successfully.\n";
} else {
    die("Error creating tables: " . $conn->error);
}

echo "\nDatabase setup complete!\n";
$conn->close();

