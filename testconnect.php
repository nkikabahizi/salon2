<?php
$host = 'localhost'; // Hostname
$dbname = 'salon'; // Database name
$username = 'root'; // Your database username
$password = ''; // Your database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // You can now use the $pdo object to execute queries and interact with the database
    
    // Example: Select all rows from a table named "customers"
    $query = $pdo->query("SELECT * FROM customers");
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        // Process each row
        $customerName = $row['name'];
        $customerEmail = $row['email'];
        echo "Name: $customerName, Email: $customerEmail<br>";
    }
    
    // Don't forget to close the connection when you're done
    $pdo = null;
} catch (PDOException $e) {
    // If there's an error, handle it gracefully
    echo "Connection failed: " . $e->getMessage();
}
?>