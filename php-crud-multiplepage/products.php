<?php
$title = "List Product";
require_once "layouts/header.php";
$products = select("SELECT * FROM products");

// hapus product
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id = $_GET['id'];

    $product = select("SELECT * FROM products WHERE id = $id")[0];
    unlink("assets/image/" . $product['image']);

    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header("Location: products.php");
}

?>
<?php require_once "layouts/nav.php"; ?>
<div class="container">
    <h1 class="display-4 mt-3"><?= $title; ?></h1>
    <a href="addProduct.php" class="btn btn-primary mt-3">Add Product</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM products")) > 0) : ?>
                <?php
                $no = 1;
                foreach ($products as $product) :
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $product['name']; ?></td>
                        <td><?= $product['price']; ?></td>
                        <td>
                            <a href="assets/image/<?= $product['image']; ?>">
                                <img src="assets/image/<?= $product['image']; ?>" alt="" class="img-fluid" style="width: 70px">
                            </a>
                        </td>
                        <?php if (isset($_SESSION['login'])) : ?>
                            <td>
                                <a href="editProduct.php?id=<?= $product['id']; ?>" class="btn btn-sm btn-success">edit</a>
                                <a href="detailProduct.php?id=<?= $product['id']; ?>" class="btn btn-sm btn-info">detail</a>
                                <a href="products.php?aksi=hapus&id=<?= $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">del</a>
                            </td>
                        <?php else : ?>
                            <td>
                                <a href="detailProduct.php?id=<?= $product['id']; ?>" class="btn btn-sm btn-info">detail</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="text-center">
                        Data are still empty
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once "layouts/footer.php"; ?>