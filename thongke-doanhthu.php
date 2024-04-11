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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    <!-- Page revenue -->
    <section id="page-revenue">
      <div class="statistic">
          <!-- Tool- bar -->
          <div class="tool-bar">
            <div class="tool-bar__choose">
              <img src="./icon/thongke-revenue.svg" alt="" />
              <div class="text-revenue">Doanh thu</div>
            </div>
            <div class="tool-bar__rest">
              <div class="cost">
                <img src="./icon/thongke-cost.svg" alt="" />
                <a href="./thongke-donhang.php" class="text-revenue">Đơn hàng</a>
              </div>
              <div class="profit">
                <img src="./icon/thongke-product-sold.svg" alt="" />
                <a href="./thongke-sp.php" class="text-revenue">Sản phẩm bán ra</a>
              </div>
              <div class="profit">
                <img src="./icon/thongke-review.svg" alt="" />
                <a href="./thongke-danhgia.php" class="text-revenue">Đánh giá</a>
              </div>
            </div>
          </div>

          <div class="revenue-statistics">

            <!-- Chọn ngày bắt đầu và ngày kết thúc để hiển thị tổng doanh thu -->
            <div class="revenue">
              <div class="selectdate">

                  <!-- Form chọn ngày bắt đầu -->
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
                  </form>

                  <!-- Form chọn ngày kết thúc -->
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

                      // Truy vấn để tính tổng doanh thu
                      $link = null;
                      taoKetNoi($link);
                      $query = "SELECT SUM(tong_thanh_toan) AS total_amount 
                                FROM tbl_donhang 
                                WHERE ngay_tao >= '$startYear-$startMonth-$startDay 00:00:00' 
                                AND ngay_tao <= '$endYear-$endMonth-$endDay 23:59:59'
                                AND tinh_trang != 'Chưa giao'";
                      $result = chayTruyVanTraVeDL($link, $query);
                      $rows = mysqli_fetch_assoc($result);
                    }
                  ?>
              </div>

              <!-- Xuất kết quả tổng doanh thu -->
              <div class="total-revenue">
                <?php if (isset($rows['total_amount'])): ?>
                  <div class="total"><?php echo number_format($rows['total_amount'], 0, "", "."); ?> VNĐ</div>
                <?php else: ?>
                  <div class="total">0</div>
                <?php endif; ?>
                  <div class="total-text" onclick="submitForms()">Tổng doanh thu</div>
              </div>
              <script>
                  function submitForms() {
                    document.getElementById("date-form1").submit();
                    document.getElementById("date-form2").submit();
                  }
              </script>
            </div>

            <!-- Vẽ biểu đồ đường doanh thu theo tháng -->
            <p class="chart">Biểu đồ đường doanh thu theo tháng</p>
            <canvas id="myChart"></canvas>
            <?php 

              // Truy vấn để lấy thời gian theo tháng-năm và tổng doanh thu theo tháng-năm
              $link = null;
              taoKetNoi($link);
              $query = "SELECT DATE_FORMAT(ngay_tao, '%m-%Y') AS thang_nam, SUM(tong_thanh_toan) AS total_amount 
                        FROM tbl_donhang 
                        WHERE ngay_tao >= '$startYear-$startMonth-$startDay 00:00:00' 
                        AND ngay_tao <= '$endYear-$endMonth-$endDay 23:59:59'
                        GROUP BY thang_nam";

              $result = chayTruyVanTraVeDL($link, $query);
              $labelData = array();
              $totalAmountData = array();

              while ($rows = mysqli_fetch_assoc($result)) {
                $thangNam = $rows['thang_nam'];
                list($thang, $nam) = explode('-', $thangNam);
                $labelData[] = "$thang-$nam";

                $totalAmount = $rows['total_amount'];
                $totalAmountData[] = number_format($totalAmount, 0, '', '');
              }
            ?>

            <!-- Script để vẽ biểu đồ -->
            <script>
              var labelData = <?php echo json_encode($labelData); ?>;
              var totalAmountData = <?php echo json_encode($totalAmountData); ?>;

              document.addEventListener('DOMContentLoaded', function() {
                chart();
              });

              function chart() {
                // Tạo dữ liệu cho biểu đồ
                var data = {
                  labels: labelData, //Gắn dữ liệu tháng năm vào cột x
                  datasets: [{
                    label: "Doanh thu",
                    data: totalAmountData, //Gắn dữ liệu tổng doanh thu theo tháng năm vào cột y
                    borderColor: "blue",
                    fill: false
                  }]
                };

                // Cấu hình biểu đồ
                var options = {
                  scales: {
                    x: {
                      display: true,
                      title: {
                        display: false,
                      }
                    },
                    y: {
                      display: true,
                      title: {
                        display: false,
                      }
                    }
                  }
                };

                // Vẽ biểu đồ
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                  type: 'line',
                  data: data,
                  options: options
                });
              }
            </script>
          </div>
      </div>
    </section>
  </body>