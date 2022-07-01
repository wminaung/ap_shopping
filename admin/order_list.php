<?php
session_start();
require '../config/config.php';
require '../config/common.php';


if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['role'])) {
    header("location: login.php");
    exit();
}
if ($_SESSION['role'] != 1) {
    header("Location: login.php");
    exit();
}

if (!empty($_POST['search'])) {
    setcookie('search', $_POST['search'], time() + (86400 + 30), '/');
} else {
    if (empty($_GET['pageno'])) {
        unset($_COOKIE['search']);
        setcookie('search', null, -1, '/');
    }
}

?>

<?php

############HEADER###############
include('header.php');
?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Order Listing</h3>
                    </div>
                    <!-- /.card-header -->

                    <?php
                    ##################pagination and retrieve #########################
                    if (!empty($_GET['pageno'])) {
                        $pageno = $_GET['pageno'];
                    } else {
                        $pageno = 1;
                    }
                    $num_rec = 3;
                    $offset = ($pageno - 1) * $num_rec;

                    $stmt = $pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC");
                    $stmt->execute();
                    $rawresult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $total_posts = count($rawresult);
                    $total_pages = ceil(count($rawresult) / $num_rec);

                    $stmt = $pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC LIMIT $offset,$num_rec");
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    ?>

                    <div class="card-body">
                        <!-- <div class="">
              total posts <i> : <b></b></i>
            </div> -->
                        <!-- <div>
                            <a href="" type="button" class="btn btn-primary"></a>

                        </div> -->
                        <br>
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>User</th>
                                    <th>Total Price</th>
                                    <th>Order Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                if ($result) {
                                    $i = ($pageno * $num_rec) - $num_rec + 1;

                                    foreach ($result as $value) {

                                        $userStmt = $pdo->prepare("SELECT * FROM users WHERE id=" . $value['user_id']);
                                        $userStmt->execute();
                                        // $userResult = $userStmt->fetchAll(PDO::FETCH_ASSOC);
                                        $userResult = $userStmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                        <tr>
                                            <td><?php echo "$i"; ?></td>
                                            <td><?php echo escape($userResult['name']); ?></td>
                                            <td><?php echo escape($value['total_price']); ?></td>
                                            <td><?php echo escape(date('y-m-d', strtotime($value['order_date']))); ?></td>
                                            <td style="width: 15%">
                                                <a href="order_detail.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-default">View</a>


                                            </td>
                                        </tr>
                                <?php
                                        $i++;
                                    }
                                }

                                ?>

                            </tbody>
                        </table>
                        <br>

                        <nav aria-label="Page navigation example ">
                            <ul class="pagination float-right">
                                <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                                <li class="page-item <?php echo  $pageno <= 1 ? 'disabled' :  "" ?>"><a class="page-link" href="<?php echo $pageno <= 1 ? "#" : "?pageno=" . ($pageno - 1); ?>">Previous</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#"><?php echo  $pageno; ?></a>
                                </li>
                                <li class="page-item <?php echo  $pageno >= $total_pages ? 'disabled' :  "" ?>">
                                    <a class="page-link" href="<?php echo $pageno >= $total_pages ? "#" : "?pageno=" . ($pageno + 1); ?>">Next</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a>
                                </li>
                            </ul>
                        </nav>
                        <!-- pagination navigatin -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<?php
############FOOTER###############
include('footer.php');
?>