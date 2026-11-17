<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo htmlspecialchars($book['title']); ?>
    </title>

    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <div class="container">

        <h1>Book Information</h1>

        <div class="details-card">

            <img src="<?php echo htmlspecialchars($book['cover_path'] ?: 'assets/no-cover.svg', ENT_QUOTES, 'UTF-8'); ?>"
                alt="Book cover" class="details-cover">

            <div class="details-info">

                <h2>
                    <?php echo htmlspecialchars($book['title']); ?>
                </h2>

                <p>
                    <strong>Author:</strong>
                    <?php
                    echo htmlspecialchars(
                        $book['first_name'] . ' ' . $book['last_name']
                    );
                    ?>
                </p>

                <p>
                    <strong>Country:</strong>
                    <?php echo htmlspecialchars($book['country']); ?>
                </p>

                <p>
                    <strong>Publication year:</strong>
                    <?php echo htmlspecialchars((string) $book['publication_year']); ?>
                </p>

                <p>
                    <strong>Number of pages:</strong>
                    <?php echo htmlspecialchars((string) $book['pages']); ?>
                </p>

                <p>
                    <strong>Description:</strong>
                </p>

                <p>
                    <?php echo nl2br(htmlspecialchars($book['description'] ?? '')); ?>
                </p>

            </div>

        </div>

        <a href="index.php" class="back-button">
            Back to book list
        </a>

    </div>

</body>

</html>