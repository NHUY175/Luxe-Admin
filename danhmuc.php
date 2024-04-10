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
  <link rel="stylesheet" href="css/responsinve.css" />

  <!-- Scripts -->
  <script src="./js/scripts.js"></script>
  <!-- FONT AWESOME - THƯ VIỆN ICON -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
  <script>
    //Reload trnag hiện tại
    function ReloadPage() {
      // Đặt lại giá trị của trường input "data"
      document.getElementById("ten_danhmuc").value = '';
      document.getElementById("HinhAnhDMSP").value = '';
      document.getElementById("filterDMSP").value = '-1'; // Reset lại giá trị của select box
      document.getElementById("data").value = '';
      document.querySelector('.filter').submit(); // Gửi yêu cầu tìm kiếm với giá trị rỗng
    }
    //history: quay trở lại trang trước đó
    function GoBack() {
      window.history.go(-1);
    }
  </script>
</head>

<body>
  <!-- Header -->
  <?php
  require_once "db_module.php";
  include "header.php";
  ?>
  <?php
  // Kết nối đến cơ sở dữ liệu
  $link = null;
  taoKetNoi($link);
  // Lấy số lượng danh mục sản phẩm
  $sql_count_dmsp = "SELECT COUNT(*) AS so_luong_danh_muc FROM tbl_danhmuc";
  $result_count_dmsp = chayTruyVanTraVeDL($link, $sql_count_dmsp);
  $so_luong_danh_muc = mysqli_fetch_assoc($result_count_dmsp)["so_luong_danh_muc"];

  // Tính số trang
  $so_danh_muc_moi_trang = 10; // Số lượng danh mục hiển thị trên mỗi trang
  $so_trang = ceil($so_luong_danh_muc / $so_danh_muc_moi_trang);

  // Giải phóng bộ nhớ
  giaiPhongBoNho($link, $result_count_dmsp);
  ?>
  <!-- Page Title -->
  <div class="container-title-danhmuc">
    <div class="home-title-DMSP">
      <div style="display: flex; align-items: center;">
        <div class="home-title-danhmuc-group">
          <img src="./icon/sanpham-diamond.svg" alt="" width="37px" />
          <h1 class="title">QUẢN LÝ DANH MỤC SẢN PHẨM</h1>
        </div>
      </div>
      <input type="reset" value="Làm mới" class="button-reset" title="Làm mới" onclick="ReloadPage()" ;>

    </div>
  </div>
  <!-- Main content -->
  <section id="main-cate-content">
    <div class="main-cate-content--wrapper">
      <!----------- Thêm danh mục ---------------->
      <div class="info-cate">
        <div class="info-cate-name">Thông tin sản phẩm</div>
        <div class="info-cate-add">
          <form action="?opt=add_dmsp" method="post" enctype="multipart/form-data">
            <div class="info-cate-add__inner">
              <div class="info-cate-add__inner--ten-input">
                <label for="ten_danhmuc" class="form-DMSP-label">Tên danh mục <span style="color:red">*</span></label>
                <input type="text" id="ten_danhmuc" name="ten_danhmuc" placeholder="Điền tên danh mục"
                  class="form-DMSP-input" required />
              </div>
              <div class="info-cate-add__inner--iamge">
                <label for="HinhAnhDMSP" class="form-DMSP-label">Hình ảnh <span style="color:red">*</span></label>
                <input type="file" id="HinhAnhDMSP" name="hinhanh" class="file-procat" required>
              </div>
              <input type="submit" value="+" class="button-them-moi" title="Thêm sản phẩm" ;>
            </div>
          </form>
        </div>
      </div>
      <!----------- Search ---------------->
      <form action=" ?opt=search_dmsp" method="POST" class="filter">
        <select name="dieukien" id="filterDMSP" class="filter-DMSP">
          <option value="-1">-- Tìm kiếm --</option>
          <option value="0" <?php if (isset($_POST["dieukien"]) && $_POST["dieukien"] == 0)
            echo 'selected'; ?>>Mã
            danh
            mục</option>
          <option value="1" <?php if (isset($_POST["dieukien"]) && $_POST["dieukien"] == 1)
            echo 'selected'; ?>>Tên
            danh
            mục</option>
        </select>
        <input type="text" name="giatri" id="data" class="filter-input"
          placeholder='Tìm kiếm theo mã hoặc tên danh mục. VD: 1,2,..Nhẫn, Vòng tay,...'
          value="<?php echo isset($_POST["giatri"]) ? $_POST["giatri"] : ''; ?>" ; />
        <button type="submit" class="search-DMSP-btn">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </form>

      <table class="product-list">
        <thead>
          <tr>
            <th onclick='delete_san_pham("abc")'>Mã danh mục</th>
            <th>Tên danh mục</th>
            <th>Hình ảnh</th>
            <th>Tác vụ</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //View
          function view_dmsp()
          {
            $link = null;
            taoKetNoi($link);
            //Xác định trang hiện tại
            $trang_hien_tai = isset($_GET["trang"]) ? $_GET["trang"] : 1;

            // Tính vị trí bắt đầu của dữ liệu trên trang hiện tại
            $danhmuc_start = ($trang_hien_tai - 1) * 10;

            // Lấy dữ liệu từ CSDL
            $query = "SELECT * FROM tbl_danhmuc LIMIT $danhmuc_start, 10";//Giới hạn mỗi trang show 10 danh mục
            $result = chayTruyVanTraVeDL($link, $query);

            // Lấy dữ liệu từ CSDL
            $query = "SELECT * FROM tbl_danhmuc LIMIT $danhmuc_start, 10";
            $result = chayTruyVanTraVeDL($link, $query);

            // Hiển thị dữ liệu
            // lấy từ dòng kết quả đưa vào biến row
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . $row["ma_danh_muc"] . "</td>";
              echo "<td>" . $row["ten_danh_muc"] . "</td>";
              echo "<td><img src='./img/" . $row["hinh_anh_danh_muc"] . "'></td>";
              echo "<td>";
              echo "<div class='action'>";
              echo "<a href='suadanhmuc.php?id=" . $row["ma_danh_muc"] . "'><img src='./icon/sanpham-edit.svg' alt='Sửa' /></a>";
              echo "<a href='?opt=del_dmsp&id=" . $row["ma_danh_muc"] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xoá danh mục sản phẩm?  " . $row["ten_danh_muc"] . "?\");'>
              <img src='./icon/sanpham-delete.svg' alt='Xóa' /></a>";
              echo "</div>";
              echo "</td>";
              echo "</tr>";
            }
            giaiPhongBoNho($link, $result);
          }
          //search
          function search_dmsp()
          {
            $link = null;
            taoKetNoi($link);

            if (isset($_POST["dieukien"]) && isset($_POST["giatri"])) { // Kiểm tra xem có dữ liệu POST được gửi lên không
              $_dieukien = $_POST["dieukien"];
              $_giatri = $_POST["giatri"];

              // Xây dựng câu truy vấn SQL dựa trên có chọn điều kiện lọc và giá trị tìm kiếm hay không
              if ($_giatri !== null && $_giatri !== '') {
                if ($_dieukien == -1) {
                  $sql = "SELECT * FROM tbl_danhmuc WHERE ma_danh_muc = '$_giatri' OR ten_danh_muc LIKE '%" . $_giatri . "%'";
                } else if ($_dieukien == 0) {
                  if (is_numeric($_giatri)) {
                    $sql = "SELECT * FROM tbl_danhmuc WHERE ma_danh_muc = '$_giatri'";
                  } else {
                    // Nếu giá trị không phải là số, hiển thị thông báo lỗi
                    echo "<p class='error-message'>Mã danh mục phải là một số. Vui lòng nhập lại.</p>";
                    return; // Kết thúc hàm để ngăn việc thực thi truy vấn SQL
                  }
                } else if ($_dieukien == 1) {
                  if (is_numeric($_giatri)) {
                    // Nếu giá trị không phải là số, hiển thị thông báo lỗi
                    echo "<p class='error-message'>Tên danh mục không được chứa số. Vui lòng nhập lại.</p>";
                    return; // Kết thúc hàm để ngăn việc thực thi truy vấn SQL
                  } else {
                    // Nếu giá trị là số, tiếp tục tạo câu truy vấn
                    $sql = "SELECT * FROM tbl_danhmuc WHERE ten_danh_muc LIKE '%" . $_giatri . "%'";
                  }
                }
              } else {
                // Nếu không có giá trị tìm kiếm, hiển thị tất cả kết quả
                $sql = "SELECT * FROM tbl_danhmuc";
              }

              $rs = chayTruyVanTraVeDL($link, $sql);
              if (mysqli_num_rows($rs) > 0) {
                // Hiển thị kết quả tìm kiếm
                while ($row = mysqli_fetch_assoc($rs)) {
                  echo "<tr>";
                  echo "<td>" . $row["ma_danh_muc"] . "</td>";
                  echo "<td>" . $row["ten_danh_muc"] . "</td>";
                  echo "<td><img src='./img/" . $row["hinh_anh_danh_muc"] . "'></td>";
                  echo "<td>
                    <div class='action'>
                        <a href='./suadanhmuc.php?id='><img src='./icon/sanpham-edit.svg' alt='Sửa' /></a>
                        <a href='?opt=del_dmsp&id=" . $row["ma_danh_muc"] . "'><img src='./icon/sanpham-delete.svg' alt='Xóa' /></a>
                    </div>
                </td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='4'>Không tìm thấy danh mục nào.</td></tr>";
              }
              giaiPhongBoNho($link, $rs);
            }
          }

          function update_dmsp()
          {
            $link = null;
            taoKetNoi($link);
            // Kiểm tra có phương thức POST gửi lên hay không
            if (isset($_POST)) {
              $_ma_danh_muc = $_POST["ma_danhmuc"];
              $_ten_danh_muc = $_POST["ten_danhmuc"];
            }
            // Xử lý file hình ảnh
            if ($_FILES['hinhanh']['name'] == '') {
              $hinhanh = $_POST['img_name'];
            } else {
              $hinhanh = $_FILES['hinhanh']['name'];
              $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];

              // Kiểm tra loại file hình ảnh
              $imageFileType = strtolower(pathinfo($hinhanh, PATHINFO_EXTENSION));
              $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
              if (!in_array($imageFileType, $allowed_types)) {
                echo "<script>alert('Chỉ chấp nhận các loại file JPG, JPEG, PNG và GIF.');</script>";
                echo "<script>window.location.href = 'danhmuc.php?opt=view_dmsp';</script>";
                return;
              }

              // Kiểm tra kích thước file hình ảnh
              if ($_FILES["hinhanh"]["size"] > 500000) {
                echo "<script>alert('Kích thước file quá lớn.');</script>";
                echo "<script>window.location.href = 'danhmuc.php?opt=view_dmsp';</script>";
                return;
              }

              // Di chuyển tệp tải lên vào thư mục đích
              if (!move_uploaded_file($hinhanh_tmp, './img/' . $hinhanh)) {
                echo "<script>alert('Đã xảy ra lỗi khi tải lên tệp.');</script>";
                echo "<script>window.location.href = 'danhmuc.php?opt=view_dmsp';</script>";
                return;
              }
            }
            // Xử lý cơ sở dữ liệu
            // Cập nhật ở bảng danh mục
            $sql = "UPDATE tbl_danhmuc SET ten_danh_muc='$_ten_danh_muc', hinh_anh_danh_muc='$hinhanh' where ma_danh_muc='$_ma_danh_muc'";
            $result = chayTruyVanKhongTraVeDL($link, $sql);
            if ($result) {
              echo "<script>alert('Cập nhật danh mục sản phẩm thành công!');</script>";
              echo "<script>window.location.href = 'danhmuc.php?opt=view_dmsp';</script>";
            } else {
              echo "<script>alert('Cập nhật danh mục sản phẩm thất bại!');</script>";
              echo "<script>window.location.href = 'danhmuc.php?opt=view_dmsp';</script>";
            }
            giaiPhongBoNho($link, $result);
          }

          //Delete
          function delete_dmsp()
          {
            $link = null;
            taoKetNoi($link);
            if (isset($_GET["id"])) {
              $_ma_danh_muc = $_GET["id"];
              $sql = "DELETE from tbl_danhmuc where ma_danh_muc =" . $_ma_danh_muc;
              $result = chayTruyVanKhongTraVeDL($link, $sql);
              if ($result) {
                echo "<script>alert('Xoá danh mục sản phẩm thành công!');</script>";
                echo "<script>window.location.href = 'danhmuc.php?opt=view_dmsp';</script>";
              } else {
                echo "<script>alert('Xoá danh mục sản phẩm thất bại!');</script>";
                echo "<script>window.location.href = 'danhmuc.php?opt=view_dmsp';</script>";
              }
            }
            giaiPhongBoNho($link, $result);
          }

          // Add
          function add_dmsp()
          {
            $link = null;
            taoKetNoi($link);

            // Xử lý form
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              // Lấy dữ liệu từ form
          
              // Lấy dữ liệu từ form hoặc từ dữ liệu cũ nếu form không được gửi đi
              $ten_danh_muc = isset($_POST["ten_danhmuc"]) ? $_POST["ten_danhmuc"] : ["ten_danh_muc"];
              $hinh_anh_danh_muc = ''; // Khởi tạo biến hình ảnh
              // Kiểm tra xem $ten_danh_muc có phải là số hay không
              if (is_numeric($ten_danh_muc)) {
                echo "<script>alert('Tên danh mục không được là số.');</script>";
                echo "<script>window.location.href = 'danhmuc.php?opt=view_dmsp';</script>";
                exit();
              }
              // Xử lý hình ảnh
              if (isset($_FILES["hinhanh"]) && $_FILES["hinhanh"]["error"] == 0) {
                // Lưu trữ hình ảnh
                $tmp_hinh_anh_danh_muc = $_FILES["hinhanh"]["tmp_name"];
                $target_file = "./img/" . basename($_FILES["hinhanh"]["name"]);

                // Kiểm tra loại file
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
                if (!in_array($imageFileType, $allowed_types)) {
                  echo "<script>alert('Chỉ chấp nhận các loại file JPG, JPEG, PNG và GIF.');</script>";
                  echo "<script>window.location.href = 'danhmuc.php?opt=view_dmsp';</script>";
                  exit();
                }

                // Kiểm tra kích thước file
                if ($_FILES["hinhanh"]["size"] > 500000) {
                  echo "<script>alert('Kích thước file quá lớn.');</script>";
                  echo "<script>window.location.href = 'danhmuc.php?opt=view_dmsp';</script>";
                  exit();
                }

                // Di chuyển file
                if (!move_uploaded_file($tmp_hinh_anh_danh_muc, $target_file)) {
                  echo "<script>alert('Đã xảy ra lỗi khi tải lên hình ảnh.');</script>";
                  echo "<script>window.location.href = 'danhmuc.php?opt=view_dmsp';</script>";
                  exit();
                }

                $hinh_anh_danh_muc = basename($_FILES["hinhanh"]["name"]);
              }

              // Tạo câu lệnh SQL thêm vào bảng sản phẩm
              $sql = "INSERT INTO tbl_danhmuc (ten_danh_muc, hinh_anh_danh_muc) VALUES ('$ten_danh_muc', '$hinh_anh_danh_muc')";

              // Kiểm tra biến tên có dữ liệu hay không
              if ($ten_danh_muc != "") {
                // Thực hiện truy vấn thêm sản phẩm
                $result = chayTruyVanKhongTraVeDL($link, $sql);

                // Kiểm tra insert
                if ($result) {
                  // Lấy mã danh mục sản phẩm vừa được thêm vào
                  $ma_danh_muc = mysqli_insert_id($link);

                  echo "<script>alert('Thêm danh mục sản phẩm $ten_danh_muc thành công');</script>";
                  echo "<script>window.location.href = 'danhmuc.php?opt=view_dmsp';</script>";
                  exit();
                } else {
                  // Thêm thất bại
                  echo "<script>alert('Thêm danh mục sản phẩm thất bại');</script>";
                  echo "<script>window.location.href = 'danhmuc.php?opt=view_dmsp';</script>";
                  exit();
                }
              }
            } else {
              // Hiển thị form
              // Lấy thông tin danh mục
              $ma_danh_muc = $_GET["id"];
              $sql = "SELECT * FROM tbl_danhmuc WHERE ma_danh_muc = $ma_danh_muc";
              $result = chayTruyVanTraVeDL($link, $sql);
              $row = mysqli_fetch_assoc($result);
            }

            // Giải phóng bộ nhớ
            giaiPhongBoNho($link, $result);
          }
          //tùy chọn
          if (isset($_GET["opt"])) {
            $_opt = $_GET["opt"];
            switch ($_opt) {
              case "search_dmsp":
                search_dmsp();
                break;
              case "add_dmsp":
                add_dmsp();
                break;
              case "update_dmsp":
                update_dmsp();
                break;
              case "del_dmsp":
                delete_dmsp();
                break;
              default:
                view_dmsp();
            }
          } else {
            $_opt = view_dmsp();
          }
          ?>
        </tbody>
      </table>
      <!-- Phân trang -->
      <div class="list-number">
        <?php
        $trang_truoc = 0;
        $trang_sau = 0;
        $trang_hien_tai = isset($_GET["trang"]) ? $_GET["trang"] : 1;
        if ($trang_hien_tai == 1) {
          $trang_truoc = 1;
        } else
          ($trang_truoc = $trang_hien_tai - 1);
        if ($trang_hien_tai == $so_trang) {
          $trang_sau = $so_trang;
        } else
          ($trang_sau = $trang_hien_tai + 1);
        ?>
        <button>
          <?php echo "<a href='./danhmuc.php?trang=" . $trang_truoc . "'>&lt &lt</a>" ?>
        </button>
        <?php
        for ($i = 1; $i <= $so_trang; $i = $i + 1) {
          echo "<button><a href='./danhmuc.php?trang=" . $i . "'>$i</a></button>";
        }
        ?>
        <button>
          <?php echo "<a href='./danhmuc.php?trang=" . $trang_sau . "'>&gt &gt</a>" ?>
        </button>
      </div>
  </section>
</body>

</html>