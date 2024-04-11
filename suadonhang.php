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
    <link rel="stylesheet" href="css/donhang.css" />
    <link rel="stylesheet" href="css/header.css" />
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
          <h1 class="title">Cập nhật đơn hàng</h1>
        </div>
      </div>
    </section>
     <!-- Main content -->
     <section id="main-content-2">
        <!-- Kết nối vào CSDL -->
    <?php
        require_once "db_module.php";
        $link = null;
        taoKetNoi($link);

        $row = array(); // Khởi tạo mảng $row

        if(isset($_GET["id"])){
            $_iddh = $_GET["id"];
            $sql = "select * from tbl_donhang where ma_don_hang='$_iddh'";
            $result = chayTruyVanTraVeDL($link, $sql);
            $row = mysqli_fetch_assoc($result);
        }
    ?>
      <form action="donhang.php?opt=update_dh" class="edit-bill" method="post" enctype="multipart/form-data">
      <!-- Row 1 -->
        <div class="form-row">
          <div class="form-group">
            <label for="tendh" class="form-label">Tên đơn hàng</label>
            <input type="text" id="tendh" name="tendh" class="form-input" value="<?php echo ($row["ma_don_hang"])?>"/>
          </div>
          <div class="form-group">
            <label for="ngaytao" class="form-label">Ngày tạo</label>
            <input type="text" id="ngaytao" name="ngaytao" class="form-input" placeholder="Năm-tháng-ngày" value="<?php echo ($row["ngay_tao"])?>"/>
          </div>
        </div>
         <!-- Row 2 -->
         <div class="form-row">
          <div class="form-group">
            <label for="diachigiao" class="form-label">Địa chỉ giao</label>
            <input type="text" id="diachigiao" name="diachigiao" class="form-input" value="<?php echo ($row["dia_chi_giao_hang"])?>" />
          </div>
          <div class="form-group">
            <label for="tongtien" class="form-label">Tổng tiền</label>
            <input name="tongtien" id="tongtien" class="form-input" value="<?php echo ($row["tong_tien"])?>">
          </div>
        </div>
         <!-- Row 3 -->
         <div class="form-row">
          <div class="form-group">
            <label for="macoupon" class="form-label">Mã Coupon</label>
            <input type="text" id="macoupon" name="macoupon" class="form-input" value="<?php echo ($row["ma_coupon"])?>"/>
          </div>
          <div class="form-group">
            <label for="makhachhang" class="form-label">Mã khách hàng</label>
            <input type="text" id="makhachhang" name="makhachhang" class="form-input" value="<?php echo ($row["ma_khach_hang"])?>"/>
          </div>
        </div>
        <!-- Row 4 -->
        <div class="form-row">
          <div class="form-group"> 
            <label for='giamgia' class='form-label'>Giảm giá</label>
            <input type='text' id='giamgia' name='giamgia' readonly ='readonly' class='form-input' value="<?php echo ($row["giam_gia"])?>">     
            </div>
            <div class="form-group">
                <label for="tongthanhtoan" class="form-label">Tổng thanh toán</label>
                <input type="text" id="tongthanhtoan" name="tongthanhtoan" class="form-input" value="<?php echo ($row["tong_thanh_toan"])?>"/>
            </div>
        </div>
          </div>
        <!-- Row 5 -->
        <div class="form-row">
          <div class="form-group">
            <label for="phuongthucthanhtoan" class="form-label">Phương thức thanh toán</label>
            <select id="phuongthucthanhtoan" name="phuongthucthanhtoan" class="form-input">
            <?php 
                        $phuong_thuctt = $row['phuong_thuc_thanh_toan'];
                        $options = array("Thanh toán khi nhận hàng", "Cổng thanh toán Momo");
                        foreach ($options as $option) {
                            if ($option ==  $phuong_thuctt) {
                                echo "<option value=\"$option\" selected>$option</option>";
                            } else {
                                echo "<option value=\"$option\">$option</option>";
                            }
                        }
                    ?>
                </select>                           
          </div>
          <div class="form-group">
            <label for="tinhtrang" class="form-label">Tình trạng</label>
            <select id="tinhtrang" name="tinhtrang" class="form-input">
            <?php 
                        $tinh_trang = $row['tinh_trang'];
                        $options = array("Chưa giao", "Đã giao");
                        foreach ($options as $option) {
                            if ($option ==  $tinh_trang) {
                                echo "<option value=\"$option\" selected>$option</option>";
                            } else {
                                echo "<option value=\"$option\">$option</option>";
                            }
                        }
                    ?>              
                </select>
          </div>
        </div>
         <!-- Row 6 -->
        
         <div class="form-group">
            <label for="ghichu" class="form-label">Ghi chú</label>
            <input type="text" id="ghichu" name="ghichu" class="form-input" value="<?php echo ($row["ghi_chu"])?>"/>
          </div>
      
        <div class="edit-action">
          <input type="submit" value="Cập nhật" class="edit-btn" />
          <input type="button" value="Huỷ" class="edit-btn" onclick="window.location.href = 'donhang.php?opt=view_dh'"/>
        </div>
      </form>
    </section>
  </body>
</html>