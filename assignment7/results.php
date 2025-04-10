<!DOCTYPE html>
<head>
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

        .bar {
        height: 30px;
        padding: 10px;
        margin: 10px 0;
        color: black;
        border-radius: 8px;
        }
    </style>
</head>
<body>
    <h1>Simpsons Quiz Results</h1>

    <?php
        // define our path
        include("config.php");

        $file = "$path/quizdata.txt";
        if (!file_exists($file)) {
            print "<p>No submissions yet.</p>";
        } else {

            // open the file for reading
            $data = file_get_contents($file);
            // isolate each line from the file

            $lines = explode("\n", $data);

            $lines = file($file, FILE_IGNORE_NEW_LINES);
            $total = count($lines);
            $counts = array_count_values($lines);

            $characters = ['Homer', 'Marge', 'Bart', 'Lisa'];

            $charColors = [
                "Homer" => "#fdd835",  // yellow
                "Marge" => "#64b5f6",  // blue
                "Bart"  => "#ef5350",  // red
                "Lisa"  => "#ba68c8"   // purple
            ];

            print "<p>Total number of quiz submissions: $total</p>";

            foreach ($characters as $char) {
                $count = $counts[$char] ?? 0;
                $percent = $total > 0 ? ($count / $total) * 100 : 0;
                $width = intval($percent * 6); // scale width visually
                $color = $charColors[$char] ?? "#ccc";

                print "<div class='bar' style='width:{$width}px; background:$color;'>$char: " . round($percent) . "%</div>";
            }
    }
        
    ?>
    <div class="pageLink">
        <a href="index.php">Back to Quiz</a>
    </div>

</body>