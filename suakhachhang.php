<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Chỉnh biểu tượng web -->
    <link href="./icon/Logo.svg" rel="shortcut icon" />
    <title>Luxe - Admin</title>
    <!-- GG Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap"
      rel="stylesheet"
    />
    <!-- Styles -->
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/khachhang.css" />
    <link rel="stylesheet" href="css/header.css" />
    <!--Thư viên flatpickr để chọn ngày giờ-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
    />
  </head>
  <body>
    <!-- Header -->
    <?php
      require_once "db_module.php";  
      include "header.php";   
    ?>
    <header>
    <!-- Page Title -->
    <section id="page-title">
      <div class="container">
        <div class="home-title">
          <img src="./icon/khachhang-settings.svg" alt="" />
          <h1 class="title">Cập nhật khách hàng</h1>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section id="main-content-2">
    <!-- Kết nối vào CSDL -->
    <?php
    // Tạo kết nối vào CSDL
    require_once "db_module.php";
    $link = null;
    taoKetNoi($link);

    if(isset($_GET["id"])){
    $_idiachip = $_GET["id"];
    $sql = "select * from tbl_khachhang where ma_khach_hang=".$_idiachip;
    $result = chayTruyVanTraVeDL($link,$sql);
    //Lấy dữ liệu từ trong DB ra
    $row = mysqli_fetch_assoc($result);
        ?>
      <form action="khachhang.php?opt=update_kh" class="edit-customer"  method="post" enctype="multipart/form-data">
        <!-- Row 1 -->
        <input type="hidden" name="makhachhang" value="<?php echo $row["ma_khach_hang"]; ?>">
        <div class="form-row">
          <div class="form-group">
            <div class="image">
            <img class="ava" src="./img/khachhang-ava.png" alt=""/>
            </div>
          </div>
          <div class="form-group">
            <div class="form-group-in">
              <label for="ngaysinh" class="form-label">Ngày sinh</label>
              <input
              type="date"
              name="ngaysinh"
              id="ngaysinh"
              class="form-input"
              value="<?php echo $row["ngay_sinh"]; ?>"
              />
            </div>
            <div class="form-group-in">
              <label for="email" class="form-label">Email</label>
              <input type="text" id="email" name= "email" class="form-input" value="<?php echo $row["email"]; ?>"/>
            </div>
          </div>
        </div>
        <!-- Row 2 -->
        <div class="form-row">
          <div class="form-group">
          <label for="hoten" class="form-label">Tên khách hàng</label>
          <input type="text" id="hoten" name = "hoten" class="form-input" value="<?php echo $row["ho_ten"]; ?>"/>
        </div>
          <div class="form-group">
            <label for="sodienthoai" class="form-label">Số điện thoại</label>
            <input type="text" id="sodienthoai" name="sodienthoai" class="form-input" value="<?php echo $row["so_dien_thoai"]; ?>"/>
          </div>
        </div>
        <!-- Row 3 -->
        <div class="form-row">
          <div class="form-group">
            <label for="gioitinh" class="form-label">Giới tính</label>
            <!-- <input type="text" id="gioitinh" class="form-input" /> -->
            <select name="gioitinh" id="gioitinh" class="form-input">
                <?php 
                      if($row['gioi_tinh']=="Nam"){
                        echo '<option value="Nam" selected>Nam</option>';
                        echo '<option value="Nữ">Nữ</option>';
                      }                       
                      else{
                        echo '<option value="Nam" >Nam</option>';
                        echo '<option value="Nữ"selected>Nữ</option>';
                      }
                ?>
            </select>
          </div>
          <div class="form-group">
            <label for="diachi" class="form-label">Địa Chỉ</label>
            <input type="text" id="diachi" name ="diachi" class="form-input" value="<?php echo $row["dia_chi"]; ?>"/>
          </div>
        </div>
        <!-- Chức năng chọn ngày giờ-->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
            <script>
                flatpickr('#ngaysinh', {
                    enableTime: true,
                    dateFormat: "Y-m-d",
                    locale: "vi"
                });
            </script>
      <div class="edit-action">
        <input type="submit" value="Cập nhật" class="edit-btn" />
        <button type="button" class="edit-btn" onclick="window.location.href = 'khachhang.php?opt=view_kh'"> Huỷ </button>      </div>
      </form>
    <?php
    }
    ?>
    </section>
  </body>
</html>
