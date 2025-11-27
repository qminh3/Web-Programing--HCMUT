<?php
require_once 'config.php';

$errors = [];
$id = $name = $description = $price = $image = null;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: a.php");
    exit();
}

$id = $_GET['id'];

try {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        header("Location: a.php");
        exit();
    }
    
    $name = $product['name'];
    $description = $product['description'];
    $price = $product['price'];
    $image = $product['image'];
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $name = trim($_POST['name']);
    if (empty($name)) {
        $errors['name'] = "Name is required";
    } elseif (strlen($name) < 5 || strlen($name) > 40) {
        $errors['name'] = "Name must be between 5 and 40 characters";
    }
    
    // Validate description
    $description = trim($_POST['description']);
    if (empty($description)) {
        $errors['description'] = "Description is required";
    } elseif (strlen($description) > 5000) {
        $errors['description'] = "Description cannot exceed 5000 characters";
    }
    
    // Validate price
    $price = trim($_POST['price']);
    if (empty($price)) {
        $errors['price'] = "Price is required";
    } elseif (!is_numeric($price) || $price <= 0) {
        $errors['price'] = "Price must be a positive number";
    }
    
    // Validate image
    $image = trim($_POST['image']);
    if (empty($image)) {
        $errors['image'] = "Image URL is required";
    } elseif (strlen($image) > 255) {
        $errors['image'] = "Image URL cannot exceed 255 characters";
    }
    
    // If no errors, update the database
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("UPDATE products SET name = :name, description = :description, price = :price, image = :image WHERE id = :id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            header("Location: a.php");
            exit();
        } catch(PDOException $e) {
            $errors['db'] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group textarea { width: 100%; padding: 8px; }
        .error { color: red; font-size: 14px; }
        .btn-container { margin-top: 20px; }
        .btn { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .btn-back { background-color: #f2f2f2; color: black; text-decoration: none; padding: 10px 15px; margin-right: 10px; }
        .preview-image { max-width: 200px; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Edit Product</h1>
    
    <?php if (isset($errors['db'])): ?>
        <div class="error"><?php echo $errors['db']; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
            <?php if (isset($errors['name'])): ?>
                <div class="error"><?php echo $errors['name']; ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5"><?php echo htmlspecialchars($description); ?></textarea>
            <?php if (isset($errors['description'])): ?>
                <div class="error"><?php echo $errors['description']; ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($price); ?>">
            <?php if (isset($errors['price'])): ?>
                <div class="error"><?php echo $errors['price']; ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="image">Image URL:</label>
            <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($image); ?>">
            <?php if (isset($errors['image'])): ?>
                <div class="error"><?php echo $errors['image']; ?></div>
            <?php endif; ?>
            <img src="<?php echo htmlspecialchars($image); ?>" alt="Product Image Preview" class="preview-image">
        </div>
        
        <div class="btn-container">
            <a href="a.php" class="btn-back">Back to List</a>
            <button type="submit" class="btn">Update Product</button>
        </div>
    </form>
</body>
</html>