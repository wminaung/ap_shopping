<?php
session_start();
require '../config/config.php';
require '../config/common.php';


if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['role'])) {
    header("location: login.php");
    exit();
}
if ($_SESSION['role'] != 1) {
    header("Location: ../login.php");
    exit();
}


if ($_POST) {

    if (
        empty($_POST["name"])
        || empty($_POST["description"])
        || empty($_POST["category"])
        || empty($_POST["quantity"])
        || empty($_POST["price"])
        || empty($_FILES["image"])
    ) {

        if (empty($_POST["name"])) {
            $nameError = "Name is required";
        }
        if (empty($_POST["description"])) {
            $descError = "Description is required";
        }
        if (empty($_POST["category"])) {
            $catError = "Category is required";
        }
        if (empty($_POST["quantity"])) {
            $qtyError = "Quantity is required";
        } else if (is_numeric($_POST["quantity"]) != 1) {
            $qtyError = "Price should be integer value";
        }
        if (empty($_POST["price"])) {
            $priceError = "Price is required";
        } else if (is_numeric($_POST["price"]) != 1) {
            $priceError = "Price should be integer value";
        }
        if (empty($_FILES["image"])) {
            $imageError = "Image is required";
        }
    } else { // validation success

        $file = 'images/' . ($_FILES['image']['name']);
        $imageType = pathinfo($file, PATHINFO_EXTENSION);

        if ($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png') {
            echo "<script>alert('Image should be png,jpg,jpeg');</script>";
        } else { // image validtation success
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $category = $_POST['category'];
            $qty = $_POST['quantity'];
            $price = $_POST['price'];
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $file);

            $stmt = $pdo->prepare("INSERT INTO products(name,description,category_id,quantity,price,image) 
            VALUES(:name,:description,:category,:quantity,:price,:image)");
            $result = $stmt->execute(
                array(
                    ':name' => $name, ':description' => $desc,
                    ':category' => $category, ':quantity' => $qty,
                    ':price' => $price, ':image' => $image
                )
            );
            if ($result) {
                echo "<script>alert('Product is Added');window.location.href='index.php';</script>";
            }
        }
    }

    //     $name = $_POST['name'];
    //     $description = $_POST['description'];

    //     $stmt = $pdo->prepare("INSERT INTO products (name,description) VALUE (:name, :description)");
    //     $result = $stmt->execute(
    //         array(':name' => $name, ':description' => $description)
    //     );

    //     if ($result) {
    //         echo "<script>alert('Add Category Successfully'); window.location.href='index.php';</script>";
    //     } else {
    //         echo "<script>alert('Something wroung'); window.location.href='index.php';</script>";
    //     }
    // }
}

?>
<?php
include('header.php');
?>
<!-- Main content -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="product_add.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
                            <div class="form-group">
                                <label for="">Name</label>
                                <p class="text-danger"><?php echo empty($nameError) ? "" : $nameError ?></p>
                                <input type="text" name="name" id="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <p class="text-danger"><?php echo empty($descError) ? "" : $descError ?></p>

                                <textarea name="description" id="" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="form-group">

                                <?php
                                $catStmt = $pdo->prepare("SELECT * FROM categories");
                                $catStmt->execute();
                                $catResult = $catStmt->fetchAll(PDO::FETCH_ASSOC);
                                ?>

                                <label for="">Category</label>
                                <p class="text-danger"><?php echo empty($catError) ? "" : $catError ?></p>

                                <select class="form-control" name="category">
                                    <?php
                                    foreach ($catResult as $value) {
                                    ?>
                                        <option value="<?php echo escape($value['id']) ?>"><?php echo escape($value['name']) ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>

                            <div class="form-group">
                                <label for="">Quantity</label>
                                <p class="text-danger"><?php echo empty($qtyError) ? "" : $qtyError ?></p>
                                <input type="number" name="quantity" id="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Price</label>
                                <p class="text-danger"><?php echo empty($priceError) ? "" : $priceError ?></p>
                                <input type="number" name="price" id="" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">Image</label><br>
                                <p class="text-danger"><?php echo empty($imageError) ? "" : $imageError ?></p>

                                <input type="file" name="image" id="">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="ADD" class="btn btn-success ">
                                <a href="index.php" class="btn btn-warning">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card -->

            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<?php
include('footer.php');
?>