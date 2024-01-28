<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand text-uppercase" href="index.php">crud multiplepage</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <?php if (isset($_SESSION['login'])) : ?>
                    <?php if ($_SESSION['username'] != 'admin') : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="products.php">Products</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="products.php">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users.php">Users</a>
                        </li>
                    <?php endif; ?>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Products</a>
                    </li>

                <?php endif; ?>
            </ul>
        </div>
        <?php if (isset($_SESSION['login'])) : ?>
            <a href="editUser.php?id=<?= $_SESSION['id']; ?>" class="mx-2"><?= $_SESSION['username']; ?></a>
            <a class="text-capitalize btn btn-secondary badge p-2" href="logout.php">logout</a>
        <?php else : ?>
            <a class="text-capitalize btn btn-primary badge p-2" href="login.php">login</a>
        <?php endif; ?>
    </div>
</nav>