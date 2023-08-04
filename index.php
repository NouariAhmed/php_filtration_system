<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>Filter System</h1>
        <form id="filterForm" class="mb-3">
            <div class="mb-3">
                <label for="category" class="form-label">Select Category:</label>
                <select name="category" id="category" class="form-select">
                    <option value="all">All</option>
                    <option value="technology">Technology</option>
                    <option value="science">Science</option>
                    <option value="sports">Sports</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Apply Filter</button>
        </form>
        <h2>All Items</h2>
        <div id="filterResults">
            <?php
            // Assume you have already established a database connection
            include('connect.php');

            // Fetch all items from the database
            $sql = "SELECT * FROM articles";
            $result = mysqli_query($conn, $sql);

            // Display all items
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="mb-3">';
                echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
                echo '<p>' . htmlspecialchars($row['content']) . '</p>';
                echo '</div>';
            }

            // Close the connection
            mysqli_close($conn);
            ?>
        </div>
    </div>

    <script>
        // Submit the form using AJAX when the user selects a category
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            const selectedCategory = $('#category').val();
             // Validate selected category (recommended)
             if (!["all", "technology", "science", "sports"].includes(selectedCategory)) {
                alert("Invalid category selection.");
                return;
            }
            $.ajax({
                type: 'GET',
                url: 'filter_Results.php',
                data: { category: selectedCategory },
                success: function (data) {
                    $('#filterResults').html(data);
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
</body>

</html>
