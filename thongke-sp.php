<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Chỉnh biểu tượng web -->
    <link href="./icon/thongke-logo.svg" rel="shortcut icon" />
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
    <link rel="stylesheet" href="css/thongke.css" />
    <link rel="stylesheet" href="css/header.css" />
    <!-- Scripts -->
    <script src="./js/thongke.js"></script>
  </head>
  <body>
  <!-- Header -->
  <?php
      require_once "db_module.php";
      include "header.php";
    ?>
    <!-- Page Title -->
    <section id="page-title">
      <div class="container">
        <div class="home-title">
          <img src="./icon/thongke-statistical.svg" alt="" />
          <h1 class="title">Thống kê</h1>
        </div>
      </div>
    </section>
    <!--Page product sold-->
    <section id="page-product-sold">
      <div class="statistic">
          <!-- Tool- bar -->
          <div class="tool-bar">
            <div class="tool-bar__rest">
              <div class="cost">
                <img src="./icon/thongke-revenue.svg" alt="" />
                <a href="thongke-doanhthu.php" class="text-revenue">Doanh thu</a>
              </div>
              <div class="profit">
                <img src="./icon/thongke-cost.svg" alt="" />
                <a href="thongke-donhang.php" class="text-revenue">Đơn hàng</a>
              </div>
            </div>
            <div class="tool-bar__choose-cost">
              <img src="./icon/thongke-product-sold.svg" alt="" />
              <div class="text-revenue">Sản phẩm bán ra</div>
            </div>
            <div class="tool-bar__rest">
              <div class="cost">
                <img src="./icon/thongke-review.svg" alt="" />
                <a href="thongke-danhgia.php" class="text-revenue">Đánh giá</a>
              </div>
            </div>
          </div>
    
          <div class="revenue-statistics">
          <div class="revenue">

              <!-- Chọn ngày bắt đầu và ngày kết thúc để hiển thị tổng số lượng đơn hàng -->
              <div class="selectdate">

                  <!-- Chọn ngày bắt đầu -->
                  <form class="date-form1" id ="date-form1" method = "POST">
                    <label>Từ:</label>
                    <label for="start-day">Ngày</label>
                    <select id="start-day" name="start-day" class="custom-select" onclick="day()">
                      <?php for ($i = 1; $i <= 31; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php if (isset($_POST['start-day']) && $_POST['start-day'] == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                      <?php endfor; ?>
                    </select>
                    <label for="start-month">Tháng</label>
                    <select id="start-month" name="start-month" class="custom-select" onclick="month()">
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php if (isset($_POST['start-month']) && $_POST['start-month'] == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                      <?php endfor; ?>
                  </select>
                    <label for="start-year">Năm</label>
                    <select id="start-year" name="start-year" class="custom-select" onclick="year()">
                    <?php for ($i = 2020; $i <= 2024; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php if (isset($_POST['start-year']) && $_POST['start-year'] == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                      <?php endfor; ?>
                  </select>

                  <!-- Chọn ngày kết thúc -->
                  </form>
                  <form class="date-form2" id ="date-form2" method = "POST">
                    <label>Đến:</label>
                    <label for="end-day" class="endday">Ngày</label>
                    <select id="end-day" name="end-day" class="custom-select" onclick="day()" >
                    <?php for ($j = 1; $j <= 31; $j++): ?>
                        <option value="<?php echo $j; ?>" <?php if (isset($_POST['end-day']) && $_POST['end-day'] == $j) echo 'selected'; ?>><?php echo $j; ?></option>
                      <?php endfor; ?>
                  </select>
                    <label for="end-month">Tháng</label>
                    <select id="end-month" name="end-month" class="custom-select" onclick="month()">
                    <?php for ($j = 1; $j <= 12; $j++): ?>
                        <option value="<?php echo $j; ?>" <?php if (isset($_POST['end-month']) && $_POST['end-month'] == $j) echo 'selected'; ?>><?php echo $j; ?></option>
                      <?php endfor; ?>
                  </select>
                    <label for="end-year">Năm</label>
                    <select id="end-year" name="end-year" class="custom-select" onclick="year()">
                    <?php for ($j = 2020; $j <= 2024; $j++): ?>
                        <option value="<?php echo $j; ?>" <?php if (isset($_POST['end-year']) && $_POST['end-year'] == $j) echo 'selected'; ?>><?php echo $j; ?></option>
                      <?php endfor; ?>
                    </select>
                  </form>
                  <?php
                    $startDay = null;
                    $startMonth = null;
                    $startYear = null;
                    $endDay = null;
                    $endMonth = null;
                    $endYear = null;
                    
                    // Gửi dữ liệu từ form
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                      if (isset($_POST['start-day'])) {
                        $startDay = $_POST['start-day'];
                      }
                    
                      if (isset($_POST['start-month'])) {
                        $startMonth = sprintf("%02d", $_POST['start-month']);
                      }
                    
                      if (isset($_POST['start-year'])) {
                        $startYear = $_POST['start-year'];
                      }
                    
                      if (isset($_POST['end-day'])) {
                        $endDay = $_POST['end-day'];
                      }
                    
                      if (isset($_POST['end-month'])) {
                        $endMonth = sprintf("%02d", $_POST['end-month']);
                      }
                    
                      if (isset($_POST['end-year'])) {
                        $endYear = $_POST['end-year'];
                      }         
                      $link = null;
                      taoKetNoi($link); 

                      // Truy vấn để lấy tổng số lượng đơn hàng
                      $query = "SELECT SUM(ctdh.so_luong) AS total_quantity 
                                FROM tbl_donhang dh 
                                INNER JOIN tbl_chitiet_donhang ctdh ON dh.ma_don_hang = ctdh.ma_don_hang 
                                WHERE dh.ngay_tao >= '$startYear-$startMonth-$startDay 00:00:00' AND dh.ngay_tao <= '$endYear-$endMonth-$endDay 23:59:59'";
                      $result = chayTruyVanTraVeDL($link, $query);
                      $rows = mysqli_fetch_assoc($result);
                    }
                  ?>
              </div>

              <!-- Hiển thị tổng số lượng sản phẩm -->
              <div class="total-revenue">
                <?php if (isset($rows['total_quantity'])): ?>
                  <div class="total"><?php echo number_format($rows['total_quantity'], 0, "", "."); ?></div>
                <?php else: ?>
                  <div class="total">0</div>
                <?php endif; ?>
                  <div class="total-text" onclick="submitForms()">Tổng số lượng sản phẩm</div>
              </div>
              <script>
                  function submitForms() {
                    document.getElementById("date-form1").submit();
                    document.getElementById("date-form2").submit();
                  }
              </script>
            </div>

            <!-- Top 3 sản phẩm bán chạy nhất -->
            <p class="chart"> Top 3 sản phẩm bán chạy nhất </p>
            <!-- Table -->
            <table class="product-list">
              <thead>
                <tr>
                  <th>STT</th>
                  <th>Mã sản phẩm</th>
                  <th>Tên sản phẩm</th>
                  <th>Hình ảnh</th>
                  <th>Số lượng bán ra</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $link = null;
                  taoKetNoi($link);

                  // Truy vấn để lấy top 3 sản phẩm bán chạy nhất
                  $stt = 1;
                  $query_top = "SELECT sp.*, SUM(ctdh.so_luong) AS top_quantity 
                            FROM tbl_chitiet_donhang ctdh 
                            INNER JOIN tbl_sanpham sp ON ctdh.ma_san_pham = sp.ma_san_pham 
                            INNER JOIN tbl_donhang dh ON ctdh.ma_don_hang = dh.ma_don_hang 
                            WHERE dh.ngay_tao >= '$startYear-$startMonth-$startDay 00:00:00' AND dh.ngay_tao <= '$endYear-$endMonth-$endDay 23:59:59' 
                            GROUP BY ctdh.ma_san_pham ORDER BY `top_quantity` 
                            DESC LIMIT 3";
                  
                  // Hiển thị dữ liệu ra bảng
                  $result_top = ChayTruyVanTraVeDL($link, $query_top);
                  while ($row_top = mysqli_fetch_assoc($result_top)) {
                    $masanpham = $row_top['ma_san_pham'];
                    $tensanpham = $row_top['ten_san_pham'];
                    $hinhanh = $row_top['hinh_anh_1'];
                    $soluong = $row_top['top_quantity'];
                  ?>
                    <tr>
                      <td><?php echo $stt; ?></td>
                      <td><?php echo $masanpham; ?></td>
                      <td><?php echo $tensanpham; ?></td>
                      <td><?php echo '<img src="img/'.$hinhanh.'" alt=""" />'; ?></td>
                      <td><?php echo $soluong; ?></td>
                    </tr>
                  <?php
                  $stt ++;
                  }
                ?>
              </tbody>
            </table>

            <!-- Top 5 sản phẩm bán được đánh giá cao nhất -->
            <p class="chart"> Top 5 sản phẩm bán được đánh giá cao nhất </p>
            <!-- Table -->
            <table class="product-list">
              <thead>
                <tr>
                  <th>STT</th>
                  <th>Mã sản phẩm</th>
                  <th>Tên sản phẩm</th>
                  <th>Hình ảnh</th>
                  <th>Số sao</th>
                </tr>
              </thead>
              <tbody>
                <?php

                  // Truy vấn để lấy dữ liệu
                  $STT = 1;
                  $query_review = "SELECT sp.*, AVG(r.so_sao) AS average_rating 
                                FROM tbl_sanpham sp 
                                INNER JOIN tbl_review r ON sp.ma_san_pham = r.ma_san_pham 
                                WHERE r.ngay_tao >= '$startYear-$startMonth-$startDay 00:00:00' AND r.ngay_tao <= '$endYear-$endMonth-$endDay 23:59:59'
                                GROUP BY sp.ma_san_pham 
                                ORDER BY average_rating DESC LIMIT 5";
                  $result_review = mysqli_query($link, $query_review);

                  // Hiển thị dữ liệu ra bảng
                  while ($row_review = mysqli_fetch_assoc($result_review)) {
                    $masanpham = $row_review['ma_san_pham'];
                    $tensanpham = $row_review['ten_san_pham'];
                    $hinhanh = $row_review['hinh_anh_1'];
                    $soluong = number_format($row_review['average_rating'], 1, '.', '');
                  ?>
                  <tr>
                      <td><?php echo $STT; ?></td>
                      <td><?php echo $masanpham; ?></td>
                      <td><?php echo $tensanpham; ?></td>
                      <td><?php echo '<img src="img/'.$hinhanh.'" alt=""" />'; ?></td>
                      <td><?php echo $soluong; ?></td>
                    </tr>   
                  <?php
                  $STT ++;
                  }
                ?>
              </tbody>
            </table>
          </div>
      </div>
    </section>
