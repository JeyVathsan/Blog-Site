<?php
session_start();
include 'db.php';

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT * FROM posts WHERE id='$id'";
    $result = $conn->query($sql);
    $post = $result->fetch_assoc();
    if (!$post) {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

// Check if the current user is the author of the post
$isAuthor = isset($_SESSION['user_id']) && $post['user_id'] == $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="Assets/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <?php if (!empty($post['image_url'])): ?>
            <img src="<?php echo htmlspecialchars($post['image_url']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($post['title']); ?>">
        <?php endif; ?>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        <a href="index.php" class="btn btn-secondary">Back to Blog Posts</a>
        
        <?php if ($isAuthor): ?>
            <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-warning">Edit Post</a>
            <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete Post</a>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
