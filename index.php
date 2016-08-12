<?php
include_once 'SearchWords.php';

$string = file_get_contents('text.txt');

$searchWords = new SearchWords($string, 10);
$result = $searchWords->getRepeatedWords();

echo '<pre>' . print_r($result, 1) . '</pre>';