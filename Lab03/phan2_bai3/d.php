<?php
require_once 'config.php';

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: a.php");
    exit();
}

$id = $_GET['id'];

// Check if product exists
try {
    $stmt = $conn->prepare("SELECT id FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        header("Location: a.php");
        exit();
    }
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Delete the product
try {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    header("Location: a.php");
    exit();
} catch(PDOException $e) {
    die("Error deleting product: " . $e->getMessage());
}
?>