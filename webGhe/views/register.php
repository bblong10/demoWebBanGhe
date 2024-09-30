<?php
require '../connect/db.php'; // Đảm bảo rằng bạn đã tạo và kết nối thành công với cơ sở dữ liệu qua biến $pdo

$nameError = "";
$passwordError = "";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $nameError = "Tên đăng nhập không được trống";
    } else {
        $username = trim($username);
        $username = htmlspecialchars($username);
        if (!preg_match("/^[a-zA-Z]+$/", $username)) {
            $nameError = "<br />Tên chỉ được chứa kí tự và dấu cách";
        }
    }

    if (empty($password)) {
        $passwordError = "<br />Mật khẩu không được để trống";
    } else {
        if (strlen($password) < 8) {
            $passwordError = "<br />Mật khẩu phải có ít nhất 8 ký tự";
        } else if (!preg_match("#[0-9]+#", $password)) {
            $passwordError = "<br />Mật khẩu phải có ít nhất một chữ số";
        } else if (!preg_match("#[a-z]+#", $password)) {
            $passwordError = "<br />Mật khẩu phải có ít nhất một chữ thường";
        } else if (!preg_match("#[A-Z]+#", $password)) {
            $passwordError = "<br />Mật khẩu phải có ít nhất một chữ hoa";
        } else if (!preg_match("#[\W]+#", $password)) {
            $passwordError = "<br />Mật khẩu phải có ít nhất một ký tự đặc biệt";
        }
    }

    // Nếu không có lỗi, thực hiện thêm dữ liệu vào cơ sở dữ liệu
    if (empty($nameError) && empty($passwordError)) {
        $username = htmlspecialchars($username); // Đảm bảo username đã được xử lý
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); // Mã hóa mật khẩu

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$username, $passwordHash])) {
            echo "Đăng ký thành công!";
        } else {
            echo "Có lỗi xảy ra!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
    <link rel="stylesheet" href="../public/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../public/css/style.css?v=1.0.0">
</head>
<body style="background-color:#e3ecf4;">
    <section>
        <div class="container mt-5 pt-5">
            <div class="clearfix width-full text-center mx-auto my-3">
                <svg class="" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                </svg>
            </div>
            <div class="width-full text-center mx-auto my-3">
                <h1 class="lead">Đăng ký</h1>
            </div>
            <div class="row">
                <div class="col-12 col-sm-7 col-md-6 m-auto">
                    <div class="card border-0 shadow" style="min-height: 400px; background-color:#d3e0eb;">
                        <div class="card-body">
                            <form method="post" action="">
                                <input type="text" name="username" class="form-control my-4 py-2" id="usernameid" required placeholder="Tên đăng nhập" />
                                <span style="color: red;">
                                    <?php echo $nameError; ?>
                                </span>
                                <input type="password" name="password" class="form-control my-4 py-2" id="passwordid" required placeholder="Mật khẩu" />
                                <span style="color: red;">
                                    <?php echo $passwordError; ?>
                                </span>
                                <div class="text-center mt-3">
                                    <button class="btn btn-success mb-3" type="submit" name="submit">Đăng ký</button>
                                    <a href="login.php" class="nav-link"> Đăng nhập →</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="../public/js/jquery-3.7.1.min.js"></script>
    <script src="../public/js/bootstrap.min.js"></script>
</body>
</html>
