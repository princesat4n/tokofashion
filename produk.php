<?php 
error_reporting(0);
include 'db.php';

// Fetch contact information
$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 1");
$a = mysqli_fetch_object($kontak);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Disobdient</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
    <style>    
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <h1><a href="index.php">Disobdient&reg;</a></h1>
        <ul>
            <li><a href="produk.php">Produk</a></li>
            <?php 
                $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
                $hasKaos = false;
                
                if(mysqli_num_rows($kategori) > 0){
                    while($k = mysqli_fetch_array($kategori)){
                        if ($k['category_name'] == 'Kaos') {
                            $hasKaos = true;
                        }
                    }
                }
                if ($hasKaos) {
            ?>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Kategori</a>
                <div class="dropdown-content">
                    <?php
                        if ($hasKaos) {
                            echo '<a href="produk.php?kat=kaos">Kaos</a>';
                        }
                    ?>
                </div>
            </li>
            <?php 
                } else {
            ?>
            <li><a href="#">Kategori tidak ada</a></li>
            <?php 
                } 
            ?>
        </ul>
    </div>
</header>

<div class="search">
    <div class="container">
        <form action="produk.php" method="GET">
            <input type="text" name="search" placeholder="Cari Produk" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <input type="hidden" name="kat" value="<?php echo isset($_GET['kat']) ? htmlspecialchars($_GET['kat']) : ''; ?>">
            <input type="submit" name="cari" value="Cari Produk">
        </form>
    </div>
</div>

<div class="section">
		<div class="container">
			<h3>Produk</h3>
			<div class="box">
				<?php 
					if($_GET['search'] != '' || $_GET['kat'] != ''){
						$where = "AND product_name LIKE '%".$_GET['search']."%' AND category_id LIKE '%".$_GET['kat']."%' ";
					}

					$produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_status = 1 $where ORDER BY product_id DESC");
					if(mysqli_num_rows($produk) > 0){
						while($p = mysqli_fetch_array($produk)){
				?>	
					<a href="detail-produk.php?id=<?php echo $p['product_id'] ?>">
						<div class="col-4">
							<img src="produk/<?php echo $p['product_image'] ?>">
							<p class="nama"><?php echo substr($p['product_name'], 0, 30) ?></p>
							<p class="harga">Rp. <?php echo number_format($p['product_price']) ?></p>
						</div>
					</a>
				<?php }}else{ ?>
					<p>Produk tidak ada</p>
				<?php } ?>
			</div>
		</div>
	</div>

<div class="footer">
    <div class="container">
        <h4>Alamat</h4>
        <p><?php echo $a->admin_address ?></p>

        <h4>Email</h4>
        <p><?php echo $a->admin_email ?></p>

        <h4>No. Hp</h4>
        <p><?php echo $a->admin_telp ?></p>
        <small>Copyright &copy; 2024 - Disobdient.</small>
    </div>
</div>
</body>
</html>
