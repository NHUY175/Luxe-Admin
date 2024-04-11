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
          <h1 class="title">Thêm đơn hàng</h1>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section id="main-content-2">
      <form action="donhang.php?opt=add_dh" class="edit-bill" method="post" enctype="multipart/form-data">
      <!-- Row 1 -->
        <div class="form-row">
          <div class="form-group">
            <label for="tendh" class="form-label">Tên đơn hàng</label>
            <input type="text" id="tendh" name="tendh" class="form-input"/>
          </div>
          <div class="form-group">
            <label for="ngaytao" class="form-label" >Ngày tạo</label>
            <input type="text" id="ngaytao" name="ngaytao" class="form-input" placeholder="Năm-tháng-ngày"/>
          </div>
        </div>
        <!-- Row 2 -->
        <div class="form-row">
          <div class="form-group">
            <label for="diachigiao" class="form-label">Địa chỉ giao</label>
            <input type="text" id="diachigiao" name="diachigiao" class="form-input" />
          </div>
          <div class="form-group">
            <label for="tongtien" class="form-label">Tổng tiền</label>
            <input name="tongtien" id="tongtien" class="form-input">
          </div>
        </div>
        <!-- Row 3 -->
        <div class="form-row">
          <div class="form-group">
            <label for="macoupon" class="form-label">Mã Coupon</label>
            <input type="text" id="macoupon" name="macoupon" class="form-input"/>
          </div>
          <div class="form-group">
            <label for="makhachhang" class="form-label">Mã khách hàng</label>
            <input type="text" id="makhachhang" name="makhachhang" class="form-input"/>
          </div>
        </div>
        <!-- Row 4 -->
        <div class="form-row">
          <div class="form-group"> 
            <?php
            //Kết nối và lấy dữ liệu từ CSDL
              $link = null;
              taoKetNoi($link);         
                $coupon = chayTruyVanTraVeDL($link,"SELECT gia_tri_giam FROM tbl_khuyenmai Where ma_coupon = 'macoupon';");           
                $row = mysqli_fetch_assoc($coupon);
               if( $row!=""){  
                    echo"<label for='giamgia' class='form-label'>Giảm giá</label>";
                    echo "<input type='text' id='giamgia' name='giamgia' readonly ='readonly'class='form-input' value=".$row["gia_tri_giam"].">";
                }
                else{
                    echo"<label for='giamgia' class='form-label'>Giảm giá</label>";
                    echo "<input type='text' id='giamgia' name='giamgia' readonly ='readonly'class='form-input' value=''>";
                }
              ?>
              
            </div>
            <div class="form-group">
                <label for="tongthanhtoan" class="form-label">Tổng thanh toán</label>
                <input type="text" id="tongthanhtoan" name="tongthanhtoan" class="form-input" value=""/>
            </div>
        </div>
          </div>
        <!-- Row 5 -->
        <div class="form-row">
          <div class="form-group">
            <label for="phuongthucthanhtoan" class="form-label">Phương thức thanh toán</label>
            <select id="phuongthucthanhtoan" name="phuongthucthanhtoan" class="form-input">
                <option value="1">Thanh toán khi nhận hàng</option>
                <option value="2">Cổng thanh toán Momo</option>              
                </select>
          </div>
          <div class="form-group">
            <label for="tinhtrang" class="form-label">Tình trạng</label>
            <select id="tinhtrang" name="tinhtrang" class="form-input">
                <option value="1">Chưa giao</option>
                <option value="2">Đã giao</option>              
                </select>
          </div>
        </div>
        <!-- Row 6 -->
        
        <div class="form-group">
            <label for="ghichu" class="form-label">Ghi chú</label>
            <input type="text" id="ghichu" name="ghichu" class="form-input" value=""/>
          </div>
      
        <div class="edit-action">
          <input type="submit" value="Thêm" class="edit-btn" />
          <input type="button" value="Huỷ" class="edit-btn" onclick="window.location.href = 'donhang.php?opt=view_dh'"/>
        </div>
      </form>
    </section>
  </body>
</html>
