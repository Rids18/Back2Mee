<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        die("Please log in to report a found item.");
    }

    $user_id = $_SESSION['user_id'];
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $found_date = $_POST['found_date'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("INSERT INTO found_items (user_id, item_name, description, found_date, location) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $item_name, $description, $found_date, $location);

    if ($stmt->execute()) {
        echo "Found item reported successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Report Found Item</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <h2 class="text-2xl font-semibold text-center">Report Found Item</h2>
    <form action="report_found.php" method="POST" class="max-w-lg mx-auto bg-white p-6 shadow-lg rounded-lg">
        <input type="text" name="item_name" placeholder="Item Name" required class="w-full p-2 mb-2 border rounded">
        <textarea name="description" placeholder="Description" required class="w-full p-2 mb-2 border rounded"></textarea>
        <input type="date" name="found_date" required class="w-full p-2 mb-2 border rounded">
        <input type="text" name="location" placeholder="Location Found" required class="w-full p-2 mb-2 border rounded">
        <button type="submit" class="w-full bg-green-600 text-white p-2 rounded">Report Found Item</button>
    </form>
</body>
</html>
