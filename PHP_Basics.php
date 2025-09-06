<?php
    function addNumbers($a, $b) {
        $total = $a + $b; // $total, $a, and $b are local variables
        return $total;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Basics Assignment</title>
</head>
<body>
    <?php
    $yourName = "Trevor Reece"; //variable yourName
    ?>
        
    <h1>2-1 PHP Basics</h1>
    <h2><?php echo $yourName; ?></h2>

    <?php
        $number1 = 3; // global variable
        $number2 = 5; // global variable
        $total = addNumbers($number1, $number2); // store total in a variable
    ?>

    <p>Number 1: <?php echo $number1; ?></p>
    <p>Number 2: <?php echo $number2; ?></p>
    <p>Total: <?php echo $total; ?></p>

    <script> 
        const skills = [
        <?php
            $skills = ["PHP", "HTML", "JavaScript"];
            for ($i = 0; $i < count($skills); $i++){ 
                echo "'" . $skills[$i] . "'";
                if($i < count($skills) -1) {
                    echo ", ";
                }
            }
        ?>
    ];

    for (i = 0; i < skills.length; i++){
        document.write(`<p>${skills[i]}</p>`);
    }
    </script>
</body>
</html>
