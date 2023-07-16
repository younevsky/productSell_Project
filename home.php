<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: login.php");
    exit;
}
if ($_SESSION['SESSION_VERIFY'] !== 1){
  header("Location: verify.php");
  exit;
}

include ('connect.php');

$conn = dbConnect();


$stmt = $conn->prepare("SELECT * FROM produit WHERE pro_city = :city");
$stmt->bindParam(':city', $_SESSION['SESSION_CITY']);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT name FROM client WHERE email = :email");
$stmt->bindParam(':email', $_SESSION['SESSION_EMAIL']);
$stmt->execute();
$client = $stmt->fetch(PDO::FETCH_ASSOC);

// Logout functionality
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Home</title>

</head>
<body>



        <div style="margin-top: 100px;font-size:2rem;font-weight:700" >
        <span>Products Available in : <?php echo $_SESSION['SESSION_CITY']; ?></span>
        
      </div>

    <div class="product-section">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="<?php echo $product['image']; ?>" alt="Product Image">
                <div>
                    <h2><?php echo $product['pro_name']; ?></h2>
                    <p>Quantity: <?php echo $product['quantity']; ?></p>
                    <p>Price: <?php echo $product['prix']; ?> DH</p>
                </div>
                <form action="purshase.php" method="post" class="purshase">
                <input type="hidden" name="product_id" value="<?php echo $product['idPro']; ?>" />
                <input type="number" name="quantity" min="1" max="<?php echo $product['quantity']; ?>" required/>
                <div class="cashon">
                <label for="cod-<?php echo $product['idPro']; ?>">Cash on Delivery</label>
                <input type="checkbox" id="cod-<?php echo $product['idPro']; ?>" name="cod" required/>
                </div>
                <button type="submit" name="purchase">Buy</button>
            </form>
            </div>
        <?php endforeach; ?>
    </div>

    <nav>
      <div class="logo">
        <i class="bx bx-menu menu-icon"></i>
        <span class="logo-name">Products Seller</span>
        
      </div>



      <div class="search_bar">
    <form action="search.php" method="get">
        <input type="text" name="search" placeholder="Search" />
        <button type="submit" class="searcho"><i class="bx bx-search"></i></button>
    </form>
    </div>

    <div class="icons">
        <a href="orders.php" class="nav-link"><i class="bx bx-cart icon"></i></a>


        <div class="dropdown" id="dropdown-content">
            <button class="dropdown__button" id="dropdown-button">
               <i class="ri-user-3-line dropdown__icons"></i>
               <span class="dropdown__name"><?php echo $client['name']; ?></span>

               <div class="dropdown__icons">
                  
                  <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                  <i class="ri-close-line dropdown__close"></i>
               </div>
            </button>

            <ul class="dropdown__menu">
               <li class="dropdown__item">

                  <i class='bx bx-user-circle dropdown__icon' ></i>
                  <span class="dropdown__name"><?php echo $client['name']; ?></span>
               </li>
               
<li class="dropdown__item">

<span class="dropdown__name"><?php echo $_SESSION['SESSION_EMAIL']; ?></span>
</li> 

            </ul>

         </div>

        
        
        
         <a href="logout.php" class="nav-link ico"><i class="bx bx-log-out icon"></i></a>
      </div>



      <div class="sidebar">
        <div class="logo">
          <i class="bx bx-menu menu-icon"></i>
          <span class="logo-name">Menu</span>
        </div>

        <div class="sidebar-content">
          <ul class="lists">
            <li class="list">
              <a href="home.php" class="nav-link">
                <i class="bx bx-home-alt icon"></i>
                <span class="link">Home</span>
              </a>
            </li>
            <li class="list">
              <a href="#" class="nav-link">
                <i class="bx bx-user icon"></i>
                <span class="link">Account</span>
              </a>
            </li>
            <li class="list">
              <a href="orders.php" class="nav-link">
                <i class="bx bx-cart icon"></i>
                <span class="link">Orders</span>
              </a>
            </li>
            

          </ul>

          <div class="bottom-cotent">

            <li class="list">
              <a href="logout.php" class="nav-link">
                <i class="bx bx-log-out icon"></i>
                <span class="link">Logout</span>
              </a>
            </li>
          </div>
        </div>
      </div>
    </nav>


    <section class="overlay"></section>
    <script src="assets/js/home.js"></script>
    <script>
         $(document).ready(function() {
     $('[title="Hosted on free web hosting 000webhost.com. Host your own website for FREE."]').hide();
 });
    </script>

</body>
</html>