<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phần 1 bài 3</title>
</head>
<body>
    <h1>Kết quả</h1>
    <h2>In ra số lẻ từ 0 đến 100</h2>
    <?php
        echo "<div><strong>a. dùng vòng lặp for</strong></div>";
        for ($i = 1; $i < 100; $i += 2) {
            echo "<div>" . $i . "</div>";
        }
    ?>

    <?php
        echo "<div><strong>b. dùng vòng lặp while</strong></div>";
        $j = 1;
        while ($j < 100) {
            echo "<div >" . $j . "</div>";
            $j += 2;
        }
    ?>
</body>
</html