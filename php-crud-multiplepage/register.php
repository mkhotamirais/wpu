<?php
session_start();
require_once "config/app.php";
if (isset($_POST['register'])) {
    if (addUser() > 0) {
        echo "<script>alert('register success'); document.location.href='login.php';</script>";
    } else {
        echo "<script>alert('register failed'); document.location.href='register.php';</script>";
    }
}

?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="/docs/5.3/assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.112.5">
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <style>
        html,
        body {
            height: 100%;
        }

        .form-signin {
            max-width: 330px;
            padding: 1rem;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto">
        <h1 class="h3 mb-3 fw-normal text-center">Please Register</h1>
        <form method="post">
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="floatingInput" name="username" placeholder="username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="password2" placeholder="Confirm Password" required>
                <label for="floatingPassword">Confirm Password</label>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit" name="register">Register</button>
            <p class="text-center mt-3">Already have an account? <a href="login.php" class="fw-bold">login</a></p>
            <p class="mt-5 mb-3 text-body-secondary text-center">&copy; 2017–2023</p>
        </form>
    </main>
    <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>