<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
      $message[] = 'already added to wishlist!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }

}

if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home page</title>
<!--==Stylesheet=============================-->
<!--==Stylesheet=============================-->
<link rel="stylesheet" type="text/css" href="combo.css">

   <head>
    <link rel="stylesheet" href="partner.css">
  </head>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="home-bg">
<section id="search-banner">

<!--bg--------->
<img alt="bg" class="bg-1" src="https://i.imgur.com/h8pXo1s.png">

<img alt="bg" class="bg-1_rev" src="https://i.imgur.com/h8pXo1s.png">

<img alt="bg-2" class="bg-2" src="https://i.imgur.com/2smuQIz.png">
   <section class="home">

      <div class="content">
      
         <span>don't panic, go organice</span>
         <h3>Reach For A Healthier You With Organic Foods</h3>
         <p>Your diet is a bank account. Good food choices are good investments.</p>
      </div>

   </section>

</div>



<section class="home-category">

   <h1 class="title">shop by category</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/cat-1.png" alt="">
         <h3>Fruits</h3>
         <p>Fruits grow on trees. They are very healthy, nutritious, tasty and are an important part of our diet.</p>
         <a href="category.php?category=Fruits" class="btn">Fruits</a>
      </div>

      <div class="box">
         <img src="images/cart-2.png" alt="">
         <h3>Dry Fruits</h3>
         <p>Dried fruit generally contains a lot of fiber and is a great source of antioxidants, especially polyphenols.</p>
         <a href="category.php?category=DryFruits" class="btn">Dry Fruits</a>
      </div>

      <div class="box">
         <img src="images/cat-3.png" alt="">
         <h3>Vegitables</h3>
         <p>Vegetables are a rich source of folate, a B vitamin that helps your body make new red blood cells.</p>
         <a href="category.php?category=Vegitables" class="btn">Vegitables</a>
      </div>

      <div class="box">
         <img src="images/cart-4.png" alt="">
         <h3>Dairy Products</h3>
         <p> Eating or drinking dairy products offers health benefits, like building and maintaining strong bones.</p>
         <a href="category.php?category=DairyProducts" class="btn">Dairy Products</a>
      </div>

   </div>

</section>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" class="box" method="POST">
      <div class="price">₹<span><?= $fetch_products['price']; ?></span>1 kg/-</div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
      <input type="number" min="1" value="1" name="p_qty" class="qty">
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

</section>


<section class="home-category">

   <h1 class="title">Popular Bundle Pack</h1>

   <div class="box-container">

      <div class="product-box">
                    <a class="box" href="category.php?category=box1">
                    <img alt="pack" src="https://i.imgur.com/Zm8Xo2j.png"></a>
                    <strong>Big Pack</strong>
                    <span class="quantity">Mango, Strawberry, Apple,+3</span>
                    <span class="price">Rs. 800</span>
      </div>

      <div class="product-box">
      <a class="box" href="category.php?category=box2">
                    <img alt="apple" src="https://i.imgur.com/vMA9mRm.jpg"></a>
                    <strong>Large Pack</strong>
                    <span class="quantity">Capsicum, Broccoli, Tomato,+2</span>
                    <span class="price">Rs. 700</span>
      </div>

      <div class="product-box">
      <a class="box" href="category.php?category=box3">
                    <img alt="pack" src="https://i.imgur.com/Zm8Xo2j.png"></a>
                    <strong>Small Pack</strong>
                    <span class="quantity">Lichi, Blue Grapes, Green Grapes,+1</span>
                    <span class="price">Rs. 500</span>
      </div>

      <div class="product-box">
      <a class="box" href="category.php?category=box4">
                    <img alt="pack" src="https://i.imgur.com/Zm8Xo2j.png"></a>
                    <strong>Mini Pack</strong>
                    <span class="quantity">Red Papper, Potato, Tomato</span>
                    <span class="price">Rs. 300</span>
      </div>

      
   </div>
</section>




<section class="home-category">

   <h1 class="title">Our Trusted Partner</h1>

   <div class="box-container">

      <div class="box">
         <img src="https://i.postimg.cc/SR4nzZzw/Amul.png" alt="">
         <h3>Amul Products</h3>
         <a href="category.php?category=amul" class="btn">Amul Products</a>
      </div>

      <div class="box">
         <img src="https://i.postimg.cc/ZKT9bMmN/Dettol.png" alt="">
         <h3>Dettol Products</h3>
         <a href="category.php?category=dettol" class="btn">Dettol Products</a>
      </div>

      <div class="box">
         <img src="https://i.postimg.cc/wMk75hX3/haldiram.png" alt="">
         <h3>haldiram Products</h3>
        <a href="category.php?category=haldiram" class="btn">haldiram Products</a>
      </div>

      <div class="box">
         <img src="https://i.postimg.cc/dQRkKKbv/vadilal.png" alt="">
         <h3>Vadilal Products</h3>
         <a href="category.php?category=vadilal" class="btn">Vadilal Products</a>
      </div>

   </div>
  

</section>



<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>