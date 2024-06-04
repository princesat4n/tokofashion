<?php 
	include 'db.php';
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

	.jumbotron {
    width: 100%; 
    height: 350px;
    background-image: url(img/banner.jpeg); 
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

	
	</style>
</head>
	<body>
	<header>
    <div class="container">
   e    <h1><a href="index.php">Disobdient&reg;</a></h1>
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
				<form action="produk.php">
					<input type="text" name="search" placeholder="Cari Produk">
					<input type="submit" name="cari" value="Cari Produk">
				</form>
			</div>
		</div>

		<div class="jumbotron">
				<div class="overlay"></div>            
		</div>  

		<div class="section">
			<div class="container">
				<h3>Produk Terlaris</h3>
				<div class="box">
					<?php 
						$produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_status = 1 ORDER BY product_id DESC LIMIT 8");
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
