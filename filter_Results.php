<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtered Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Filtered Results</h1>
        <?php
// Assume you have already established a database connection
include('connect.php');

// Get the selected category from the URL parameter
$selectedCategory = $_GET['category'];

// Validate the selected category
$validCategories = array("all", "technology", "science", "sports");
if (!in_array($selectedCategory, $validCategories)) {
    die("Invalid category selected.");
}

// Prepare the SQL query based on the selected category
if ($selectedCategory === 'all') {
    $sql = "SELECT * FROM articles";
} else {
    $sql = "SELECT * FROM articles WHERE category = ?";
}

// Prepare the statement
$stmt = mysqli_prepare($conn, $sql);

// Bind the parameter if necessary
if ($selectedCategory !== 'all') {
    mysqli_stmt_bind_param($stmt, "s", $selectedCategory);
}

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result set
$result = mysqli_stmt_get_result($stmt);

// Display the results
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="mb-3">';
    echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
    echo '<p>' . htmlspecialchars($row['content']) . '</p>';
    echo '</div>';
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

    </div>
</body>

</html>
