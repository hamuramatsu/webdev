<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Movie Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>My Movie Database</h1>
        <nav>
            <div id="viewAll">
                <a href="index.php">View All</a>
            </div>
            <div id="addMovie">
                <a href="add_form.php">Add Movie</a>
            </div>
            <div id="searchMovies">
                <a href="search_form.php">Seach Movies</a>
            </div>
        </nav>
    </header>

    <?php
        require 'db.php';
        $message = '';

        // handle deletion
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
            $id = $_POST['delete_id'];
            $stmt = $db->prepare("DELETE FROM movies WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Movie deleted successfully.";
        }
        
        // fetch all records
        $movies = $db->query("SELECT * FROM movies ORDER BY title ASC")->fetchAll(PDO::FETCH_ASSOC);
        ?>
        
        <!-- deleted message -->
        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        
        <!--table-->
        <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Year</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <!-- list movies -->
            <?php if (count($movies) > 0): ?>
                <?php foreach ($movies as $movie): ?>
                    <tr>
                        <td><?= htmlspecialchars($movie['title']) ?></td>
                        <td><?= htmlspecialchars($movie['year']) ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="delete_id" value="<?= $movie['id'] ?>">
                                <button class="button" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align:center;">No movies found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        </table>

    <?php?>
    
</body>
</html>
