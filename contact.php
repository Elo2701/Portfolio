<?php
// Include MongoDB library
require 'vendor/autoload.php';

// Connect to MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");

// Select database and collection
$collection = $client->CONTACT->INFO_CONT;

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["Name"];
    $email = $_POST["Email"];
    $subject = $_POST["Subject"];
    $message = $_POST["Message"];

    // Insert data into MongoDB collection
    $result = $collection->insertOne([
        'Name' => $name,
        'Email' => $email,
        'Subject' => $subject,
        'Message' => $message
    ]);

    // Check if data was inserted successfully
    if ($result->getInsertedCount() > 0) {
        // Send email notification
        $to = "elonyati@gmail.com";
        $subject = "New message received";
        $body = "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message";
        $headers = "From: your_email@example.com";

        if (mail($to, $subject, $body, $headers)) {
            echo "Message sent successfully!";
        } else {
            echo "Error sending message.";
        }
    } else {
        echo "Error inserting data into MongoDB.";
    }
}
?>
