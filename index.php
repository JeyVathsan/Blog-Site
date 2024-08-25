<?php
session_start();
include 'db.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch all blog posts
$sql = "SELECT * FROM posts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/style.css">
</head>
<body>
    <div class="container mt-5">
        <h2>My Blog Posts</h2>

        <!-- Navigation Buttons -->
        <div class="mb-3">
            <?php if (!isset($_SESSION['username'])): ?>
                <a href="login.php" class="btn btn-primary">Login</a>
                <a href="signup.php" class="btn btn-secondary"  style="background-color:white; color:black">Sign Up</a>
            <?php else: ?>
                <a href="create_post.php" class="btn btn-success">Create New Post</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            <?php endif; ?>
        </div>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card mb-3 post-card fade-in" data-id="<?php echo $row['id']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                        <?php if (!empty($row['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="img-fluid mb-3" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <?php endif; ?>
                        <p class="card-text post-content"><?php echo htmlspecialchars($row['content']); ?></p>
                        <a href="view_post.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No blog posts found.</p>
        <?php endif; ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="Assets/script.js"></script>
</body>
</html>
