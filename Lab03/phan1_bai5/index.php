<?php
$TASKS_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'tasks.txt';
if (!file_exists($TASKS_FILE)) {
    touch($TASKS_FILE);
}

function load_tasks(string $path): array {
    $content = file_get_contents($path);
    if ($content === false) return [];
    $content = str_replace(["\r\n", "\r"], "\n", $content);
    $raw = explode("\n", $content);
    $tasks = [];
    foreach ($raw as $line) {
        $t = trim($line);
        if ($t !== '') {
            $tasks[] = $t;
        }
    }
    return $tasks;
}

function save_tasks(string $path, array $tasks): void {
    $data = implode("\n", $tasks);
    file_put_contents($path, $data, LOCK_EX);
}

$tasks = load_tasks($TASKS_FILE);
$modified = false;

if (isset($_POST['new_task'])) {
    $new = trim($_POST['new_task']);
    if ($new !== '') {
        $new = htmlspecialchars($new, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $tasks[] = $new; 
        $modified = true;
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    if ($id >= 0 && $id < count($tasks)) {
        array_splice($tasks, $id, 1);
        $modified = true;
    }
}

if ($modified) {
    save_tasks($TASKS_FILE, $tasks);
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}


function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
?>


<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Phần 1 bài 5</title>
  <link rel="stylesheet" type="text/css" href="./style.css" />
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="header">     
          <div class="title">Danh sách công việc</div>
      </div>

      <form class="add" method="POST" action="">
        <input type="text" name="new_task" placeholder="Nhập công việc mới..." maxlength="255" />
        <button type="submit">Thêm</button>
      </form>

      <?php if (count($tasks) === 0): ?>
        <div class="empty">Chưa có công việc nào.</div>
      <?php else: ?>
        <ul class="tasks">
          <?php foreach ($tasks as $i => $t): ?>
            <li class="task">
              <div class="task-name">
                <span class="idx"><?php echo $i; ?></span>
                <span class="task-text"><?php echo $t; ?></span>
              </div>
              <a class="delete" href="?action=delete&id=<?php echo $i; ?>" onclick="return confirm('Xóa công việc này?');">Xóa</a>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      
    </div>
  </div>
</body>
</html>
