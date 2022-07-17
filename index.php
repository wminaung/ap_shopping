<?php
if (!empty($_POST['search'])) {
	setcookie('search', $_POST['search'], time() + (85400 * 30), '/');
} else {
	if (empty($_GET["pageno"])) {
		unset($_COOKIE['search']);
		setcookie('search', null, -1, '/');
	}
}
?>
<?php include('header.php') ?>

<?php
require 'config/config.php';

if (!empty($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
} else {
	$pageno = 1;
}
$num_rec = 3;
$offset = ($pageno - 1) * $num_rec;
if (empty($_POST['search']) && empty($_COOKIE['search'])) {

	if (!empty($_GET['category_id'])) {
		$catId =  $_GET['category_id'];
		$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=$catId AND quantity > 0 ORDER BY id DESC");
		$stmt->execute();
		$rawresult = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$total_posts = count($rawresult);
		$total_pages = ceil(count($rawresult) / $num_rec);

		$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=$catId AND quantity > 0  ORDER BY id DESC LIMIT $offset,$num_rec");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} else {
		$stmt = $pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC");
		$stmt->execute();
		$rawresult = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$total_posts = count($rawresult);
		$total_pages = ceil(count($rawresult) / $num_rec);

		$stmt = $pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC LIMIT $offset,$num_rec");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
} else {
	$userInput = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
	$userInput = htmlspecialchars($userInput);
	$stmt = $pdo->prepare("SELECT * FROM products  WHERE name LIKE '%$userInput%' AND quantity > 0 ORDER BY id DESC");
	$stmt->execute();
	$rawresult = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$total_posts = count($rawresult);
	$total_pages = ceil(count($rawresult) / $num_rec);

	$stmt = $pdo->prepare("SELECT * FROM products  WHERE name LIKE '%$userInput%' AND quantity > 0 ORDER BY id DESC LIMIT $offset,$num_rec");
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>
<div class="container">
	<div class="row">
		<div class="col-xl-3 col-lg-4 col-md-5">
			<div class="sidebar-categories">
				<div class="head">Browse Categories</div>
				<ul class="main-categories">
					<li class="main-nav-list">
						<?php
						$catStmt = $pdo->prepare('SELECT * FROM categories ORDER BY id DESC');
						$catStmt->execute();
						$catResult = $catStmt->fetchAll(PDO::FETCH_ASSOC);
						?>
						<?php
						foreach ($catResult as $key => $value) {
						?>
							<a href="index.php?category_id=<?php echo $value['id'] ?>">
								<span class="lnr lnr-arrow-right"></span><?php echo escape($value["name"]) ?>
							</a>
						<?php
						}
						?>
					</li>


				</ul>
			</div>
		</div>
		<div class="col-xl-9 col-lg-8 col-md-7">
			<!-- Start Filter Bar -->

			<div class="filter-bar d-flex flex-wrap align-items-center">
				<div class="pagination">
					<a href="?pageno=1" class="active">First</a>
					<a href="<?php echo $pageno <= 1 ? "#" : "?pageno=" . ($pageno - 1); ?>" class="prev-arrow <?php echo  $pageno <= 1 ? 'disabled' :  "" ?>">
						<i class="fa fa-long-arrow-left" aria-hidden="true"></i>
					</a>
					<a href="#" class="active"><?php echo $pageno; ?></a>
					<a href="<?php echo $pageno >= $total_pages ? "#" : "?pageno=" . ($pageno + 1); ?>" class="next-arrow <?php echo  $pageno >= $total_pages ? 'disabled' :  "" ?>">
						<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
					</a>
					<a href="?pageno=<?php echo $total_pages; ?>" class="active">Last</a>
				</div>
			</div>
			<!-- End Filter Bar -->
			<!-- Start Best Seller -->
			<section class="lattest-product-area pb-40 category-list">
				<div class="row">
					<?php
					if ($result) {
						foreach ($result as $key => $value) {
					?>


							<!-- single product -->
							<div class="col-lg-4 col-md-6">
								<div class="single-product">
									<a href="product_detail.php?id=<?php echo $value['id'] ?>">
										<img class="img-fluid" src="admin/images/<?php echo $value['image'] ?>" alt="<?php echo $value['image'] ?>" style="height: 250px;">
									</a>
									<div class="product-details">
										<h6><?php echo escape($value['name']) ?></h6>
										<div class="price">
											<h6><?php echo escape($value['price']) ?></h6>
											<!-- <h6 class="l-through">$210.00</h6> -->
										</div>
										<div class="prd-bottom">
											<form action="addtocart.php" method='post'>
												<input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
												<input type="hidden" name="id" value="<?php echo escape($value["id"]) ?>">
												<input type="hidden" name="qty" value="1" />

												<div class="social-info">
													<button type="submit" style="display:contents;">
														<span class="ti-bag"></span>
														<p class="hover-text" style="left:20px">add to bag</p>
													</button>
												</div>


												</a>
												<a href="product_detail.php?id=<?php echo $value['id'] ?>" class="social-info">
													<span class="lnr lnr-move"></span>
													<p class="hover-text">view more</p>
												</a>
											</form>

										</div>
									</div>
								</div>
							</div>

					<?php
						}
					}
					?>
				</div>
			</section>
			<!-- End Best Seller -->
			<?php include('footer.php'); ?>