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
    <link rel="stylesheet" href="css/khuyenmai.css" />
  </head>
  <body>
    <!-- Header -->
    <header>
    <?php
      // File kết nối CSDL + header
      require_once "db_module.php"; 
      include "header.php";   
    ?>
    <?php
      $link = null;
      taoKetNoi($link);
      //Kết nối và lấy dữ liệu từ CSDL > Tiến hành phân trang
      //Số lượng mã coupon
      $khuyenmai = chayTruyVanTraVeDL($link,"SELECT COUNT(*) AS so_luong_san_pham FROM tbl_sanpham");
      $so_luong_san_pham = mysqli_fetch_assoc($khuyenmai)["so_luong_san_pham"];
      // Tính toán số trang
      $so_trang = ceil($so_luong_san_pham / 10);
      giaiPhongBoNho($link,$so_luong_san_pham);
    ?>
      <div class="container">
        <div class="top-bar">
          <!-- Logo -->
          <a href="./" class="logo-nav">
            <img src="./icon/Logo.svg" alt="Luxe" />
            <h1 class="logo-title">Luxe</h1>
          </a>
          <!-- nav = navigation giống div nhưng có ngữ nghĩa -->
          <!-- Navigation -->
          <nav class="navbar">
            <ul>
              <li><a href="#!">Trang chủ</a></li>
              <li><a href="#!">Sản phẩm</a></li>
              <li><a href="#!">Khuyến mãi</a></li>
              <li><a href="#!">Đơn hàng</a></li>
              <li><a href="#!">Khách hàng</a></li>
              <li><a href="#!">Nhân viên</a></li>
              <li><a href="#!">Thống kê</a></li>
            </ul>
          </nav>

          <!-- Action -->
          <div class="top-act">
            <button class="top-act-btn">
              <img src="./icon/header-user.svg" alt="" />
            </button>
          </div>
        </div>
      </div>
    </header>
    <!-- Page Title -->
    <section id="page-title">
      <div class="container">
        <div class="home-title">
          <img src="./icon/khuyenmai-diamond-2.svg" alt="" />
          <h1 class="title">Danh sách coupon</h1>
          <button class="add-new-button">Thêm mới</button>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section id="main-content">
      <!-- Filter -->
      <div class="filter-cp">
        <select name="filterCP" id="filterCP" class="filter">
          <option value="0">--Chọn điều kiện lọc--</option>
          <option value="1">Mã coupon</option>
          <option value="2">Giá trị giảm</option>
          <option value="2">Giá trị đơn tối thiểu</option>
        </select>
        <input type="text" id="data" class="filter-input" />
        <input type="image" src="./icon/khuyenmai-search.svg" alt="" class="filter-btn" />
      </div>
      <!-- Table -->
      <table class="coupon-list">
        <thead>
          <tr>
            <th>Mã coupon</th>
            <th>Thời gian bắt đầu</th>
            <th>Thời gian kết thúc</th>
            <th>Trạng thái</th>
            <th>Giá trị giảm</th>
            <th>Giá trị đơn tối thiểu</th>
            <th>Lượt sử dụng</th>
            <th>Tác vụ</th>
          </tr>
        </thead>
        <tbody>
          <!-- CP1 -->
          <tr>
            <td>AbcEdf1</td>
            <td>27/03/2024</td>
            <td>13/05/2024</td>
            <td>Quá hạn</td>
            <td>100.000</td>
            <td>1.000.000</td>
            <td>20</td>
            <td>
              <div class="action">
                <img src="./icon/khuyenmai-edit.svg" alt="" />
                <img src="./icon/khuyenmai-edit.svg" alt="" />
              </div>
            </td>
          </tr>
          <!-- CP2 -->
          <tr>
            <td>AbcEdf2</td>
            <td>24/04/2024</td>
            <td>14/05/2024</td>
            <td>Đang áp dụng</td>
            <td>200.000</td>
            <td>1.500.000</td>
            <td>5</td>
            <td>
              <div class="action">
                <img src="./icon/khuyenmai-edit.svg" alt="" />
                <img src="./icon/khuyenmai-delete.svg" alt="" />
              </div>
            </td>
          </tr>
          <!-- CP3 -->
          <tr>
            <td>AbcEdf3</td>
            <td>08/03/2024</td>
            <td>15/05/2024</td>
            <td>Đang áp dụng</td>
            <td>500.000</td>
            <td>2.000.000</td>
            <td>10</td>
            <td>
              <div class="action">
                <img src="./icon/khuyenmai-edit.svg" alt="" />
                <img src="./icon/khuyenmai-delete.svg" alt="" />
              </div>
            </td>
          </tr>
          <!-- CP4 -->
          <tr>
            <td>AbcEdf4</td>
            <td>10/05/2024</td>
            <td>16/05/2024</td>
            <td>Chưa áp dụng</td>
            <td>100.000</td>
            <td>1.000.000</td>
            <td>20</td>
            <td>
              <div class="action">
                <img src="./icon/khuyenmai-edit.svg" alt="" />
                <img src="./icon/khuyenmai-delete.svg" alt="" />
              </div>
            </td>
          </tr>
          <!-- CP5 -->
          <tr>
            <td>AbcEdf5</td>
            <td>15/03/2024</td>
            <td>17/05/2024</td>
            <td>Chưa áp dụng</td>
            <td>200.000</td>
            <td>1.500.000</td>
            <td>5</td>
            <td>
              <div class="action">
                <img src="./icon/khuyenmai-edit.svg" alt="" />
                <img src="./icon/khuyenmai-delete.svg" alt="" />
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- List -->
      <div class="list-number">
        <button>&lt &lt</button>
        <button>1</button>
        <button>2</button>
        <button>...</button>
        <button>&gt &gt</button>
      </div>
    </section>
  </body>
</html>