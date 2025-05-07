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

        $message = '';

        // handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $year = $_POST['year'];

            if ($title && is_numeric($year)) {
                $stmt = $db->prepare("INSERT INTO movies (title, year) VALUES (?, ?)");
                $stmt->execute([$title, $year]);
                $message = "Movie was added successfully!";
            } else {
                $message = "Please enter a valid title and year.";
            }
        }
        ?>
        
        <!-- confirmation message -->
        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message)?></p>
        <?php endif; ?>

        <!--add form-->
        <form method="POST">
            <label>Title: <input type="text" name="title"></label><br>
            <label>Year: <input type="text" name="year"></label><br>
            <br>
            <input class="button" type="submit" value="Save">
        </form>

        <?php?>
</body>
</html>

