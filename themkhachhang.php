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
    <!-- Scripts -->
    <script src="./khachhang.js/scripts.js"></script>
    <!--Thư viên flatpickr để chọn ngày giờ-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
    />
  </head>
  <body>
    <!-- Header -->
    <header>
    <?php
      require_once "db_module.php";  
      include "header.php";   
    ?>
    <!-- Page Title -->
    <section id="page-title">
      <div class="container">
        <div class="home-title">
          <img src="./icon/khachhang-settings.svg" alt="" />
          <h1 class="title">Thêm khách hàng mới</h1>
          <button type="button" onclick="resetForm()" class="add-new-button2">
            Làm mới
          </button>
          <!--Chức năng làm mới form-->
          <script>
            function resetForm() {
              document.querySelector("form").reset();
            }
          </script>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section id="main-content-2">
      <form action="khachhang.php?opt=add_kh" class="edit-customer" method="post" enctype="multipart/form-data">
        <!-- Row 1 -->
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
              />
            </div>
            <div class="form-group-in">
              <label for="email" class="form-label">Email</label>
              <input type="email" id="email" name="email" class="form-input" />
            </div>
          </div>
        </div>
        <!-- Row 2 -->
        <div class="form-row">
          <div class="form-group">
          <label for="hoten" class="form-label">Tên khách hàng</label>
          <input type="text" id="hoten" name="hoten" class="form-input" />
        </div>
          <div class="form-group">
            <label for="sodienthoai" class="form-label">Số điện thoại</label>
            <input type="text" id="sodienthoai" name="sodienthoai" class="form-input" />
          </div>
        </div>
        <!-- Row 3 -->
        <div class="form-row">
          <div class="form-group">
            <label for="gioitinh" class="form-label">Giới tính</label>
            <!-- <input type="text" id="gioitinh" class="form-input" /> -->
            <select name="gioitinh" id="gioitinh" class="form-input">
              <option value="Nữ">Nữ</option>
              <option value="Nam">Nam</option>
            </select>
          </div>
          <div class="form-group">
            <label for="diachi" class="form-label">Địa Chỉ</label>
            <input type="text" id="diachi" name="diachi" class="form-input" />
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
      <input type="submit" value="Thêm" class="edit-btn" />
      <input type="button" value="Huỷ" class="edit-btn" onclick="window.location.href = 'khachhang.php?opt=view_kh'"/>
      </div>
      </form>
    </section>
  </body>
</html>
