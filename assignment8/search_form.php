<html>
<head><link rel="stylesheet" href="style.css"></head>
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

        $results = [];
        $titleQuery = isset($_GET['title']) ? trim($_GET['title']) : '';
        $yearQuery = isset($_GET['year']) ? trim($_GET['year']) : '';

        $messages = [];

        // fetch rsearch results
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
            // messages only show after button is pressed
            if ($titleQuery === '' && $yearQuery === '') {
                $messages[] = "Please fill out at least one field.";
            } elseif ($yearQuery !== '' && !is_numeric($yearQuery)) {
                $messages[] = "Year must be a number.";
            } else { // run query
                $conditions = [];
                $params = [];
        
                if ($titleQuery !== '') {
                    $conditions[] = "title LIKE ?";
                    $params[] = "%$titleQuery%";
                }
        
                if ($yearQuery !== '') {
                    $conditions[] = "year = ?";
                    $params[] = $yearQuery;
                }
        
                $sql = "SELECT * FROM movies";
                if (!empty($conditions)) {
                    $sql .= " WHERE " . implode(" AND ", $conditions);
                }
                $sql .= " ORDER BY title ASC";
        
                $stmt = $db->prepare($sql);
                $stmt->execute($params);
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        ?>

        <!--error message -->
        <?php if (!empty($messages)): ?>
            <div class="message">
                <?php foreach ($messages as $message): ?>
                    <p><?= htmlspecialchars($message) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- search form -->
        <form method="GET">
            <label>Title: <input type="text" name="title" value="<?= htmlspecialchars($titleQuery) ?>"></label><br>
            <label>Year: <input type="text" name="year" value="<?= htmlspecialchars($yearQuery) ?>"></label><br>
            <br>
            <input class="button" type="submit" name="search" value="Search">
        </form>

        <!-- display search results -->
        <?php if ($titleQuery !== '' || $yearQuery !== ''): ?>
            <?php if ($results): ?>
                <ul id="searchResults">
                    <?php foreach ($results as $row): ?>
                        <li><?= htmlspecialchars($row['title']) ?> (<?= $row['year'] ?>)</li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No results found.</p>
            <?php endif; ?>
        <?php endif; ?>

        <?php?>
</body>
</html>