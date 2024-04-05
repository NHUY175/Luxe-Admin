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
    <link rel="stylesheet" href="css/sanpham.css" />
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
          <img src="./icon/settings.svg" alt="" />
          <h1 class="title">Cập nhật thông tin sản phẩm</h1>
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
          $sql = "select * from tbl_sanpham where ma_san_pham=".$_idsp;
          //echo $sql;
          $result = chayTruyVanTraVeDL($link,$sql);
          //Lấy dữ liệu từ trong DB ra
          $row = mysqli_fetch_assoc($result);
            ?>
            <form action= "sanpham.php?opt=update_sp" class="edit-product" method="post" enctype="multipart/form-data">
              <!-- Row 1 -->
              <div class="form-row">
                <input type="hidden" name="masp" value="<?php echo $row["ma_san_pham"]; ?>">
                <div class="form-group">
                  <label for="tensp" class="form-label">Tên sản phẩm</label>
                  <input type="text" id="tensp" name="tensp" class="form-input" value="<?php echo $row["ten_san_pham"]; ?>">
                </div>
                <div class="form-group">
                  <label for="danhmuc" class="form-label">Danh mục</label>
                  <!-- <input type="text" id="DanhMuc" class="form-input" /> -->
                  <select name="danhmuc" id="danhmuc" class="form-input" <?php if ($_thao_tac == "edit") { echo "<option value=".$row_sp['ma_danh_muc']." selected>".$rows['ten_danh_muc']."</option>" ;} ?>>
                  <?php
                    $link = null;
                    taoKetNoi($link);
                    $danhmuc = chayTruyVanTraVeDL($link,"select * from tbl_danhmuc");
                    while ($rows = mysqli_fetch_assoc($danhmuc)) {
                      if($row['ma_danh_muc']==$rows['ma_danh_muc']){
                        echo "<option value=".$rows['ma_danh_muc']." selected>".$rows['ten_danh_muc']."</option>";
                      }                       
                      else {
                          echo "<option value=".$rows['ma_danh_muc'].">".$rows['ten_danh_muc']."</option>";
                      }
                    }
                    mysqli_free_result($danhmuc);    
                  ?>
                  </select>
                </div>
              </div> 
              <!-- Row 2  -->
              <div class="form-row">
                <div class="form-group">
                  <label for="chatlieu" class="form-label">Chất liệu</label>
                  <input type="text" id="chatlieu" name="chatlieu" class="form-input" value="<?php echo $row["chat_lieu"]; ?>"/>
                </div>
                <div class="form-group">
                  <label for="trangthai" class="form-label">Trạng thái</label>
                  <select name="trangthai" id="trangthai" class="form-input">
                    <?php 
                      if($row['trang_thai']==1){
                        echo '<option value="1" selected>Hiển thị</option>';
                        echo '<option value="0">Không hiển thị</option>';
                      }                       
                      else {
                        echo '<option value="1">Hiển thị</option>';
                        echo '<option value="0" selected>Không hiển thị</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <!-- Row 3 -->
              <div class="form-row">
                <div class="form-group">
                  <label for="khoiluong" class="form-label">Khối lượng (g)</label>
                  <input type="number" id="khoiluong" name="khoiluong" class="form-input" value="<?php echo $row["khoi_luong"]; ?>"/>
                </div>
                <div class="form-group">
                  <label for="giagoc" class="form-label">Giá gốc</label>
                  <input type="number" id="giagoc" name="giagoc" class="form-input" value="<?php echo $row["gia_goc"]; ?>"/>
                </div>
              </div>
              <!-- Row 4 -->
              <div class="form-row">
                <div class="form-group">
                  <label for="loaida" class="form-label">Loại đá</label>
                  <input type="text" id="loaida" name="loaida" class="form-input" value="<?php echo $row["loai_da"]; ?>"/>
                </div>
                <div class="form-group">
                  <label for="giagiam" class="form-label">Giá giảm</label>
                  <input type="number" id="giagiam" name="giagiam" class="form-input" value="<?php echo $row["gia_giam"]; ?>"/>
                </div>
              </div>
              <!-- Row 5 -->
              <div class="form-row">
                <div class="form-group">
                  <label for="kichthuocda" class="form-label">Kích thước đá (mm)</label>
                  <input type="number" id="kichthuocda" name="kichthuocda" class="form-input" value="<?php echo $row["kich_thuoc_da"]; ?>"/>
                </div>
                <div class="form-group">
                  <label for="hinhanhsp" class="form-label">Hình ảnh</label>
                  <input type="file" id="hinhanhsp" name="hinhanh1" class="file-pro" title="Hình ảnh 1"/>
                  <input type="hidden" name="img_name_1" value="<?php echo $row["hinh_anh_1"]; ?>">
                  <input type="file" name="hinhanh2" class="file-pro" title="Hình ảnh 2"/>
                  <input type="hidden" name="img_name_2" value="<?php echo $row["hinh_anh_2"]; ?>">
                  <input type="file" name="hinhanh3" class="file-pro" title="Hình ảnh 3"/>
                  <input type="hidden" name="img_name_3" value="<?php echo $row["hinh_anh_3"]; ?>">
                </div>       
              </div>
              <!-- Row 6 -->
              <div class="form-group-variant">
                <label for="HinhAnhSP" class="form-label">Biến thể</label>
                <?php
                  $link = null;
                  taoKetNoi($link);
                  //Kết nối và lấy dữ liệu từ CSDL
                  $result = chayTruyVanTraVeDL($link,"SELECT * FROM tbl_bienthe WHERE ma_san_pham=".$_idsp);           
                  echo '<table class="table table-bordered" id="dynamic_field">';
                  $i = 0;
                  while ($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo '<input type="hidden" name="mabienthe[]" value="'.$row["ma_bien_the"].'"/></td>';
                    echo '<td><input type="text" name="tenbienthe[]" placeholder="Nhập tên biến thể" class="form-control name_list" value="'.$row["ten_bien_the"].'"/></td>';
                    echo '<td><input type="number" name="soluong[]" placeholder="Nhập số lượng" class="form-control name_list" value="'.$row["so_luong"].'"/></td>';
                    echo "</tr>";
                  }
                  echo "</table>";
                  giaiPhongBoNho($link,$result);
                }
                // mysqli_free_result($result);   
                ?>  
              </div>    
              <div class="edit-action">
                <input type="submit" value="Cập nhật" class="edit-btn" />
                <input type="button" value="Huỷ" class="edit-btn" onclick="window.location.href = 'sanpham.php?opt=view_sp'"/>
              </div>
            </form>
    </section>
  </body>
</html>
