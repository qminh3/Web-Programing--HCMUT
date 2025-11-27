<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phần 1 bài 2</title>
</head>
<body>
    <?php
    function myfunction ($number) {
        switch ($number % 5) {
            case 0: return "Hello";
            case 1: return "How are you?";
            case 2: return "I'm doing well, thank you";
            case 3: return "See you later";
            case 4: return "Good-bye";
        }
    }
    $number_0 = 10;
    $number_1 = 6;
    $number_2 = 23;
    $number_3 = 14;
    $number_4 = 9;
    echo "<strong>Results:</strong><br>";
    echo "<div><strong>Số dư bằng 0 : </strong>" . myfunction($number_0)  . "<br></div>";
    echo "<div><strong>Số dư bằng 1 : </strong>" . myfunction($number_1)  . "<br></div>";
    echo "<div><strong>Số dư bằng 2 : </strong>" . myfunction($number_2)  . "<br></div>";
    echo "<div><strong>Số dư bằng 3 : </strong>" . myfunction($number_3)  . "<br></div>";
    echo "<div><strong>Số dư bằng 4 : </strong>" . myfunction($number_4)  . "<br></div>";

    ?>
</body>
</html>