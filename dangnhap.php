<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap"
    />
    <link rel="stylesheet" href="./css/dangnhap.css">
</head>
<body>
    <!-- Kết nối vào CSDL -->
    <?php
        require_once "db_module.php";

        if ($_SERVER["REQUEST_METHOD"]=="POST") {
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $link = null;
            taoKetNoi($link);
            if ($link === false) {
                die("connection error");
            }

            $sql="select * from tbl_nhanvien where email='".$email."' AND mat_khau='".$pass."' ";
            $result=mysqli_query($link,$sql);

            // Kiểm tra số dòng kết quả trả về
            $num_rows = mysqli_num_rows($result);
            if ($num_rows == 1) {
                $row=mysqli_fetch_array($result);

                if($row["role_admin"]=="0") {
                    echo '<script>alert("Bạn không có quyền truy cập trang này");</script>';
                } elseif($row["role_admin"]=="1") {
                    header("location:index.php");
                    exit(); // Kết thúc kịch bản sau khi chuyển hướng
                }
            } else {
                echo '<script>alert("Email hoặc mật khẩu không đúng");</script>';
            }
            // Giải phóng tài nguyên
            mysqli_close($link);
        }
    ?>
    <div class="top">
        <img class="logo-icon"src="./icon/Logo.svg"/>
        <h1 class="logo-text">Luxe</h1>
    </div>
    <!--Fill in the form-->
    <div class="wrapper">
        <form method="post">
            <h1>Đăng nhập</h1>
            <b class="name">
                <span class="name-text">Email</span>
                <span class="span"> *</span>
              </b>
            <div class="input-box">
                <input type="email" name="email" required>
            </div>
            <b class="name">
                <span class="name-text">Mật khẩu</span>
                <span class="span"> *</span>
              </b>
            <div class="input-box">
                <input type="password" name="pass" required>
            </div>

            <button type="submit" name="login" class="btn">Đăng nhập</button>
        </form>
    </div>
</body>
</html>