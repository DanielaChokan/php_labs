<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Book List</title>
</head>

<body>

    <h2>Book List</h2>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Description</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td>
                        <a href="index.php?book=<?php echo urlencode($book->title); ?>">
                            <?php echo htmlspecialchars($book->title); ?>
                        </a>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($book->author); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($book->description); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>