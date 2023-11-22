<?php 
    include 'connection.php';
    session_start();

    $user_id = $_SESSION['user_id'];
    if (!isset($user_id)){
        header('location:login.php');
    }
    /*-------------------- Adding product to wishlist ----------------------- */
    if(isset($_POST['add_to_wishlist'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];

        $wishlist_number = mysqli_query($conn, "SELECT * FROM wishlist WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
        $cart_number = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

        if(mysqli_num_rows($wishlist_number)>0){
            $message[] = 'Product already exist in wishlist!';
        }else if(mysqli_num_rows($cart_number)>0){
            $message[] = 'Product already exist in cart!';
        }else{
            mysqli_query($conn, "INSERT INTO wishlist (user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')");
            
            $message[] = 'Product successfully added in wishlist';
        }
    }
    /*-------------------- Adding product to cart ----------------------- */
    if(isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];

        $cart_number = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

        if(mysqli_num_rows($cart_number)>0){
            $message[] = 'Product already exist in cart!';
        }else{
            mysqli_query($conn, "INSERT INTO cart (user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')");
            
            $message[] = 'Product successfully added in cart';
        }
    }
?>
<style type="text/css">
    <?php include 'main.css' ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <title>Eshar Shop</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="slider-section">
        <div class="slide-show-container">
            <div class="wrapper-one">
                <div class="wrapper-text">Inspired by nature</div>
            </div>
            <div class="wrapper-two">
                <div class="wrapper-text">Fresh products for you</div>
            </div>
            <div class="wrapper-three">
                <div class="wrapper-text">Test you dessire</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="detail">
                <span>30% OFF TODAY</span>
                <h1>Simple & Elegant</h1>
                <a href="shop.php">Shop Now</a>
            </div>
        </div>
        <div class="card">
            <div class="detail">
                <span>30% OFF TODAY</span>
                <h1>Simple & Elegant</h1>
                <a href="shop.php">Shop Now</a>
            </div>
        </div>
        <div class="card">
            <div class="detail">
                <span>30% OFF TODAY</span>
                <h1>Simple & Elegant</h1>
                <a href="shop.php">Shop Now</a>
            </div>
        </div>
    </div>

    <div class="categories">
        <h1 class="title">TOP CATEGORIES</h1>
        <div class="box-container">
            <div class="box">
                <img src="img/category-1.jpg">
                <span>Birthday</span>
            </div>
            <div class="box">
                <img src="img/categorie-2.jpg">
                <span>Next-day</span>
            </div>
            <div class="box">
                <img src="img/category-3.webp">
                <span>Plant</span>
            </div>
            <div class="box">
                <img src="img/category-4.jpg">
                <span>Wedding</span>
            </div>
            <div class="box">
                <img src="img/category-5.webp">
                <span>Sympathy</span>
            </div>
        </div>
    </div>

    <div class="banner3">
        <div class="detail">
            <span>BETTER THEN CAKE</span>
            <h1>BIRTHDSY SPECIAL</h1>
            <p>Believe in birthday magic? (You will.) Celebrate with perty-ready blooms!</p>
            <a href="shop.php">Explore <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>

    <div class="shop">
        <h1 class="title">Shop best sellers</h1>
        <?php 
            if(isset($message)){
            foreach ($message as $message) {
                echo '
                    <div class="message">
                    <span>'.$message.'</span>
                        <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                    </div>
                ';
            }
        }
    ?>
    <div class="box-container">
        <?php 
            $select_products = mysqli_query($conn, "SELECT * FROM products") or die('query failed');
            if(mysqli_num_rows($select_products)>0){
                while($fetch_products=mysqli_fetch_assoc($select_products)){

                
        ?>
        <form action="" method="post" class="box">
            <img src="image/<?php echo $fetch_products['image']; ?>">
            <div class="price">$<?php echo $fetch_products['price']; ?>TK</div>
            <div class="name"><?php echo $fetch_products['name']; ?></div>
            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
            <input type="hidden" name="product_quantity" value="1" min="0">
            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
            <div class="icon">
                <a href="viwe_page.php?pid=<?php echo $fetch_products['id']; ?>" class="bi bi-eye-fill"></a>
                <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
                <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
            </div>
        </form>
        <?php 
                }
            }else{
                echo '<p class="empty">No products added yet!</p>';
            }
        ?>
    </div>
    <div class="more">
        <a href="shop.php">Load more</a>
        <i class="bi bi-arrow-down"></i>
    </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>