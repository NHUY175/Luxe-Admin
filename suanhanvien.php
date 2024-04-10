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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    
  </head>
  <body>
    <!-- Header -->
    <?php
      // File kết nối CSDL + header
      require_once "db_module.php"; 
      include "header.php";   
    ?>
    <!-- Page Title -->
    <section id="page-title">
      <div class="container">
        <div class="home-title">
          <img src="./icon/suanhanvien-settings.svg" alt="" />
          <h1 class="title">Cập nhật thông tin nhân viên</h1>
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
        $row = array(); // Khởi tạo mảng $row
        if(isset($_GET["id"])){
          $_idnv = $_GET["id"];
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
              </div>
            </div>
            <!-- Row 2 -->
            <div class="form-row">
                <div class="form-group">
                <label for="Gioitinh" class="form-label">Giới tính</label>
                <select name="Gioitinh" id="Gioitinh" class="form-input">
                  <?php 
                      if($row['gioi_tinh']==1){
                        echo '<option value="1" selected>Nữ</option>';
                        echo '<option value="0">Nam</option>';
                      }                       
                      else {
                        echo '<option value="1">Nữ</option>';
                        echo '<option value="0" selected>Nam</option>';
                      }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label for="DCcutru" class="form-label">Địa chỉ cư trú</label>
                <input type="text" id="dcctnv" name="dcctnv" class="form-input" value="<?php echo $row["dia_chi_cu_tru"]; ?>">
              </div>
            </div>
            <!-- Row 3 -->
            <div class="form-row">
            <div class="form-group">
                <label for="Email" class="form-label">Email nhân viên</label>
                <input type="text" id="Email" name="Email" class="form-input" value="<?php echo $row["email"]; ?>">
            </div>
              <div class="form-group">
                <label for="NgayTG" class="form-label">Ngày tham gia</label>
                <input type="text" id="NgayTG" name="ntgnv" class="form-input" value="<?php echo $row["ngay_tham_gia"]; ?>">
              </div>        
            </div>
            <!-- Chức năng chọn ngày giờ-->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
        <script>
            flatpickr('#NgayTG', {
                enableTime: true,
                dateFormat: "Y-m-d",
                locale: "vi"
            });
        </script>   
          <div class="edit-action">
            <button type="submit" class="edit-btn" name="submit_btn"> Cập nhật </button>
            <button type="button" class="edit-btn" onclick="window.location.href = 'nhanvien.php?opt=view_nv'"> Huỷ </button>
        </div>
    </form>
    <?php
        giaiPhongBoNho($link,$result);
    ?>           
    </section>
  </body>
</html>