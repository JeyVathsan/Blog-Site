<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM posts WHERE user_id = '".$_SESSION['user_id']."' ORDER BY created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="Assets/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .post-content {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .post-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>This is your dashboard.</p>
        <a href="create_post.php" class="btn btn-success">Create New Post</a>
        <a href="index.php" class="btn btn-info">View Blog Posts</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>

        <h3>Your Posts:</h3>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="post">
                    <?php if (!empty($row['image_url'])): ?>
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="post-image" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <?php endif; ?>
                    <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                    <p class="post-content"><?php echo nl2br(htmlspecialchars(substr($row['content'], 0, 200))); ?>...</p>
                    <a href="view_post.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Read More</a>
                    <hr>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
