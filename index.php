<!DOCTYPE html>
<html lang="vn">
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
    <link rel="stylesheet" href="css/sanpham.css" />
    <!-- Scripts -->
    <script src="./js/scripts.js"></script>
  </head>
  <body>
    <?php
      require_once "db_module.php";  
      include "header.php";
    ?>
    <!-- Page Title -->
    <section id="page-title">
      <div class="index_main">
        <div class="home-title">
          <img src="./icon/home.svg" alt="" />
          <h1 class="title">Thông tin chung</h1>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section id="main-content">
      <div class="container">
        <!-- Row 1 -->
        <div class="home-row">
          <!-- Item 1 -->
          <div class="home-item">
            <img src="./icon/collection.svg" alt="" />
            <div class="item">
              <h2 class="item-title">Danh mục sản phẩm</h2>
              <!-- Hiển thị số lượng danh mục từ database -->
              <?php
                $link = null;
                taoKetNoi($link);
                //Kết nối và lấy dữ liệu từ CSDL
                $result = chayTruyVanTraVeDL($link,"SELECT COUNT(*) AS so_luong_danh_muc FROM tbl_danhmuc");
                // Lấy kết quả
                $so_luong_danh_muc = mysqli_fetch_assoc($result)["so_luong_danh_muc"];
                echo "<span class='item-number'>".$so_luong_danh_muc."</span>";
                giaiPhongBoNho($link,$result);
              ?>         
            </div>
          </div>
          <!-- Item 2 -->
          <div class="home-item">
            <img src="./icon/diamond.svg" alt="" />
            <div class="item">
              <h2 class="item-title">Sản phẩm</h2>
              <!-- Hiển thị số lượng sản phẩm từ database -->
              <?php
                $link = null;
                taoKetNoi($link);
                //Kết nối và lấy dữ liệu từ CSDL
                $result = chayTruyVanTraVeDL($link,"SELECT COUNT(*) AS so_luong_san_pham FROM tbl_sanpham");
                // Lấy kết quả
                $so_luong_san_pham = mysqli_fetch_assoc($result)["so_luong_san_pham"];
                echo "<span class='item-number'>".$so_luong_san_pham."</span>";
                giaiPhongBoNho($link,$result);
              ?>     
            </div>
          </div>
          <!-- Item 3 -->
          <div class="home-item">
            <img src="./icon/shopping-bag.svg" alt="" />
            <div class="item">
              <h2 class="item-title">Đơn hàng</h2>
              <!-- Hiển thị số lượng đơn hàng từ database -->
              <?php
                $link = null;
                taoKetNoi($link);
                //Kết nối và lấy dữ liệu từ CSDL
                $result = chayTruyVanTraVeDL($link,"SELECT COUNT(*) AS so_luong_don_hang FROM tbl_donhang");
                // Lấy kết quả
                $so_luong_don_hang = mysqli_fetch_assoc($result)["so_luong_don_hang"];
                echo "<span class='item-number'>".$so_luong_don_hang."</span>";
                giaiPhongBoNho($link,$result);
              ?>    
            </div>
          </div>
        </div>
        <!-- Row 2 -->
        <div class="home-row">
          <!-- Item 4 -->
          <div class="home-item">
            <img src="./icon/customer.svg" alt="" />
            <div class="item">
              <h2 class="item-title">Khách hàng</h2>
              <!-- Hiển thị số lượng khách hàng từ database -->
              <?php
                $link = null;
                taoKetNoi($link);
                //Kết nối và lấy dữ liệu từ CSDL
                $result = chayTruyVanTraVeDL($link,"SELECT COUNT(*) AS so_luong_khach_hang FROM tbl_khachhang");
                // Lấy kết quả
                $so_luong_khach_hang = mysqli_fetch_assoc($result)["so_luong_khach_hang"];
                echo "<span class='item-number'>".$so_luong_khach_hang."</span>";
                giaiPhongBoNho($link,$result);
              ?>    
            </div>
          </div>
          <!-- Item 5 -->
          <div class="home-item">
            <img src="./icon/staff.svg" alt="" />
            <div class="item">
              <h2 class="item-title">Nhân viên</h2>
               <!-- Hiển thị số lượng nhân viên từ database -->
              <?php
                $link = null;
                taoKetNoi($link);
                //Kết nối và lấy dữ liệu từ CSDL
                $result = chayTruyVanTraVeDL($link,"SELECT COUNT(*) AS so_luong_nhan_vien FROM tbl_nhanvien");
                // Lấy kết quả
                $so_luong_nhan_vien = mysqli_fetch_assoc($result)["so_luong_nhan_vien"];
                echo "<span class='item-number'>".$so_luong_nhan_vien."</span>";
                giaiPhongBoNho($link,$result);
              ?>    
            </div>
          </div>
          <!-- Item 6 -->
          <div class="home-item">
            <img src="./icon/discount.svg" alt="" />
            <div class="item">
              <h2 class="item-title">Khuyến mãi</h2>
              <!-- Hiển thị số lượng khuyến mãi từ database -->
              <?php
                $link = null;
                taoKetNoi($link);
                //Kết nối và lấy dữ liệu từ CSDL
                $result = chayTruyVanTraVeDL($link,"SELECT COUNT(*) AS so_luong_khuyen_mai FROM tbl_khuyenmai");
                // Lấy kết quả
                $so_luong_khuyen_mai = mysqli_fetch_assoc($result)["so_luong_khuyen_mai"];
                echo "<span class='item-number'>".$so_luong_khuyen_mai."</span>";
                giaiPhongBoNho($link,$result);
              ?>    
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
