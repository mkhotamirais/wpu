<?php
$title = "Edit User";
require_once "layouts/header.php";
if (!isset($_SESSION['login'])) {
    header("Location: products.php");
    exit();
}

$id = $_GET['id'];
$user = select("SELECT * FROM users WHERE id = $id")[0];
$username = $user['username'];
$email = $user['email'];
$image = $user['image'];

if (isset($_POST['edit'])) {
    if (editUser($id) > 0) {
        echo "<script>alert('Edit user success'); document.location.href='index.php'</script>";
    } else {
        echo "<script>alert('Edit user failed'); document.location.href='index.php'</script>";
    }
}

?>
<div class="container">
    <h1 class="mt-3 display-5"><?= $title; ?> <?= $_SESSION['username']; ?></h1>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $user['id']; ?>">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= $username; ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <a href="editPassword.php?id=<?= $user['id']; ?>" class="form-control">Ubah Password</a>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?= $email; ?>" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="text" class="form-control" id="image" name="image" value="<?= $image; ?>" required>
        </div>

        <button type="submit" name="edit" class="btn btn-success">Edit</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<?php require_once "layouts/footer.php"; ?>