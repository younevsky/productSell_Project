<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: login.php");
    exit;
}

include 'connect.php';
// Connect to the database
$conn = dbConnect();

// Fetch client's ID
$stmt = $conn->prepare("SELECT idCli FROM client WHERE email = :email");
$stmt->bindParam(':email', $_SESSION['SESSION_EMAIL']);
$stmt->execute();
$client = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$client) {
    echo "Client not found!";
    exit;
}

// Fetch the orders for the client
$stmt = $conn->prepare("SELECT vente.idPro, vente.quantity_vente, vente.timestamp, produit.pro_name, produit.prix, produit.image FROM vente JOIN produit ON vente.idPro = produit.idPro WHERE vente.idCli = :client_id");
$stmt->bindParam(':client_id', $client['idCli']);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT name FROM client WHERE email = :email");
$stmt->bindParam(':email', $_SESSION['SESSION_EMAIL']);
$stmt->execute();
$client = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/orders.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <title>Orders</title>
</head>
<body>



        <div style="margin-top: 100px;font-size:2rem;font-weight:700" >
        <span>YOUR ORDERS :</span>
        
      </div>

      <div class="order-section">
        <?php foreach ($orders as $order): ?>
            <div class="order-card">
                <img src="<?php echo $order['image']; ?>" alt="Product Image">
                <div>
                    <h2><?php echo $order['pro_name']; ?></h2>
                    <p>Quantity: <?php echo $order['quantity_vente']; ?></p>
                    <p>Total Price: <?php echo $order['quantity_vente'] * $order['prix']; ?> DH</p>
                    <p>Date: <?php echo $order['timestamp']; ?></p>
                </div>
                <form action="remove.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $order['idPro']; ?>" />
                    <button type="submit" name="remove">Remove</button>
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
               </li>
               <li class="dropdown__item">

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
              <a href="orders.php" class="nav-link">
                <i class="bx bx-user icon"></i>
                <span class="link">Account</span>
              </a>
            </li>
            <li class="list">
              <a href="#" class="nav-link">
                <i class="bx bx-cart icon"></i>
                <span class="link">Orders</span>
              </a>
            </li>
            <li class="list">
              <a href="#" class="nav-link">
                <i class="bx bx-cog icon"></i>
                <span class="link">Settings</span>
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
