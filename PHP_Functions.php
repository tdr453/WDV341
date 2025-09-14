<?php
    //format unix teimstamp to mm/dd/yyyy
    //Note: capital "Y" signifies four digits for year
    function displayAmericanDate($timestamp) {
        return date("m/d/Y", $timestamp);
    }

    //format unix timestamp to dd/mm/yyyy (international)
    //Note: capital "Y" signifies four digits for year
    function displayInternationalDate($timestamp) {
        return date("d/m/Y", $timestamp);
    }

    //string analysis function
    function analyzeString($input) {
    $charCount = strlen($input); //display the number of characters
    $trimmed = trim($input); //trim any whitespace
    $lowercase = strtolower($trimmed); //convert to lowercase
        //if statement: string contains the word "DMACC" either upper or lower
    if (stripos($lowercase, "dmacc") !== false) {
        $containsDMACC = "Yes";
    } else {
        $containsDMACC = "No";
    }

    echo "Original String: $input<br>";
    echo "Character Count: $charCount<br>";
    echo "Trimmed String: $trimmed<br>";
    echo "Lowercase: $lowercase<br>";
    echo "Contains 'DMACC': $containsDMACC<br>";
    }

    //converts a number to a string, then formats it like a phone number (ex: (123) 456-7890)
    function formatPhoneNumber($number) {
    $numStr = (string)$number;
        return "(" . substr($numStr, 0, 3) . ") " . substr($numStr, 3, 3) . "-" . substr($numStr, 6);
    }

    //puts a number into a $ format
    //uses built in PHP "number_format" function to accomplish this
    function formatCurrency($amount) {
        return "$" . number_format($amount, 2);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
        //display the formatted dates
        $timestamp = time();
        echo "American Date: " . displayAmericanDate($timestamp) . "<br>";
        echo "International Date: " . displayInternationalDate($timestamp) . "<br>";
        echo "<br><br>";

        //call the string analysis function
        analyzeString("Welcome to DMACC!");
        echo "<br><br>";

        //display the formatted phone number
        echo "Phone Number: " . formatPhoneNumber(1234567890) . "<br>";

        //display the formatted currency
        echo "Currency: " . formatCurrency(123456) . "<br>";

    ?>


</body>
</html>

