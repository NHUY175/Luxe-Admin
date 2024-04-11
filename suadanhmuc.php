<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Chỉnh biểu tượng web -->
  <link href="./icon/Logo.svg" rel="shortcut icon" />
  <title>Luxe - Admin</title>
  <!-- GG Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
  <!-- Styles -->
  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="css/danhmuc.css" />
  <link rel="stylesheet" href="css/header.css" />
  <!-- FONT AWESOME - THƯ VIỆN ICON -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
</head>

<body>
  <div class="edit-dmsp">
    <!-- Header -->
    <?php
    require_once "db_module.php";
    include "header.php";
    ?>

    <!-- Page Title -->
    <div class="container-title-edit">
      <div class="home-title-edit-danhmuc">
        <div style="display: flex; align-items: center">
          <img src="./icon/sanpham-settings.svg" alt="" width="37px" />
          <h1 class="title">CẬP NHẬT DANH MỤC SẢN PHẨM</h1>
        </div>
      </div>
    </div>
    <?php
    // Tạo kết nối vào CSDL
    require_once "db_module.php";
    $link = null;
    taoKetNoi($link);
    if (isset($_GET["id"])) {
      $_iddm = $_GET["id"];
      $sql = "SELECT * FROM tbl_danhmuc WHERE ma_danh_muc=" . $_iddm;
      $result = chayTruyVanTraVeDL($link, $sql);
      $row = mysqli_fetch_assoc($result);
      ?>
      <!-- Main content -->
      <form action="danhmuc.php?opt=update_dmsp" method="post" enctype="multipart/form-data">
        <section id="main-cate-edit-content">
          <div class="input-editDMSP-frame">
            <!-- Mã danh mục  -->
            <input type="hidden" name="ma_danhmuc" value="<?php echo $row["ma_danh_muc"]; ?>">

            <!-- tên -->
            <div class="form-group">
              <label for="TenDMSP" class="form-DMSP-label">Tên danh mục <span style="color: red">*</span></label>
              <input type="text" name="ten_danhmuc" class="form-control" id="ten_danhmuc" placeholder="Nhập tên danh mục"
                required value="<?php echo $row["ten_danh_muc"]; ?>" />
            </div>

            <div class="form-group">
              <label for="HinhAnhDMSP" class="form-DMSP-label">Hình ảnh </label>
              <input type="file" id="HinhAnhDMSP" name="hinhanh" class="file-procat" title="Hình ảnh" />
              <!-- Hiển thị hình ảnh hiện tại nếu có -->
              <?php if ($row["hinh_anh_danh_muc"]) { ?>
                <img src="./img/<?php echo $row["hinh_anh_danh_muc"]; ?>" alt="Hình ảnh" width="200px" />
                <!-- Hiển thị tên hình ảnh -->
                <p><?php echo $row["hinh_anh_danh_muc"]; ?></p>
              <?php } ?>
              <!-- Hiển thị tên hình ảnh -->

              <input type="hidden" name="img_name" value="<?php echo $row["hinh_anh_danh_muc"]; ?>">
            </div>
            <div class="edit-action">
              <input type="submit" value="Cập nhật" class="btn btn-update" id="update-button" />
              <input type="button" value="Hủy" class="btn btn-secondary" onclick="window.location.href = 'danhmuc.php'" />
            </div>
          </div>
        </section>
      </form>
      <?php
    }
    ?>
  </div>

</body>

</html>