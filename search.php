<?php
include 'db_connect.php';

$search_query = $_GET['query'] ?? '';
$results = [];

if (!empty($search_query)) {
    $stmt = $conn->prepare("SELECT * FROM lost_items WHERE item_name LIKE ? UNION SELECT * FROM found_items WHERE item_name LIKE ?");
    $search_param = "%" . $search_query . "%";
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Lost & Found Items</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <h2 class="text-2xl font-semibold text-center">Search Items</h2>
    <form action="search.php" method="GET" class="max-w-lg mx-auto flex">
        <input type="text" name="query" placeholder="Enter item name..." class="w-full p-2 border rounded-l">
        <button type="submit" class="bg-blue-600 text-white p-2 rounded-r">Search</button>
    </form>

    <div class="max-w-lg mx-auto mt-4">
        <?php if (!empty($results)): ?>
            <h3 class="text-xl font-semibold">Search Results:</h3>
            <?php foreach ($results as $item): ?>
                <p><?= htmlspecialchars($item['item_name']) ?> - <?= htmlspecialchars($item['location']) ?></p>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500">No items found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
