<?php
$title = "List User";
require_once "layouts/header.php";
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['username'] != 'admin') {
    header("Location: index.php");
    exit();
}
$users = select("SELECT * FROM users");
if (isset($_POST['register'])) {
    if (addUser() > 0) {
        echo "<script>alert('add user success'); document.location.href='users.php';</script>";
    } else {
        echo "<script>alert('add user failed'); document.location.href='users.php';</script>";
    }
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'delete') {
    $id = $_GET['id'];

    // $user = select("SELECT * FROM users WHERE id = $id")[0];
    // unlink("assets/image/" . $product['image']);

    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
    header("Location: users.php");
}

if (isset($_POST['edit'])) {
    if (editUser() > 0) {
        echo "<script>alert('edit user success'); document.location.href='users.php';</script>";
    } else {
        echo "<script>alert('edit user failed'); document.location.href='users.php';</script>";
    }
}

if (isset($_POST['editPassword'])) {
    if (editPassword() > 0) {
        echo "<script>alert('change password success'); document.location.href='users.php';</script>";
    } else {
        echo "<script>alert('change password failed'); document.location.href='users.php';</script>";
    }
}
?>
<?php require_once "layouts/nav.php"; ?>
<div class="container">
    <h1 class="display-4 mt-3"><?= $title; ?></h1>
    <button type="button" class="btn btn-primary mt-3 mb-2" data-bs-toggle="modal" data-bs-target="#addUser">Register</button>
    <div class="row">
        <div class="col-md-6">
            <?php if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users")) > 0) : ?>
                <ul class="list-group">
                    <?php foreach ($users as $user) : ?>
                        <li class="list-group-item">
                            <?= $user['username']; ?>
                            <a href="users.php?aksi=delete&id=<?= $user['id']; ?>" class="btn btn-danger badge float-end" onclick="return confirm('Are you sure?')">del</a>
                            <button type="button" class="btn btn-info badge float-end mx-1" data-bs-toggle="modal" data-bs-target="#detailUser<?= $user['id']; ?>">detail</button>
                            <button type="button" class="btn btn-success badge float-end" data-bs-toggle="modal" data-bs-target="#editUser<?= $user['id']; ?>">edit</button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <div class="alert alert-warning">
                    User data are still empty
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal add -->
    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h1 class="modal-title fs-5" id="addUserLabel">Form Register</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-2">
                            <label for="password2" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password2" name="password2" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="register">Register</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php foreach ($users as $user) : ?>

        <!-- Modal detail -->
        <div class="modal fade" id="detailUser<?= $user['id']; ?>" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h1 class="modal-title fs-5" id="addUserLabel">Form Register</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <tr>
                                <th>Id</th>
                                <td><?= $user['id']; ?></td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td><?= $user['username']; ?></td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td>
                                    <button type="button" class="btn btn-success bt-sm" data-bs-toggle="modal" data-bs-target="#editPassword<?= $user['id']; ?>">edit password</button>
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= $user['email']; ?></td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td><?= $user['image']; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal edit -->
        <div class="modal fade" id="editUser<?= $user['id']; ?>" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h1 class="modal-title fs-5" id="addUserLabel">Form Edit User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?= $user['id']; ?>">
                            <div class="mb-2">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= $user['username']; ?>" required>
                            </div>
                            <div class="mb-2">
                                <label for="password" class="form-label">Password</label>
                                <button type="button" class="btn btn-success bt-sm form-control" data-bs-toggle="modal" data-bs-target="#editPassword<?= $user['id']; ?>">edit password</button>
                            </div>
                            <div class="mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" required>
                            </div>
                            <div class="mb-2">
                                <label for="image" class="form-label">Image</label>
                                <input type="text" class="form-control" id="image" name="image" value="<?= $user['image']; ?>" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" name="edit">Edit</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal ubah password -->
        <div class="modal fade" id="editPassword<?= $user['id']; ?>" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h1 class="modal-title fs-5" id="addUserLabel">Form Change Password</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php require_once "layouts/footer.php"; ?>