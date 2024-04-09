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
    <link rel="stylesheet" href="css/nhanvien.css" />
    <!-- Styles + JS cho phần variants -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script>
      $(function() {
        // Khởi tạo Datepicker cho input có id là "NgayTG"
        $("#NgayTG").datepicker();
      });
      function generateEmail() {
            var hoten = document.getElementById('Hoten').value;
            var email = hoten.toLowerCase().replace(/\s+/g, '.') + '@luxe.com';
            document.getElementById('Email').value = email;
            document.getElementById('displayEmail').textContent = email; // Hiển thị địa chỉ email
      }
    </script>
  </head>
  <body>
    <!-- Header -->
    <?php
      // File kết nối CSDL + header
      require_once "db_module.php"; 
      include "header.php";   
    ?>
    <?php
    <!-- Page Title -->
    <section id="page-title">
      <div class="container">
        <div class="home-title">
          <img src="./icon/suanhanvien-settings.svg" alt="" />
          <h1 class="title">Cập nhật thông tin nhân viên</h1>
          <a class="add-new-button2" href="nhanvien.html" id="Return" target="_blank">Quay lại</a> 
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
          $_idsp = $_GET["id"];
          $sql = "select * from tbl_nhanvien where ma_nhan_vien=".$_idnv;
          $result = chayTruyVanTraVeDL($link,$sql);
          //Lấy dữ liệu từ trong DB ra
          $row = mysqli_fetch_assoc($result);
            ?>
            <form action= "nhanvien.php?opt=update_nv" class="edit-nhanvien" method="post" enctype="multipart/form-data">
            <!-- Row 1 -->
            <div class="form-row">
              <input type="hidden" name="manv" value="<?php echo $row["ma_nhan_vien"]; ?>">
                <div class="form-group">
                <label for="hotennv" class="form-label">Họ tên nhân viên</label>
                <input type="text" id="hotennv" name="hotennv" class="form-input" value="<?php echo $row["ho_ten"]; ?>">
              </div>
              <div class="form-group">
                <label for="sdtnv" class="form-label">Số điện thoại</label>
                <input type="text" id="sdtnv" name="sdtnv" class="form-input" value="<?php echo $row["so_dien_thoai"]; ?>">
                <?php
                </input>
            </div>
            <!-- Row 2 -->
            <div class="form-row">
              <div class="form-group">
                <label for="Hoten" class="form-label">Họ tên nhân viên</label>
                <input type="text" id="Hoten" class="form-input" oninput="generateEmail()"/>
              </div>
              <div class="form-group">
                <label for="DCcutru" class="form-label">Địa chỉ cư trú</label>
                <input type="text" id="DCcutru" class="form-input" />
              </div>
            </div>
            <!-- Row 3 -->
            <div class="form-row">
              <div class="form-group">
                <label for="Gioitinh" class="form-label">Giới tính</label>
                <select name="Gioitinh" id="Gioitinh" class="form-input">
                  <option value="1">Nam</option>
                  <option value="2">Nữ</option>
                </select>
              </div>
              <div class="form-group">
                <label for="NgayTG" class="form-label">Ngày tham gia</label>
                <input type="text" id="NgayTG" class="form-input" />          
              </div>
            </div>
            <!-- Row 4 -->
            <div class="form-row">
              <div class="form-group">
                <label for="TrangThaiNV" class="form-label">Trạng thái</label>
                <select name="TrangThaiNV" id="TrangThaiNV" class="form-input">
                  <option value="1">Đang hoạt động</option>
                  <option value="2">Tạm nghỉ</option>
                  <option value="3">Đã nghỉ</option>
                </select>
              </div>
              <div class="form-group">
                <label for="Email" class="form-label">Email nhân viên</label>
                <input type="email" id="Email" class="form-input" disabled/>
                <p id="displayEmail"></p> <!-- Thêm phần tử HTML để hiển thị địa chỉ email -->
              </div>
            </div>
          </form>
          <div class="edit-action">
            <input type="submit" value="Cập nhật" class="edit-btn" />
            <input type="submit" value="Huỷ" class="edit-btn" />
          </div>
    </section>
  </body>
</html>
