<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assignment 7</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }

        body {
            margin-top: 3em;
            margin-left: 4em;
            font-family: Helvetica, Arial;
        }

        h1 {
            margin-bottom: 1em;
            margin-right: auto;
            width: 17%;
            color: white;
            padding: 1.5rem;
            background-color: black;
            border-radius: 10px;
        }

        h2 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 0.5em;
        }

        form {
            margin-left: 1em;
        }

        select {
            margin-bottom: 2em;
        }

        .button {
            padding: 5px;
            border: 5px solid black;
            border-radius: 10px;
            background: none;
            font-size: 16px;
            font-weight: bold;
        }

        .button:hover {
            font-style: italic;
        }

        .result {
            /* margin-bottom: 1em; */
            margin-right: auto;
            width: 16.3%;
            padding: 1.5rem;
            text-align: center;
            border: 5px solid black;
            border-radius: 10px;
        }

        .pageLink {
            margin-top: 1em;
        }

        a {
            text-decoration: none;
            color: black;
        }

        a:hover {
            font-weight: bold;
        }

        img {
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>Which Simpson Character Am I?</h1>

    <?php
        // clear cookie if user clicked "try again"
        if (isset($_GET['reset'])) {
            setcookie('result', "");
            header("Location: index.php");
            exit();
        }

        // error - user did not supply valid data
        if (isset($_GET["error"]) && $_GET["error"] == "missing"){
            print "<p style='color:red;'>Please answer every question!</p>";
        }

        // show result if cookie is set
        if (isset($_COOKIE['result'])) {
            $character = $_COOKIE['result'];
            print "<div class='result'>";
            print "<h2>You are $character!</h2>";
            print "<img src='assignment07_images/$character.png' alt='$character' style='max-width:300px'>";
            print "<br><a href='?reset=true'>Try Again?</a>";
            print "</div>";
        } else { // show form if no cookie
            ?>
            <form action="processresults.php" method="POST">
                <h2>What's your ideal job?</h2>
                <select name="job" id="job">
                    <option value="default">Select a job</option>
                    <option value="bakery">Working at a bakery</option>
                    <option value="tutor">French tutor</option>
                    <option value="prank">Prank phone call specialist</option>
                    <option value="professor">College professor</option>
                </select>
                <h2>What's your favorite job?</h2>
                <select name="food" id="food">
                    <option value="default">Select a food</option>
                    <option value="donuts">Donuts</option>
                    <option value="pie">Apple pie</option>
                    <option value="flakes">Krusty flakes</option>
                    <option value="organic">Anything organic and locally sourced</option>
                </select>
                <h2>What's your favorite hobby?</h2>
                <select name="hobby" id="hobby">
                    <option value="default">Select a hobby</option>
                    <option value="tv">Watching TV</option>
                    <option value="knitting">Knitting</option>
                    <option value="skateboarding">Skateboarding</option>
                    <option value="reading">Reading</option>
                </select>
                <h2>What's your biggest fear?</h2>
                <select name="fear" id="fear">
                    <option value="default">Select a fear</option>
                    <option value="sock">Sock Puppets</option>
                    <option value="flying">Flying</option>
                    <option value="fearless">I'm fearless, man</option>
                    <option value="school">Getting anything below an A in school</option>
                </select>
                <br>
                <input class="button" name="submit" type="submit" value="What Simpson Character Am I?">
            </form>
            <?php
        }
        ?>
    
    <br>
    <div class="pageLink">
        <a href="results.php">See Aggregate Results</a>
    </div>
</body>
</html>