<?php
include 'db_connect.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back2Me</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-200">
    <header class="bg-purple-700 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Back2Me</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="index.php" class="hover:underline">Home</a></li>
                    <li><a href="report_lost1.php" class="hover:underline">Report Lost Item</a></li>
                    <li><a href="report_found.php" class="hover:underline">Report Found Item</a></li>
                    <li><a href="search.php" class="hover:underline">Search</a></li>
                    <li><a href="contact.php" class="hover:underline">Contact</a></li>
                </ul>
            </nav>
            <div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Logout</a>
                <?php else: ?>
                    <a href="login1.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <section class="hero bg-purple-600 text-white text-center py-16">
        <h2 class="text-4xl font-semibold">Find Your Lost Items</h2>
        <p class="mt-2">Report or search for lost and found items easily.</p>
        <div class="mt-4 flex justify-center">
            
            <button onclick="window.location.href='search.php'" class="bg-yellow-500 px-4 py-2 rounded-r-md font-semibold hover:bg-yellow-600">Search</button>
        </div>
    </section>
    
    <section class="recent-items container mx-auto my-10 p-6 bg-gray-800 shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Recently Found Items</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php
                $found_items = $conn->query("SELECT item_name, location, created_at FROM found_items ORDER BY created_at DESC LIMIT 6");
                while ($row = $found_items->fetch_assoc()):
            ?>
                <div class="p-4 bg-gray-700 rounded-lg shadow">
                    <h3 class="text-lg font-bold"> <?= htmlspecialchars($row['item_name']) ?> </h3>
                    <p class="text-gray-300">Found at: <?= htmlspecialchars($row['location']) ?></p>
                    <p class="text-sm text-gray-400">Reported on: <?= date("F j, Y, g:i a", strtotime($row['created_at'])) ?></p>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center mt-4">
            <a href="found_items_list.php" class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800">View More</a>
        </div>
    </section>

    <section class="recent-items container mx-auto my-10 p-6 bg-gray-800 shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Recently Lost Items</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php
                $lost_items = $conn->query("SELECT item_name, location, created_at FROM lost_items ORDER BY created_at DESC LIMIT 6");
                while ($row = $lost_items->fetch_assoc()):
            ?>
                <div class="p-4 bg-gray-700 rounded-lg shadow">
                    <h3 class="text-lg font-bold"> <?= htmlspecialchars($row['item_name']) ?> </h3>
                    <p class="text-gray-300">Lost at: <?= htmlspecialchars($row['location']) ?></p>
                    <p class="text-sm text-gray-400">Reported on: <?= date("F j, Y, g:i a", strtotime($row['created_at'])) ?></p>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center mt-4">
            <a href="lost_items_list.php" class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800">View More</a>
        </div>
    </section>
    
    <footer class="bg-gray-900 text-gray-400 text-center py-4 mt-10">
        <p>&copy; 2025 Back2Me. All rights reserved.</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>
