<?php include('header.php') ?>


<?php

if (!empty($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
} else {
	$pageno = 1;
}
$num_rec = 3;
$offset = ($pageno - 1) * $num_rec;
if (empty($_POST['search']) && empty($_COOKIE['search'])) {

	$stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
	$stmt->execute();
	$rawresult = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$total_posts = count($rawresult);
	$total_pages = ceil(count($rawresult) / $num_rec);

	$stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT $offset,$num_rec");
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
	$userInput = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
	$userInput = htmlspecialchars($userInput);
	$stmt = $pdo->prepare("SELECT * FROM products  WHERE name LIKE '%$userInput%' ORDER BY id DESC");
	$stmt->execute();
	$rawresult = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$total_posts = count($rawresult);
	$total_pages = ceil(count($rawresult) / $num_rec);

	$stmt = $pdo->prepare("SELECT * FROM products  WHERE name LIKE '%$userInput%' ORDER BY id DESC LIMIT $offset,$num_rec");
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
							<a href="#" data-toggle="collapse">
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
									<img class="img-fluid" src="admin/images/<?php echo $value['image'] ?>" alt="<?php echo $value['image'] ?>" style="height: 250px;">
									<div class="product-details">
										<h6><?php echo escape($value['name']) ?></h6>
										<div class="price">
											<h6><?php echo escape($value['price']) ?></h6>
											<!-- <h6 class="l-through">$210.00</h6> -->
										</div>
										<div class="prd-bottom">
											<a href="" class="social-info">
												<span class="ti-bag"></span>
												<p class="hover-text">add to bag</p>
											</a>
											<a href="" class="social-info">
												<span class="lnr lnr-move"></span>
												<p class="hover-text">view more</p>
											</a>
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