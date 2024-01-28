<?php

function Select($query)
{
    global $conn;
    $rows = [];
    $sql = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($sql)) {
        $rows[] = $row;
    };
    return $rows;
}

function addProduct()
{
    global $conn;
    $name = strip_tags($_POST['name']);
    $price = strip_tags($_POST['price']);
    $qty = strip_tags($_POST['qty']);
    $category = strip_tags($_POST['category']);
    // $image = strip_tags($_POST['image']);
    $image = upload_file();
    mysqli_query($conn, "INSERT INTO products (name, price, qty, category, image) VALUES ('$name', '$price', '$qty', '$category', '$image')");
    return mysqli_affected_rows($conn);
}

function editProduct($id)
{
    global $conn;
    $name = strip_tags($_POST['name']);
    $price = strip_tags($_POST['price']);
    $qty = strip_tags($_POST['qty']);
    $category = strip_tags($_POST['category']);
    // $image = strip_tags($_POST['image']);
    $file_lama = strip_tags($_POST['file_lama']);
    if ($_FILES['image']['error'] == 4) {
        $image = $file_lama;
    } else {
        $image = upload_file();
        unlink("assets/image/" . $file_lama);
    }
    mysqli_query($conn, "UPDATE products SET name = '$name', price = '$price', qty = '$qty', category = '$category', image = '$image', date_modified = CURRENT_TIMESTAMP() WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function upload_file()
{
    $f_name = $_FILES['image']['name'];
    $f_type = $_FILES['image']['type'];
    $f_tmp_name = $_FILES['image']['tmp_name'];
    $f_error = $_FILES['image']['error'];
    $f_size = $_FILES['image']['size'];

    if ($f_error === 4) {
        echo "<script>alert('the image have not choosed'); document.location.href='addProduct.php';</script>";
        die();
    }

    if (!in_array($f_type, ["image/jpeg", "image/jpg", "image/png"])) {
        echo "<script>alert('file tipe is not valid'); document.location.href='addProduct.php';</script>";
        die();
    }

    if ($f_size > 1024000) {
        echo "<script>alert('file size max 1mb'); document.location.href='addProduct.php';</script>";
        die();
    }

    $f_generate_new_name = uniqid();
    $f_get_extension = explode(".", $f_name);
    $f_extension = strtolower(end($f_get_extension));
    $f_new_name = $f_generate_new_name . "." . $f_extension;
    move_uploaded_file($f_tmp_name, "assets/image/$f_new_name");
    return $f_new_name;
}

function addUser()
{
    global $conn;
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password2 = mysqli_real_escape_string($conn, $_POST['password2']);

    // cek duplikasi user
    $user = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($user)) {
        echo "<script>alert('Username already registered, user another one!');</script>";
        return false;
    }

    // konfirmasi password
    if ($password !== $password2) {
        echo "<script>alert('Password confirmation does not match');</script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
    return mysqli_affected_rows($conn);
}

function editUser()
{
    global $conn;
    $id = (int) $_POST['id'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = strip_tags($_POST['email']);
    $image = strip_tags($_POST['image']);
    mysqli_query($conn, "UPDATE users SET username = '$username', email = '$email', image = '$image' WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function editPassword()
{
    global $conn;
    $id = (int) $_POST['id'];
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password2 = mysqli_real_escape_string($conn, $_POST['password2']);
    // konfirmasi password
    if ($password !== $password2) {
        echo "<script>alert('Password confirmation does not match');</script>";
        return false;
    }
    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE users SET password = '$password' WHERE id = $id");
    return mysqli_affected_rows($conn);
}
