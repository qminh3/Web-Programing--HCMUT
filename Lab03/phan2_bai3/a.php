<?php
require_once 'config.php';

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination settings
$records_per_page = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Query to get total records
$total_query = "SELECT COUNT(*) FROM products";
if (!empty($search)) {
    $total_query .= " WHERE name LIKE :search OR description LIKE :search";
}

$stmt = $conn->prepare($total_query);
if (!empty($search)) {
    $search_param = "%$search%";
    $stmt->bindParam(':search', $search_param);
}
$stmt->execute();
$total_records = $stmt->fetchColumn();
$total_pages = ceil($total_records / $records_per_page);

// Query to get products with pagination and search
$query = "SELECT * FROM products";
if (!empty($search)) {
    $query .= " WHERE name LIKE :search OR description LIKE :search";
}
$query .= " LIMIT :offset, :records_per_page";

$stmt = $conn->prepare($query);
if (!empty($search)) {
    $search_param = "%$search%";
    $stmt->bindParam(':search', $search_param);
}
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Product List</title>
    <style>
        button { cursor: pointer; border-radius: 0.2rem; }
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .pagination { margin-top: 20px; }
        .pagination a { margin-right: 5px; padding: 5px 10px; text-decoration: none; background-color: #f2f2f2; }
        .pagination a.active { background-color: #4CAF50; color: white; }
        .search-form { margin-bottom: 20px; }
        .action-links { margin-bottom: 20px; }
        .action-links a { margin-right: 10px; }
        img { max-width: 100px; max-height: 100px; }
    </style>
</head>
<body>
    <h1>Product List</h1>

    <div class="d-flex flex-shrink-0 px-4 mb-3">
        <a href="./b.php" role="button" class="btn btn-success rounded-2">
            <i class="fa fa-plus"></i> Add New Product
        </a>
    </div>

    <form class="search-form" method="GET" action="">
        <input type="text" name="search" placeholder="Search by title or description" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
        <?php if (!empty($search)): ?>
            <a href="?">Clear</a>
        <?php endif; ?>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars(substr($product['description'], 0, 100)) . (strlen($product['description']) > 100 ? '...' : ''); ?></td>
                        <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</td>
                        <td><img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"></td>
                        <td>
                            <a href="c.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary me-1">
                                <i class="fa fa-pencil"></i> Edit
                            </a>
                            <a href="d.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure you want to delete this product?');">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No products found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" <?php echo $page == $i ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
</body>
</html>