<?php
$title = "Detail Product";
require_once "layouts/header.php";
$id = $_GET['id'];
$product = select("SELECT * FROM products WHERE id = $id")[0]
?>
<div class="container">
    <h1 class="mt-3 display-5"><?= $title; ?></h1>
    <table class="table">
        <tr>
            <th class="w-25">Id</th>
            <td><?= $product['id']; ?></td>
        </tr>
        <tr>
            <th>Name</th>
            <td><?= $product['name']; ?></td>
        </tr>
        <tr>
            <th>Price</th>
            <td><?= $product['price']; ?></td>
        </tr>
        <tr>
            <th>Qty</th>
            <td><?= $product['qty']; ?></td>
        </tr>
        <tr>
            <th>Category</th>
            <td><?= $product['category']; ?></td>
        </tr>
        <tr>
            <th>Date Modified</th>
            <td><?= $product['date_modified']; ?></td>
        </tr>
        <tr>
            <th>Image</th>
            <td>
                <a href="assets/image/<?= $product['image']; ?>">
                    <img src="assets/image/<?= $product['image']; ?>" alt="" style="width: 200px">
                </a>
            </td>
        </tr>
    </table>
    <a href="products.php" class="btn btn-secondary">Back</a>
</div>

<!-- preview image -->
<script>
    function previewImg() {
        const foto = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        const fileFoto = new FileReader();
        fileFoto.readAsDataURL(foto.files[0]);

        fileFoto.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>
<?php require_once "layouts/footer.php"; ?>