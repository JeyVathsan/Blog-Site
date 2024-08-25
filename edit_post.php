<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $conn->real_escape_string($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id='$id' AND user_id='".$_SESSION['user_id']."'";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_post.php?id=$id");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
} else {
    $sql = "SELECT * FROM posts WHERE id='$id' AND user_id='".$_SESSION['user_id']."'";
    $result = $conn->query($sql);
    $post = $result->fetch_assoc();
    if (!$post) {
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="Assets/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Post</h2>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form action="edit_post.php?id=<?php echo $id; ?>" method="POST">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
        <a href="view_post.php?id=<?php echo $id; ?>" class="btn btn-secondary mt-3">Cancel</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
