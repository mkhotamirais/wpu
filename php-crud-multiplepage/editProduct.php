<?php
$title = "Edit Product";
require_once "layouts/header.php";
if (!isset($_SESSION['login'])) {
    header("Location: products.php");
    exit();
}

$id = $_GET['id'];
$product = select("SELECT * FROM products WHERE id = $id")[0];
$name = $product['name'];
$price = $product['price'];
$qty = $product['qty'];
$category = $product['category'];
$image = $product['image'];

if (isset($_POST['edit'])) {
    if (editProduct($id) > 0) {
        echo "<script>alert('Edit product success'); document.location.href='products.php'</script>";
    } else {
        echo "<script>alert('Edit product failed'); document.location.href='products.php'</script>";
    }
}

?>
<div class="container">
    <h1 class="mt-3 display-5"><?= $title; ?></h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="file_lama" value="<?= $image; ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $name; ?>">
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?= $price; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <label for="qty" class="form-label">Qty</label>
                <input type="number" class="form-control" id="qty" name="qty" value="<?= $qty; ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select name="category" id="category" name="category" class="form-control" required>
                <option value="">-- choose category --</option>
                <option value="atk" <?= $category == "atk" ? "selected" : null; ?>>atk</option>
                <option value="printer" <?= $category == "printer" ? "selected" : null; ?>>printer</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image" onchange="previewImg()" required>
            <img src="assets/image/<?= $image; ?>" alt="" class="img-thumbnail img-preview mt-2" width="100px">

        </div>
        <button type="submit" name="edit" class="btn btn-success">Edit</button>
        <a href="products.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<?php require_once "layouts/footer.php"; ?>