<?php

require 'vendor/autoload.php';

$url = 'https://en.wikipedia.org/wiki/Online_advertising';

// Instantiate the library
$web = new \spekulatius\phpscraper();

// Navigate to the test page.
$web->go($url);

// check the number of keywords.
$keywords = $web->contentKeywordsWithScores;
echo "This page contains around " . count($keywords) . " keywords/phrases.\nBelow are some selected keyword extractions.";

// Loop through selected sub-sets of keywords
echo "\n\nSelected keywords with years:\n\n";
foreach ($keywords as $keyword => $score) {
    if (
        preg_match(
            '/\s[0-9]{4}\s/',
            $keyword,
            $matches
        )
    ) {
        echo sprintf(" - %s (%s)\n", $keyword, number_format($score, 1));
    }
}

// With "content"
echo "\n\nSelected keywords with \"content\":\n\n";
foreach ($keywords as $keyword => $score) {
    if ($score > 100 || $score < 5 || stripos($keyword, "content") === false) {
        continue;
    }

    echo sprintf(" - %s (%s)\n", $keyword, number_format($score, 1));
}


echo "\n\nLong Tail Keywords:\n\n";
foreach ($keywords as $keyword => $score) {
    if (
        preg_match(
            '/\s(\w{3,}\s\w{3,}\s\w{3,}\s\w{3,})\s/',
            $keyword,
            $matches
        )
    ) {
        echo sprintf(" - %s (%s)\n", $matches[1], number_format($score, 1));
    }
}
