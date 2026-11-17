<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Book Details</title>
</head>

<body>

    <h2>Book Information</h2>

    <p>
        <strong>Title:</strong>
        <?php echo htmlspecialchars($book->title); ?>
    </p>

    <p>
        <strong>Author:</strong>
        <?php echo htmlspecialchars($book->author); ?>
    </p>

    <p>
        <strong>Description:</strong>
        <?php echo htmlspecialchars($book->description); ?>
    </p>

    <a href="index.php">Back to book list</a>

</body>

</html>