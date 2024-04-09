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
    <link rel="stylesheet" href="css/khuyenmai.css" />
    <!--Thư viên flatpickr để chọn ngày giờ-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  </head>
  <body>
    <!-- Header -->
    <header>
    <?php
      require_once "db_module.php";  
      include "header.php";   
    ?>
    </header>
    <!-- Page Title -->
    <section id="page-title">
      <div class="container">
        <div class="home-title">
          <img src="./icon/sanpham-settings.svg" alt="" />
          <h1 class="title">Cập nhật danh sách coupon</h1>
          <button type="button" onclick="resetForm()" class="add-new-button2">Làm mới</button>
          <!--Chức năng làm mới form-->
          <script>
              function resetForm() {
            document.querySelector('form').reset();
              }
          </script>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section id="main-content-2">
    <!-- Kết nối vào CSDL -->
    <?php
    //Tạo kết nối vào CSDL
    require_once "db_module.php";
    $link = null;
    taoKetNoi($link);
    if(isset($_GET["id"])){
      $_idcp = $_GET["id"];
      $sql = "SELECT * FROM tbl_khuyenmai WHERE ma_coupon=?";
      
      // Sử dụng prepared statement để tránh lỗ hổng bảo mật SQL Injection
      $stmt = mysqli_prepare($link, $sql);
      
      // Bind tham số vào câu lệnh SQL
      mysqli_stmt_bind_param($stmt, "i", $_idcp);
      
      // Thực thi câu lệnh SQL
      mysqli_stmt_execute($stmt);
      
      // Lấy kết quả
      $result = mysqli_stmt_get_result($stmt);
      
      // Kiểm tra xem có dữ liệu trả về hay không
      if($result && mysqli_num_rows($result) > 0) {
          // Lấy dữ liệu từ trong DB ra
          $row = mysqli_fetch_assoc($result);
      } else {
          // Xử lý khi không có dữ liệu trả về
          // Ví dụ: thông báo lỗi, redirect, vv.
      }
      
      // Giải phóng biến prepared statement
      mysqli_stmt_close($stmt);
    }  
    ?>
    <form action="ds-khuyenmai.php?opt=add_cp" class="edit-coupon" method="post" enctype="multipart/form-data">
        <!-- Row 1 -->
        <div class="form-row1">
            <div class="form-group">
                <label for="macoupon" class="form-label">Mã coupon</label>
                <input type="text" id="macoupon" name="macoupon" class="form-input" value="<?php echo $row["ma_coupon"]; ?>"/>
            </div>
        </div>
        <!-- Row 2 -->
        <div class="form-row">
            <div class="form-group">
                <label for="giatrigiam" class="form-label">Giá trị giảm</label>
                <input type="number" id="giatrigiam" name="giatrigiam" class="form-input" value="<?php echo $row["gia_tri_giam"]; ?>"/>
            </div>
            <div class="form-group">
                <label for="giatridontoithieu" class="form-label">Giá trị đơn hàng tối thiểu</label>
                <input type="number" id="giatridontoithieu" name="giatridontoithieu" class="form-input" value="<?php echo $row["gia_tri_don_toi_thieu"]; ?>"/>
            </div>
        </div>
        <!-- Row 3 -->
        <div class="form-row">
            <div class="form-group">
                <label for="trangthai" class="form-label">Trạng thái</label>
                <select id="trangthai" name="trangthai" class="form-input">
                  <?php 
                    switch($row['trang_thai']) {
                    case 1:
                      echo '<option value="1" selected>Đang áp dụng</option>';
                      break;
                    case 2:
                      echo '<option value="2" selected>Chưa áp dụng</option>';
                      break;
                    case 3:
                      echo '<option value="3" selected>Ngừng áp dụng</option>';
                      break;
                    default:
                    // Xử lý mặc định nếu giá trị không phù hợp
                    break;
                    }
                  ?>
                </select>
            </div>
            <div class="form-group">
                <label for="luotsudung" class="form-label">Lượt sử dụng</label>
                <input type="number" id="luotsudung" name="luotsudung" class="form-input" value="<?php echo $row["luot_su_dung"]; ?>"/>          
            </div>
        </div>
        <!-- Row 4 -->
        <div class="form-row">
            <div class="form-group">
                <label for="thoigianbatdau" class="form-label">Thời gian bắt đầu</label>
                <input type="date" id="thoigianbatdau" name="thoigianbatdau" class="form-input" value="<?php echo $row["thoi_gian_bat_dau"]; ?>"/>
            </div>
            <div class="form-group">
                <label for="thoigianketthuc" class="form-label">Thời gian kết thúc</label>
                <input type="date" id="thoigianketthuc" name="thoigianketthuc" class="form-input" value="<?php echo $row["thoi_gian_ket_thuc"]; ?>"/>
            </div>
        </div>
        <!-- Chức năng chọn ngày giờ-->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
        <script>
            flatpickr('#thoigianbatdau', {
                enableTime: true,
                dateFormat: "Y-m-d",
                locale: "vi"
            });
            flatpickr('#thoigianketthuc', {
                enableTime: true,
                dateFormat: "Y-m-d",
                locale: "vi"
            });
        </script>
        <div class="edit-action">
            <button type="submit" class="edit-btn" name="submit_btn"> Cập nhật </button>
            <button type="button" class="edit-btn" onclick="window.location.href = 'ds-khuyenmai.php?opt=view_cp'"> Huỷ </button>
        </div>
    </form>
    <?php
    // Kiểm tra xem form đã được submit chưa và có dữ liệu được thêm vào CSDL thành công hay không
    if (isset($_POST['submit_btn'])) {
        // Kiểm tra điều kiện cập nhật thành công
        // Hiển thị thông báo cập nhật thành công
        echo "<script>alert('Cập nhật thành công');</script>";
    }
    ?>
    </section>
  </body>
</html>