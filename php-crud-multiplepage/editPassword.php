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

if (isset($_POST['editPassword'])) {
    if (editPassword() > 0) {
        echo "<script>alert('Edit password success'); document.location.href='index.php'</script>";
    } else {
        echo "<script>alert('Edit password failed'); document.location.href='index.php'</script>";
    }
}

?>
<div class="container">
    <h1 class="mt-3 display-5"><?= $title; ?> <?= $_SESSION['username']; ?></h1>
    <form action="" method="post">
        <div class="modal-body">
            <input type="hidden" name="id" value="<?= $user['id']; ?>">
            <div class="mb-2">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-2">
                <label for="password2" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="password2" name="password2" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="editPassword">Edit Password</button>
            <a href="editUser.php?id=<?= $user['id']; ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once "layouts/footer.php"; ?>