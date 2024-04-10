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
    <script src="./js/scripts.js"></script>
  </head>
  <body>
    <!-- Header -->
    <?php
      require_once "db_module.php";  
      include "header.php";   
    ?>
    <!-- Page Title -->
    <section id="page-title">
      <div class="index_main">
        <div class="home-title">
          <img src="./icon/nhanvien-settings.svg" alt="" />
          <h1 class="title">Cập nhật danh sách nhân viên</h1>
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
      <form action="nhanvien.php?opt=add_nv" class="edit-nhanvien" method="post" enctype="multipart/form-data">
      <!-- Row 1 -->
        <div class="form-row">
          <div class="form-group">
            <label for="hotennv" class="form-label">Họ tên nhân viên</label>
            <input type="text" id="hotennv" name="hotennv" class="form-input"/>
            </div>
            <div class="form-group">
                <label for="sdtnv" class="form-label">Số điện thoại</label>
                <input type="text" id="sdtnv" name="sdtnv" class="form-input"/>
            </div>
        </div>
        <!-- Row 2 -->
        <div class="form-row">
                <div class="form-group">
                <label for="Gioitinh" class="form-label">Giới tính</label>
                <select name="Gioitinh" id="Gioitinh" class="form-input">
                    <option value="1">Nữ</option>
                    <option value="0">Nam</option>
                </select>
              </div>
              <div class="form-group">
                <label for="DCcutru" class="form-label">Địa chỉ cư trú</label>
                <input type="text" id="dcctnv" name="dcctnv" class="form-input" />
              </div>
            </div>
        <!-- Row 3 -->
        <div class="form-row">
            <div class="form-group">
                <label for="Email" class="form-label">Email nhân viên</label>
                <input type="email" id="Email" name="Email" class="form-input"/>
            </div>
              <div class="form-group">
                <label for="NgayTG" class="form-label">Ngày tham gia</label>
                <input type="date" id="NgayTG" name="ntgnv" class="form-input" />
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
            <button type="submit" class="edit-btn" name="submit_btn"> Thêm </button>
            <button type="button" class="edit-btn" onclick="window.location.href = 'nhanvien.php?opt=view_nv'"> Huỷ </button>
        </div>
    </form>
    </section>
  </body>
</html>
