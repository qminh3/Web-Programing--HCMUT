<?php
    $num1 = $num2 = $result = $op = null;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["num1"])) {$num1 = $_POST["num1"];}
        if (isset($_POST["num2"])) {$num2 = $_POST["num2"];}
        if (!(isset($_POST["op"]))) {
            echo "  <script>
                        alert('Hãy chọn phép toán!');
                    </script>
            ";
        }
        else {
            $op = $_POST["op"];
            if ($op == "add" || $op == "sub" || $op == "mul" || $op == "divi" || $op == "pow") {
                if ($num1 == null || $num2 == null) {
                    echo "  <script>
                                alert('Hãy nhập đủ số!');
                            </script>
                    ";  
                }
                else {
                    if ($op == "add") {$result = $num1 + $num2;}
                    elseif ($op == "sub") {$result = $num1 - $num2;}
                    elseif ($op == "mul") {$result = $num1 * $num2;}
                    elseif ($op == "divi") {
                        if ($num2 == 0) {
                            echo "  <script>
                                        alert('Không thể chia cho 0');
                                    </script>
                            ";  
                        }
                        else {
                            $result = $num1/$num2;
                        }
                    }
                     elseif ($op == "pow") {$result = pow($num1, $num2);}
                }
            }
            else {
                if ($num2 != null) {
                    echo "  <script>
                                alert('Bạn chỉ cần nhập số thứ nhất, hãy xóa số thứ hai!');
                            </script>
                    ";  
                }
                else {
                    $result = pow($num1, -1);
                }
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Phần 1 bài 6</title>
    <style>
      :root{
        --page-bg: #f1f5f9;
        --card-bg: #ffffff;
        --accent: #0d6efd;
        --muted: #6c757d;
      }
      html,body{height:100%}
      body{
        background: var(--page-bg);
        font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:2rem;
        color:#071022;
      }

      .calculator {
        width:100%;
        max-width:560px;
        background:var(--card-bg);
        border-radius:12px;
        padding:1.25rem;
        box-shadow:0 8px 30px rgba(2,6,23,0.08);
      }

      .calculator h1{font-size:1.25rem;margin:0 0 0.75rem}

      .inputs-row{
        display:flex;
        gap:0.75rem;
        margin-bottom:0.75rem;
      }
      .inputs-row input[type="number"]{
        flex:1;
        padding:0.6rem 0.75rem;
        border:1px solid #e6e9ef;
        border-radius:8px;
        font-size:1rem;
        background:#f8fafc;
      }

      .result {
        width:100%;
        padding:0.65rem 0.75rem;
        border-radius:8px;
        border:1px solid #e6e9ef;
        background:#f8fafc;
        text-align:center;
        font-weight:600;
        margin-bottom:0.75rem;
      }

      .op-group{
        display:flex;
        flex-wrap:wrap;
        gap:0.5rem;
        justify-content:center;
        margin-bottom:0.5rem;
      }
      .op-group .btn{min-width:110px}

      .btn-equals{width:100%;margin-top:0.5rem}

     
    </style>
</head>
<body>
  <div class="calculator">
    <h1 class="fw-bold text-center mb-3">Simple Calculator</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="needs-validation" novalidate>
      <div class="inputs-row">
        <input type="number" name="num1" step="any" placeholder="Số thứ nhất"
               value="<?php echo ($num1 !== null) ? $num1 : ''; ?>">
        <input type="number" name="num2" step="any" placeholder="số thứ hai"
               value="<?php echo ($num2 !== null) ? $num2 : ''; ?>">
      </div>

      <input type="text" name="result" class="result" readonly placeholder="Kết quả"
             value="<?php echo (isset($result) && $result !== null) ? $result : ''; ?>">

      <div class="op-group">
        <input type="radio" class="btn-check" name="op" id="add" value="add" <?php echo ($op == "add")? "checked": ""; ?>>
        <label class="btn btn-outline-info" for="add">Cộng</label>

        <input type="radio" class="btn-check" name="op" id="sub" value="sub" <?php echo ($op == "sub")? "checked": ""; ?>>
        <label class="btn btn-outline-primary" for="sub">Trừ</label>

        <input type="radio" class="btn-check" name="op" id="mul" value="mul" <?php echo ($op == "mul")? "checked": ""; ?>>
        <label class="btn btn-outline-success" for="mul">Nhân</label>

        <input type="radio" class="btn-check" name="op" id="divi" value="divi" <?php echo ($op == "divi")? "checked": ""; ?>>
        <label class="btn btn-outline-warning" for="divi">Chia</label>

        <input type="radio" class="btn-check" name="op" id="pow" value="pow" <?php echo ($op == "pow")? "checked": ""; ?>>
        <label class="btn btn-outline-danger" for="pow">Lũy thừa</label>

        <input type="radio" class="btn-check" name="op" id="inv" value="inv" <?php echo ($op == "inv")? "checked": ""; ?>>
        <label class="btn btn-outline-dark" for="inv">Nghịch đảo</label>
      </div>

      <button type="submit" class="btn btn-success btn-equals">=</button>
    </form>
  </div>
</body>
</html>