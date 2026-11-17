<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Book Catalog</title>

    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <div class="container">

        <h1>Book Catalog</h1>

        <form action="index.php" method="GET" class="search-form">

            <input type="text" name="search" placeholder="Search by book title or author..."
                value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>">

            <button type="submit">Search</button>

            <a href="index.php" class="reset-button">Show all</a>

        </form>

        <h2>Available Books</h2>

        <?php if (count($books) > 0): ?>

            <div class="book-grid">

                <?php foreach ($books as $book): ?>

                    <div class="book-card">

                        <img src="<?php echo htmlspecialchars($book['cover_path'] ?: 'assets/no-cover.svg', ENT_QUOTES, 'UTF-8'); ?>"
                            alt="Book cover" class="book-cover">

                        <div class="book-info">

                            <h3>
                                <?php echo htmlspecialchars($book['title']); ?>
                            </h3>

                            <p>
                                <strong>Author:</strong>
                                <?php
                                echo htmlspecialchars(
                                    $book['first_name'] . ' ' . $book['last_name']
                                );
                                ?>
                            </p>

                            <p>
                                <strong>Year:</strong>
                                <?php echo htmlspecialchars((string) $book['publication_year']); ?>
                            </p>

                            <p>
                                <strong>Pages:</strong>
                                <?php echo htmlspecialchars((string) $book['pages']); ?>
                            </p>

                            <a href="index.php?id=<?php echo (int) $book['id']; ?>" class="details-button">
                                View details
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <p class="empty-message">
                No books found.
            </p>

        <?php endif; ?>

    </div>

</body>

</html>