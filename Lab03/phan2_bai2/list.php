<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/style_list.css">
    <title>phan2_bai2</title>
</head>
<body>
    
    <?php
		$servername = "localhost";
		$username = "root";
		$password = "";

		
		$DBConnect = mysqli_connect($servername, $username, $password);

		
		if (!$DBConnect) {
  			die("Connection failed: " . mysqli_connect_error());
		}

        
        $shop_DB = mysqli_select_db ($DBConnect, "shop");
        if (!$shop_DB) {
            die("Cannot use database" . mysqli_error($DBConnect));
        }

        mysqli_set_charset($DBConnect, "utf8");
	?>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark px-4">
        <div class="container-fluid gap-5">
            
            <a href="#" class="navbar-brand text-white">
                Z-SHOP
            </a>

            
            <div class="navmenu navbar-collapse gap-5">
                <ul class="navbar-nav gap-3">
                    <li class="nav-item">
                        <a href="#category" class="nav-link text-uppercase text-white fw-bold">Danh mục</a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" class="nav-link text-uppercase text-white fw-bold">Liên hệ</a>
                    </li>
                    <li class="nav-item">
                        <a href="#follow" class="nav-link text-uppercase text-white fw-bold">Theo dõi</a>
                    </li>
                </ul>
            </div>

            
            <div class="navmenu navbar-collapse col-lg-1 position-relative">
                <input type="text" class="form-control rounded-5 px-5 fst-italic" placeholder="Search">
            </div>
        </div>
    </nav>

    <section class="mt-4">
        <div class="container-fluid bg-body p-0">
            <div class="row m-0">
                <div class="col-lg-2 container p-0 m-0">
                    <div class="text-uppercase fw-bold bg-dark text-white px-4 mb-2">DANH MỤC</div>
                        <ul class="navbar-nav px-4 sidebar">
                            <li><a href="" class="text-capitalize nav-link">Điện thoại</a></li>
                            <li><a href="" class="text-capitalize nav-link">Laptop</a></li>
                            <li><a href="" class="text-capitalize nav-link">Máy tính để bàn</a></li>
                            <li><a href="" class="text-capitalize nav-link">Phụ kiện</a></li>
                        </ul>
                    <div class="text-uppercase fw-bold bg-dark text-white px-4 mb-2 mt-4">TOP SẢN PHẨM</div>
                        <ul class="navbar-nav px-4 sidebar">
                            <li><a href="" class="text-capitalize nav-link">Bán chạy nhất</a></li>
                            <li><a href="" class="text-capitalize nav-link">Rẻ nhất</a></li>
                            <li><a href="./list.php" class="text-capitalize nav-link">Mới ra mắt</a></li>
                            <li><a href="" class="text-capitalize nav-link">Đánh giá cao</a></li>
                        </ul>
                </div>

                <div class="col-lg container-fluid px-0">
                    <h1 class="fw-bold text-uppercase mb-4 px-4">
                        Mới Ra Mắt
                    </h1>
                    <div class='row px-4 g-5'>
                        <?php 
                            $query = "SELECT * FROM products";
                            $product_info = mysqli_query($DBConnect, $query);
                            if (!$product_info) {
                                $message = 'Invalid query: ' . mysqli_error() . "<br>";
                                $message .= 'Whole query: ' . $query;
                                die($message);
                            }
                            $num_product = mysqli_num_rows($product_info);

                            $num_product_on_page = 6;
                            $num_page = ceil($num_product/$num_product_on_page);

                            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                            if ($page <= 0 || $page > $num_page) {
                                echo "<div class='text-center'>This page do not exist</div>";
                            }
                            else {
                                $product_start = ($page - 1) * $num_product_on_page;
                                $query = "SELECT id, name, price, image FROM products LIMIT {$product_start}, {$num_product_on_page}";
                                $product_info = mysqli_query($DBConnect, $query);
                            
                                while ($item = mysqli_fetch_assoc($product_info)) {
                                    echo "  
                                        <div class='col-lg-3 col-md-4 col-sm-6'>
                                            <div class='card bg-dark text-white'>
                                                <img src={$item['image']} alt='image-{$item['id']}' class='card-img-top img-fluid'>
                                                <div class='card-body'>
                                                    <div class='text-truncate-container' style='height: 3rem;'>
                                                        <p class='card-title text-capitalize'>{$item['name']}</p>
                                                    </div>
                                                    <div class='d-flex justify-content-between align-items-center'>
                                                        <span class='card-text text-warning'>{$item['price']} VND</span>
                                                        <a href='./detail.php?id={$item['id']}' role='button' class='btn btn-primary rounded-5'>
                                                            Xem Chi Tiết
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ";
                                }
                            }
                        ?>
            
              
                    </div>
                    <nav class="p-4">
                        <ul class="pagination justify-content-end">
                            <?php
                                $prev = $page-1 > 0? $page-1:1;
                                $next = $page+1 > $num_page? $num_page:$page+1;
                                echo "
                                    <li class='page-item'>
                                        <a class='page-link bg-dark text-white' href='./list.php?page={$prev}'>&lt;&lt;</a>
                                    </li>
                                ";                                
                                for ($i = 1; $i<= $num_page; $i++) {
                                    if ($i == $page) {
                                        echo "  
                                            <li class='page-item'>
                                                <a class='page-link text-white bg-info' href='./list.php?page={$i}'>{$i}</a>
                                            </li>
                                        ";
                                    } 
                                    else {
                                        echo "  
                                            <li class='page-item'>
                                                <a class='page-link text-secondary' href='./list.php?page={$i}'>{$i}</a>
                                            </li>
                                        ";        
                                    }                   
                                }          
                                echo "
                                    <li class='page-item'>
                                        <a class='page-link bg-dark text-white' href='./list.php?page={$next}'>&gt;&gt;</a>
                                    </li>
                                ";
                            
                            ?>
                        </ul>
                    </nav>
                </div>
                <?php
		            mysqli_close($DBConnect);
	            ?>
                
            </div>
        </div>
    </section>

    <footer class="mt-4 bg-dark text-white p-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-start">
                <div class="d-flex flex-column">
                    <span class="text-uppercase fw-bold mb-2">Hỗ trợ</span>
                    <a href="" class="nav-link">Chính sách đổi trả</a>
                    <a href="" class="nav-link">Theo dõi đơn hàng</a>
                    <a href="" class="nav-link">Bảng kích thước</a>
                    <a href="" class="nav-link">Bảo trì sản phẩm</a>
                </div>
            <div class="d-flex flex-column">
                <span class="text-uppercase fw-bold mb-2">Thông tin doanh nghiệp</span>
                <a href="" class="nav-link">Về chúng tôi</a>

                <a href="" class="nav-link">Ứng dụng trên di động</a>
            </div>
            <div class="d-flex flex-column mb-4">
                <span class="text-uppercase fw-bold mb-2">Liên hệ với chúng tôi</span>
                <a href="" class="nav-link"><i style="font-size:24px" class="fa"></i> Facebook</a>
                <a href="" class="nav-link"><i style="font-size:24px" class="fa"></i> Instagram</a>
                <a href="" class="nav-link"><i style="font-size:24px" class="fa"></i> Twitter</a>
            </div>
        </div>
        </div>
    </footer>

</body>
</html>