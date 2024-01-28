<?php
$conn = mysqli_connect("localhost", "root", "", "php-crud-singlepage");

if (isset($_POST['add'])) {
    $name = strip_tags($_POST['name']);
    $price = strip_tags($_POST['price']);
    $qty = strip_tags($_POST['qty']);
    $category = strip_tags($_POST['category']);
    // $image = strip_tags($_POST['image']);
    $image = upload_file();
    $hasil = mysqli_query($conn, "INSERT INTO products (name, price, qty, category, image) VALUES ('$name', '$price', '$qty', '$category', '$image')");
    if ($hasil) {
        echo "<script>alert('add product success'); document.location.href = 'index.php'</script>";
    }
}

if (isset($_GET['aksi']) and $_GET['aksi'] === "delete") {
    $id = $_GET['id'];
    $query3 = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
    while ($product3 = mysqli_fetch_assoc($query3)) {
        unlink("image/" . $product3['image']);
    }
    $hasil = mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    if ($hasil) {
        echo "<script>alert('delete product success'); document.location.href = 'index.php'</script>";
    }
}

$name = '';
$price = '';
$qty = '';
$category = '';
$image = '';

if (isset($_GET['aksi']) and $_GET['aksi'] === 'edit') {
    $id_edit = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id_edit");
    while ($products = mysqli_fetch_assoc($query)) {
        $name = $products['name'];
        $price = $products['price'];
        $qty = $products['qty'];
        $category = $products['category'];
        $image = $products['image'];
    }
}

if (isset($_POST['edit'])) {
    $id = (int) $_POST['id'];
    $name = strip_tags($_POST['name']);
    $price = strip_tags($_POST['price']);
    $qty = strip_tags($_POST['qty']);
    $category = strip_tags($_POST['category']);
    // $image = strip_tags($_POST['image']);
    $foto_lama = strip_tags($_POST['foto_lama']);
    if ($_FILES['image']['error'] === 4) {
        $image = $foto_lama;
    } else {
        $image = upload_file();
        unlink("image/" . $foto_lama);
    }
    $hasil = mysqli_query($conn, "UPDATE products SET name = '$name', price = '$price', qty = '$qty', category = '$category', image = '$image', date_modified = CURRENT_TIMESTAMP() WHERE id = $id");
    if ($hasil) {
        echo "<script>alert('edit product success'); document.location.href = 'index.php'</script>";
    }
}

function upload_file()
{
    $f_name = $_FILES['image']['name'];
    $f_type = $_FILES['image']['type'];
    $f_tmp_name = $_FILES['image']['tmp_name'];
    $f_error = $_FILES['image']['error'];
    $f_size = $_FILES['image']['size'];

    if ($f_error === 4) {
        echo "<script>alert('the image have not choosed'); document.location.href = 'index.php';</script>";
        die();
    }
    if (!in_array($f_type, ["image/jpg", "image/jpeg", "image/png"])) {
        echo "<script>alert('file type is not valid'); document.location.href = 'index.php';</script>";
        die();
    }

    if ($f_size > 1024000) {
        echo "<script>alert('file size max 1mb'); document.location.href = 'index.php';</script>";
        die();
    }
    $f_uniq_name = uniqid();
    $f_pick_extensi = explode('.', $f_name);
    $f_extensi = strtolower(end($f_pick_extensi));
    $f_new_name = $f_uniq_name . "." . $f_extensi;

    move_uploaded_file($f_tmp_name, "image/$f_new_name");
    return $f_new_name;
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>php crud singlepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand text-uppercase" href="#">phpcrudsinglepage</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">products</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="display-4 my-3">Product list</h1>
                <?php if (isset($pesan)) : ?>
                    <div class="alert alert-<?= $type; ?> alert-dismissible fade show" role="alert">
                        <?= $pesan; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>no</th>
                            <th>product</th>
                            <th>price</th>
                            <th>image</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM products");

                        if (mysqli_num_rows($query) > 0) :
                        ?>
                            <?php
                            $no = 1;
                            while ($products = mysqli_fetch_assoc($query)) :
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $products['name']; ?></td>
                                    <td>Rp<?= number_format($products['price'], 0, ',', '.'); ?></td>
                                    <td style="width: 80px;" class="border text-center">
                                        <a href="image/<?= $products['image']; ?>" class="">
                                            <img src="image/<?= $products['image']; ?>" alt="kucing" class="img-fluid img-thumbnail">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="?aksi=edit&id=<?= $products['id']; ?>" class="btn btn-success btn-sm text-white">edit</a>
                                        <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $products['id']; ?>">detail</button>
                                        <a href="?aksi=delete&id=<?= $products['id']; ?>" class="btn btn-danger btn-sm text-white" onclick="return confirm('Are you sure?')">del</a>
                                    </td>
                                </tr>

                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center">
                                    Products are still empty!
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php
            $query2 = mysqli_query($conn, "SELECT * FROM products");
            while ($products2 = mysqli_fetch_assoc($query2)) :
            ?>
                <!-- modal detail -->
                <div class=" modal fade" id="modalDetail<?= $products2['id']; ?>" tabindex="-1" aria-labelledby="modalDetail" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h1 class="modal-title fs-5" id="modalDetail">Details of product <?= $products2['name']; ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>id</th>
                                        <td><?= $products2['id']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td><?= $products2['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Price</th>
                                        <td><?= $products2['price']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>qty</th>
                                        <td><?= $products2['qty']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td><?= $products2['category']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Date Modified</th>
                                        <td><?= date('d/m/Y H:i:s', strtotime($products2['date_modified'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Image</th>
                                        <td class="w-50">
                                            <a href="image/<?= $products2['image']; ?>" class="">
                                                <img src="image/<?= $products2['image']; ?>" alt="kucing" class="img-fluid img-thumbnail">
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

            <div class="col-md-4">
                <h1 class="display-6 my-3">Add Product</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $id_edit; ?>">
                    <input type="hidden" name="foto_lama" value="<?= $image; ?>">
                    <div class="mb-2">
                        <label for="name" class="form-label">name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $name; ?>" required <?= isset($id_edit) ? "autofocus" : null ?>>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="price" class="form-label">price</label>
                                <input type="number" class="form-control" id="price" name="price" value="<?= $price; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="qty" class="form-label">qty</label>
                                <input type="number" class="form-control" id="qty" name="qty" value="<?= $qty; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="category" class="form-label">category</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="">-- choose category ---</option>
                            <option value="atk" <?= $category == "atk" ? 'selected' : null; ?>>atk</option>
                            <option value="printer" <?= $category == "printer" ? 'selected' : null; ?>>printer</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="image" class="form-label">image</label>
                        <input type="file" class="form-control" id="image" name="image" onchange="previewImg()" />

                        <img src="image/<?= $image; ?>" alt="" class="img-thumbnail img-preview mt-2" width="100px">

                    </div>

                    <button type="submit" class="btn btn-<?= isset($id_edit) ? "success" : "primary"; ?>" name="<?= isset($id_edit) ? "edit" : "add"; ?>"><?= isset($id_edit) ? "Edit" : "Add"; ?></button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <?php if (isset($id_edit)) : ?>
                        <a href="index.php" class="btn btn-secondary float-end">cancel</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
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
</body>

</html>