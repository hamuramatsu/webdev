<?php

      // only run this code if the user has submitted the form
      if ($_POST['submit']) {

        // validate our incoming variables
        $job = $_POST['job'];
        $food = $_POST['food'];
        $hobby = $_POST['hobby'];
        $fear = $_POST['fear'];


        // everything looks good!
        if ($job != 'default' && $food != 'default' && $hobby != 'default' && $fear != 'default') {
          include('config.php');

          // character scores
          $scores = [
            'Homer' => 0,
            'Marge' => 0,
            'Bart' => 0,
            'Lisa' => 0
          ];

          // scoring
          if ($job === 'tv') $scores['Homer']++;
          if ($job === 'knitting') $scores['Marge']++;
          if ($job === 'skateboarding') $scores['Bart']++;
          if ($job === 'reading') $scores['Lisa']++;

          if ($job === 'bakery') $scores['Marge']++;
          if ($job === 'tutor') $scores['Lisa']++;
          if ($job === 'prank') $scores['Bart']++;
          if ($job === 'professor') $scores['Homer']++; //??

          if ($food === 'donuts') $scores['Homer']++;
          if ($food === 'pie') $scores['Marge']++;
          if ($food === 'flakes') $scores['Bart']++;
          if ($food === 'organic') $scores['Lisa']++;

          if ($fear === 'sock') $scores['Marge']++;
          if ($fear === 'flying') $scores['Homer']++;
          if ($fear === 'fearless') $scores['Bart']++;
          if ($fear === 'school') $scores['Lisa']++;

          // highest score
          $character = array_keys($scores, max($scores))[0];

          // ADD COOKIE: save client's last color choice
          setcookie('result', $character); 

          // result data
          $data = "$character\n";

          // put the info into text file 
          file_put_contents($path . "/quizdata.txt", $data, FILE_APPEND);

          // // print out result
          // print $data;

          // Redirect back to index
          header("Location: index.php");
          exit();

        } else {  // user did not fill
          header('Location: index.php?error=missing');
          exit();
        }
      }

?>