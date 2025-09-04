<?php
    function greetUser($name){
        return "Welcome, $name! I like programming in PHP!";
    }

    function displayDateTime() {
        return date("l jS \of F Y h:i:s A");
    }

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
    <title>PHP Functions Exercise</title>
</head>
<body>
    <h1>PHP Functions Practice</h1>

    <h2><?php echo greetUser("Trevor"); ?></h2>
    <h2><?php echo greetUser("Bill"); ?></h2>
    <h2><?php echo greetUser("Mike"); ?></h2>

    <h3><?php echo displayDateTime()?></h3>

    <?php
        $num1 = 3; // global variables
        $num2 = 5; // global variables
    ?>

    <p><?php echo "The result of adding $num1 + $num2 is " . addNumbers($num1, $num2); ?></p>

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