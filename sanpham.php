<!DOCTYPE html>
<html lang="vn">

<head>
  <!-- Chỉnh biểu tượng web -->
  <link href="./icon/Logo.svg" rel="shortcut icon" />
  <title>Luxe - Admin</title>
  <!-- GG Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
  <!-- Styles CSS -->
  <!-- File reset đảm bảo kích thước hiển thị website giữa các trình duyệt khác nhau -->
  <link rel="stylesheet" href="css/reset.css" />
  <!-- File định dạng các page sản phẩm -->
  <link rel="stylesheet" href="css/sanpham.css" />
</head>

<body>
  <!-- Header -->
  <?php
  // File kết nối CSDL + header
  require_once "db_module.php";
  include "header.php";
  ?>
  <?php
  $link = null;
  taoKetNoi($link);
  //Kết nối và lấy dữ liệu từ CSDL > Tiến hành phân trang
  //Số lượng SP
  $sanpham = chayTruyVanTraVeDL($link, "SELECT COUNT(*) AS so_luong_san_pham FROM tbl_sanpham");
  $so_luong_san_pham = mysqli_fetch_assoc($sanpham)["so_luong_san_pham"];
  // Tính toán số trang
  $so_trang = ceil($so_luong_san_pham / 10);
  giaiPhongBoNho($link, $so_luong_san_pham);
  ?>

  <!-- Page Title -->
  <section id="page-title">
    <div class="index_main sanpham">
      <div class="home-title">
        <img src="./icon/sanpham-diamond.svg" alt="" />
        <h1 class="title">Danh sách sản phẩm</h1>
      </div>
      <div class="edit-btn-add">
        <a href="themsanpham.php">Thêm sản phẩm</a>
      </div>
    </div>
  </section>
  <!-- Main content -->
  <section id="main-content">
    <!-- Search -->
    <form action="?opt=search_sp" method="post" class="filter-sp">
      <select name="dieukien" id="filterSP" class="filter">
        <option value="0">Mã Sản phẩm</option>
        <option value="1">Tên Sản phẩm</option>
      </select>
      <input type="text" name="giatri" id="data" class="filter-input" />
      <input type="image" src="./icon/sanpham-search.svg" class="filter-btn">
    </form>
    <!-- Table -->
    <table class="product-list">
      <thead>
        <tr>
          <th>Mã sản phẩm</th>
          <th>Tên sản phẩm</th>
          <th>Hình ảnh</th>
          <th>Trạng thái</th>
          <th>Giá gốc</th>
          <th>Giá giảm</th>
          <th>Số lượng tồn</th>
          <th>Tác vụ</th>
        </tr>
      </thead>
      <tbody>

        <?php ?>
        <?php
        //View
        function view_sp()
        {
          $link = null;
          taoKetNoi($link);
          //Xác định trang hiện tại
          $trang_hien_tai = isset($_GET["trang"]) ? $_GET["trang"] : 1;
          //Kết nối và lấy dữ liệu từ CSDL
          $sanpham_start = ($trang_hien_tai - 1) * 10;
          $result = chayTruyVanTraVeDL($link, "SELECT s.ma_san_pham, s.ten_san_pham, s.hinh_anh_1, s.gia_goc, s.gia_giam, s.trang_thai, SUM(bt.so_luong) AS tong_so_luong
            FROM tbl_sanpham AS s, tbl_bienthe AS bt
            WHERE s.ma_san_pham = bt.ma_san_pham
            GROUP BY s.ma_san_pham
            LIMIT $sanpham_start, 10");//Giới hạn mỗi trang show 10 sản phẩm
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["ma_san_pham"] . "</td>";
            echo "<td>" . $row["ten_san_pham"] . "</td>";
            //img là file chứa hình ảnh
            echo "<td><img src='./img/" . $row["hinh_anh_1"] . "'></td>";
            if ($row["trang_thai"] == 1) {
              echo "<td>Hiển thị</td>";
            } else {
              echo "<td>Không hiển thị</td>";
            }
            echo "<td>" . $row["gia_goc"] . "</td>";
            if ($row["gia_giam"] != null) {
              echo "<td>" . $row["gia_giam"] . "</td>";
            } else {
              echo "<td> - </td>";
            }
            echo "<td>" . $row["tong_so_luong"] . "</td>";
            echo "<td>";
            echo "<div class='action'>";
            echo "<a href='suasanpham.php?id=" . $row["ma_san_pham"] . "'><img src='./icon/sanpham-edit.svg' alt='Sửa' /></a>";   //Dẫn qua page thêm sửa sản phẩm với tham số mã sản phẩm trên URL 
            echo "<a href='?opt=del_sp&id=" . $row["ma_san_pham"] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xoá sản phẩm " . $row["ten_san_pham"] . "?\");'><img src='./icon/sanpham-delete.svg' alt='Xóa' /></a>";
            echo "</div>";
            echo "</td>";
            echo "</tr>";
          }
          giaiPhongBoNho($link, $result);
        }
        //Search
        function search_sp()
        {
          $link = null;
          taoKetNoi($link);
          //Kiểm tra có phương thức POST gửi lên hay không - bắt đầU khi click nút search > submit pt POST
          if (isset($_POST)) {
            $_dieukien = $_POST["dieukien"];
            $_giatri = $_POST["giatri"];
            if ($_dieukien == 0) {
              //Tạo câu lệnh SQL search mã sản phẩm
              $sql = "SELECT s.ma_san_pham, s.ten_san_pham, s.hinh_anh_1, s.gia_goc, s.gia_giam, SUM(bt.so_luong) AS tong_so_luong
                        FROM tbl_sanpham AS s, tbl_bienthe AS bt
                        WHERE s.ma_san_pham = bt.ma_san_pham
                        AND s.ma_san_pham = $_giatri";
            } else if ($_dieukien == 1) {
              //Tạo câu lệnh SQL search tên sản phẩm
              $sql = "SELECT s.ma_san_pham, s.ten_san_pham, s.hinh_anh_1, s.gia_goc, s.gia_giam, SUM(bt.so_luong) AS tong_so_luong
                        FROM tbl_sanpham AS s, tbl_bienthe AS bt
                        WHERE s.ma_san_pham = bt.ma_san_pham AND s.ten_san_pham LIKE '%" . $_giatri . "%'
                        GROUP BY s.ma_san_pham";
            }
            $rs = chayTruyVanTraVeDL($link, $sql);
            while ($row = mysqli_fetch_assoc($rs)) {
              if ($row["ma_san_pham"] == null) {
                echo "<script>alert('Sản phẩm không tồn tại!');</script>";
                echo "<script>window.location.href = 'sanpham.php?opt=view_sp';</script>";
              } else {
                echo "<tr>";
                echo "<td>" . $row["ma_san_pham"] . "</td>";
                echo "<td>" . $row["ten_san_pham"] . "</td>";
                // Assuming 'img' is the directory relative to the current file
                echo "<td><img src='./img/" . $row["hinh_anh_1"] . "'></td>";
                echo "<td>Hiển thị</td>";
                echo "<td>" . $row["gia_goc"] . "</td>";
                if ($row["gia_giam"] != null) {
                  echo "<td>" . $row["gia_giam"] . "</td>";
                } else {
                  echo "<td> - </td>";
                }
                echo "<td>" . $row["tong_so_luong"] . "</td>";
                echo "<td>
                    <div class='action'>
                      <a href='./suasanpham.php?id='><img src='./icon/edit.svg' alt='Sửa' /></a>
                      <a href='?opt=del_sp&id=" . $row["ma_san_pham"] . "'><img src='./icon/delete.svg' alt='Xóa' /></a>
                    </div>
                  </td>";
                echo "</tr>";
              }
            }
          }
          giaiPhongBoNho($link, $rs);
        }
        //Delete
        function delete_sp()
        {
          $link = null;
          taoKetNoi($link);
          if (isset($_GET["id"])) {
            $_ma_san_pham = $_GET["id"];
            // Xoá biến thể của sản phẩm trước khi xoá sản phẩm
            $sql_0 = "DELETE from tbl_bienthe where ma_san_pham=" . $_ma_san_pham;
            chayTruyVanKhongTraVeDL($link, $sql_0);
            $sql_1 = "DELETE from tbl_sanpham where ma_san_pham=" . $_ma_san_pham;
            $result = chayTruyVanKhongTraVeDL($link, $sql_1);
            if ($result) {
              echo "<script>alert('Xoá sản phẩm thành công!');</script>";
              echo "<script>window.location.href = 'sanpham.php?opt=view_sp';</script>";
            } else {
              echo "<script>alert('Xoá sản phẩm thất bại!');</script>";
              echo "<script>window.location.href = 'sanpham.php?opt=view_sp';</script>";
            }
          }
          giaiPhongBoNho($link, $result);
        }
        // Add
        function add_sp()
        {
          $link = null;
          taoKetNoi($link);
          //Kiểm tra có phương thức POST gửi lên hay không
          if (isset($_POST)) {
            $_ten_san_pham = $_POST["tensp"];
            $_ma_danh_muc = $_POST["danhmuc"];
            $_chat_lieu = $_POST["chatlieu"];
            $_trang_thai = $_POST["trangthai"];
            $_khoi_luong = $_POST["khoiluong"];
            $_gia_goc = $_POST["giagoc"];
            $_loai_da = $_POST["loaida"];
            $_gia_giam = $_POST["giagiam"];
            $_kich_thuoc_da = $_POST["kichthuocda"];
            // Xử lý file ảnh 1
            if (isset($_FILES["hinhanh1"])) {
              $file = $_FILES["hinhanh1"];
              $_hinh_anh_1 = $file["name"];
              if ($_hinh_anh_1 != null) {
                move_uploaded_file($file["tmp_name"], "./img/" . $_hinh_anh_1);
              }
            }
            // Xử lý file ảnh 2
            if (isset($_FILES["hinhanh2"])) {
              $file = $_FILES["hinhanh2"];
              $_hinh_anh_2 = $file["name"];
              if ($_hinh_anh_2 != null) {
                move_uploaded_file($file["tmp_name"], "./img/" . $_hinh_anh_2);
              }
            }
            // Xử lý file ảnh 3
            if (isset($_FILES["hinhanh3"])) {
              $file = $_FILES["hinhanh3"];
              $_hinh_anh_3 = $file["name"];
              if ($_hinh_anh_3 != null) {
                move_uploaded_file($file["tmp_name"], "./img/" . $_hinh_anh_3);
              }
            }
            //Tạo câu lệnh SQL thêm vào bảng sản phẩm
            $sql = "INSERT INTO tbl_sanpham (ten_san_pham, hinh_anh_1, hinh_anh_2, hinh_anh_3, chat_lieu, khoi_luong, loai_da, kich_thuoc_da, gia_goc, gia_giam, trang_thai, ma_danh_muc) values ('$_ten_san_pham','$_hinh_anh_1','$_hinh_anh_2', '$_hinh_anh_3','$_chat_lieu' , '$_khoi_luong', '$_loai_da', '$_kich_thuoc_da', '$_gia_goc', '$_gia_giam', '$_trang_thai', '$_ma_danh_muc')";
            //Kiểm tra biến tên có dữ liệu hay không
            if ($_ten_san_pham != "") {
              // Thêm sản phẩm thành công
              $rs = chayTruyVanKhongTraVeDL($link, $sql);
              //Tạo câu lệnh SQL thêm vào bảng biến thể
              // Lấy mã sản phẩm vừa được thêm vào
              $sql1 = "SELECT MAX(ma_san_pham) FROM tbl_sanpham";
              $rs1 = chayTruyVanKhongTraVeDL($link, $sql1);
              $row = mysqli_fetch_assoc($rs1);
              $ma_san_pham_max = $row["MAX(ma_san_pham)"];
              echo $ma_san_pham_max;
              //Xử lý biến thể
              $slbienthe = count($_POST["tenbienthe"]);
              //Getting post values
              $_ten_bien_the = $_POST["tenbienthe"];
              $_so_luong = $_POST["soluong"];
              if ($slbienthe >= 1) {
                for ($i = 0; $i < $slbienthe; $i++) {
                  if (trim($_POST["tenbienthe"][$i] != '')) {
                    $rs2 = chayTruyVanKhongTraVeDL($link, "INSERT INTO tbl_bienthe (ten_bien_the, so_luong, ma_san_pham) values ('$_ten_bien_the[$i]','$_so_luong[$i]', '$ma_san_pham_max')");
                  }
                }
              }
              //Kiểm tra insert
              if ($rs2) {
                echo "<script>alert('Thêm thành công');</script>";
                echo "<script>window.location.href = 'sanpham.php?opt=view_sp';</script>";
              } else {
                echo "<script>alert('Thêm thất bại');</script>";
                echo "<script>window.location.href = 'sanpham.php?opt=view_sp';</script>";
              }
            }
          }
          giaiPhongBoNho($link, $rs);
        }
        // Update
        function update_sp()
        {
          $link = null;
          taoKetNoi($link);
          //Kiểm tra có phương thức POST gửi lên hay không
          if (isset($_POST)) {
            $_ma_san_pham = $_POST["masp"];
            $_ten_san_pham = $_POST["tensp"];
            $_ma_danh_muc = $_POST["danhmuc"];
            $_chat_lieu = $_POST["chatlieu"];
            $_trang_thai = $_POST["trangthai"];
            $_khoi_luong = $_POST["khoiluong"];
            $_gia_goc = $_POST["giagoc"];
            $_loai_da = $_POST["loaida"];
            $_gia_giam = $_POST["giagiam"];
            $_kich_thuoc_da = $_POST["kichthuocda"];
            // Xử lý file hình ảnh 1
            if ($_FILES['hinhanh1']['name'] == '') {
              $hinhanh1 = $_POST['img_name_1'];
            } else {
              $hinhanh1 = $_FILES['hinhanh1']['name'];
              $hinhanh1_tmp = $_FILES['hinhanh1']['tmp_name'];
              move_uploaded_file($hinhanh1_tmp, './img/' . $hinhanh1);
            }
            // Xử lý file hình ảnh 2
            if ($_FILES['hinhanh2']['name'] == '') {
              $hinhanh2 = $_POST['img_name_2'];
            } else {
              $hinhanh2 = $_FILES['hinhanh2']['name'];
              $hinhanh2_tmp = $_FILES['hinhanh2']['tmp_name'];
              move_uploaded_file($hinhanh2_tmp, './img/' . $hinhanh2);
            }
            // Xử lý file hình ảnh 3
            if ($_FILES['hinhanh3']['name'] == '') {
              $hinhanh3 = $_POST['img_name_3'];
            } else {
              $hinhanh3 = $_FILES['hinhanh3']['name'];
              $hinhanh3_tmp = $_FILES['hinhanh3']['tmp_name'];
              move_uploaded_file($hinhanh3_tmp, './img/' . $hinhanh3);
            }
            // Xử lý cơ sở dữ liệu 
            //Cập nhật trước ở bảng sản phẩm
            $sql_sp = "UPDATE tbl_sanpham SET ten_san_pham='$_ten_san_pham', hinh_anh_1='$hinhanh1', hinh_anh_2='$hinhanh2', hinh_anh_3='$hinhanh3', chat_lieu='$_chat_lieu', khoi_luong='$_khoi_luong', loai_da='$_loai_da', kich_thuoc_da='$_kich_thuoc_da', gia_goc='$_gia_goc', gia_giam='$_gia_giam', trang_thai='$_trang_thai', ma_danh_muc='$_ma_danh_muc' where ma_san_pham='$_ma_san_pham'";
            $rs = chayTruyVanKhongTraVeDL($link, $sql_sp);
            //Xử lý biến thể
            $slbienthe = count($_POST["mabienthe"]);
            //Getting post values
            $_ma_bien_the = $_POST["mabienthe"];
            $_ten_bien_the = $_POST["tenbienthe"];
            $_so_luong = $_POST["soluong"];
            if ($slbienthe >= 1) {
              for ($i = 0; $i < $slbienthe; $i++) {
                //Cập nhật ở bảng biến thể
                $rs2 = chayTruyVanKhongTraVeDL($link, "UPDATE tbl_bienthe SET ten_bien_the='$_ten_bien_the[$i]', so_luong=$_so_luong[$i], ma_san_pham='$_ma_san_pham' WHERE ma_bien_the='$_ma_bien_the[$i])'");
              }
            }
            //Kiểm tra update
            if ($rs2) {
              echo "<script>alert('Cập nhật thành công');</script>";
              echo "<script>window.location.href = 'sanpham.php?opt=view_sp';</script>";
            } else {
              echo "<script>alert('Cập nhật thất bại');</script>";
              echo "<script>window.location.href = 'sanpham.php?opt=view_sp';</script>";
            }
          }
          giaiPhongBoNho($link, $rs);
        }

        //Xử lý các option
        if (isset($_GET["opt"])) {
          $_opt = $_GET["opt"];
          switch ($_opt) {
            case "search_sp":
              search_sp();
              break;
            case "add_sp":
              add_sp();
              break;
            case "update_sp":
              update_sp();
              break;
            case "del_sp":
              delete_sp();
              break;
            default:
              view_sp();
          }
        } else {
          $_opt = view_sp();
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
        <?php echo "<a href='./sanpham.php?trang=" . $trang_truoc . "'>&lt &lt</a>" ?>
      </button>
      <?php
      for ($i = 1; $i <= $so_trang; $i = $i + 1) {
        echo "<button><a href='./sanpham.php?trang=" . $i . "'>$i</a></button>";
      }
      ?>
      <button>
        <?php echo "<a href='./sanpham.php?trang=" . $trang_sau . "'>&gt &gt</a>" ?>
      </button>
    </div>
  </section>
</body>

</html>