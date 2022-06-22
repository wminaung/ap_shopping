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

    if (empty($_POST["name"]) || empty($_POST["description"])) {
        if (empty($_POST["name"])) {
            $nameError = "Name can not be null";
        }
        if (empty($_POST["description"])) {
            $descError = "Description can not be null";
        }
    } else {

        $name = $_POST['name'];
        $description = $_POST['description'];

        $stmt = $pdo->prepare("INSERT INTO categories (name,description) VALUE (:name, :description)");
        $result = $stmt->execute(
            array(':name' => $name, ':description' => $description)
        );

        if ($result) {
            echo "<script>alert('Add Category Successfully'); window.location.href='category.php';</script>";
        } else {
            echo "<script>alert('Something wroung'); window.location.href='category.php';</script>";
        }
    }
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
                        <form action="cat_add.php" method="post">
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
                            <!-- <div class="form-group">
                                <label for="">Image</label><br>
                                <p class="text-danger"></p>

                                <input type="file" name="image" id="">
                            </div> -->
                            <div class="form-group">
                                <input type="submit" name="submit" value="ADD" class="btn btn-success ">
                                <a href="category.php" class="btn btn-warning">Back</a>
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