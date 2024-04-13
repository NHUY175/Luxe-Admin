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
    <link rel="stylesheet" href="css/header.css" />
    <!--Thư viên flatpickr để chọn ngày giờ-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
          <h1 class="title">Thêm nhân viên mới</h1>

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
                <label for="sodienthoainv" class="form-label">Số điện thoại</label>
                <input type="text" id="sodienthoainv" name="sodienthoainv" class="form-input"/>
                <span id="sodienthoai-error" class="error-message"></span> <!-- Thêm phần tử để chứa thông báo lỗi -->
            </div>
        </div>
        <!-- Row 2 -->
        <div class="form-row">
                <div class="form-group">
                <label for="gioitinhnv" class="form-label">Giới tính</label>
                <select name="gioitinhnv" id="gioitinhnv" class="form-input">
                    <option value="Nữ">Nữ</option>
                    <option value="Nam">Nam</option>
                </select>
              </div>
              <div class="form-group">
                <label for="diachicutru" class="form-label">Địa chỉ cư trú</label>
                <input type="text" id="diachicutru" name="diachicutru" class="form-input" />
              </div>
            </div>
        <!-- Row 3 -->
        <div class="form-row">
            <div class="form-group">
                <label for="emailnv" class="form-label">Email nhân viên</label>
                <input type="emailnv" id="emailnv" name="emailnv" class="form-input"/>
            </div>
              <div class="form-group">
                <label for="ngaythamgia" class="form-label">Ngày tham gia</label>
                <input type="date" id="ngaythamgia" name="ngaythamgia" class="form-input" />
              </div>        
            </div>
        <!-- Chức năng chọn ngày giờ-->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
        <script>
            flatpickr('#ngaythamgia', {
                enableTime: true,
                dateFormat: "Y-m-d",
                locale: "vi"
            });
            document.addEventListener('DOMContentLoaded', function() {
        var sodienthoaiInput = document.getElementById('sodienthoainv');
        var sodienthoaiError = document.getElementById('sodienthoai-error');

        document.querySelector('form').addEventListener('submit', function(event) {
            var sodienthoaiValue = sodienthoaiInput.value;
            
            if (sodienthoaiValue.length !== 10) {
                sodienthoaiError.textContent = 'Số điện thoại phải có đúng 10 chữ số!';
                sodienthoaiError.style.display = 'block'; // Hiển thị thông báo lỗi
                event.preventDefault(); // Ngăn chặn việc gửi form nếu điều kiện không đúng
            } else {
                sodienthoaiError.textContent = ''; // Xóa nội dung thông báo nếu điều kiện đúng
                sodienthoaiError.style.display = 'none'; // Ẩn thông báo lỗi
            }
        });

        // Thêm sự kiện input để ẩn thông báo lỗi khi người dùng nhập lại dữ liệu
        sodienthoaiInput.addEventListener('input', function() {
            sodienthoaiError.textContent = ''; // Xóa nội dung thông báo khi người dùng bắt đầu nhập
            sodienthoaiError.style.display = 'none'; // Ẩn thông báo lỗi
        });
    });

    function removeVietnameseAccent(str) {
        return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    document.addEventListener('DOMContentLoaded', function() {
        var hotenInput = document.getElementById('hotennv');
        var emailInput = document.getElementById('emailnv');

        hotenInput.addEventListener('input', function() {
            var hotenValue = hotenInput.value.trim();
            var lastname = '';
            var firstname = '';

            // Tách họ và tên
            var hotenArray = hotenValue.split(' ');
            if (hotenArray.length > 2) {
                firstname = hotenArray[0];
                lastname = hotenArray.pop();
            } else if (hotenArray.length === 2) {
                firstname = hotenArray[0];
                lastname = hotenArray[1];
            } else if (hotenArray.length === 1) {
                lastname = hotenArray[0];
            }

            // Loại bỏ dấu tiếng Việt và chuyển thành lowercase
            lastname = removeVietnameseAccent(lastname).toLowerCase();
            firstname = removeVietnameseAccent(firstname).toLowerCase();

            // Tạo địa chỉ email
            var generatedEmail = lastname + '.' + firstname + '@luxe.com';

            // Gán địa chỉ email vào ô nhập liệu
            emailInput.value = generatedEmail;
        });
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
