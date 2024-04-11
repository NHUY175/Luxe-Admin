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
    <!-- File reset đảm bảo kích thước hiển thị website giữa các trình duyệt khác nhau -->
  <link rel="stylesheet" href="css/reset.css" />
  <!-- File định dạng các page sản phẩm -->
  <link rel="stylesheet" href="css/nhanvien.css" />
  <link rel="stylesheet" href="css/header.css" />
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
  //Số lượng NV
  $nhanvien = chayTruyVanTraVeDL($link, "SELECT COUNT(*) AS so_luong_nhan_vien FROM tbl_nhanvien");
  $so_luong_nhan_vien = mysqli_fetch_assoc($nhanvien)["so_luong_nhan_vien"];
  // Tính toán số trang
  $so_trang = ceil($so_luong_nhan_vien / 10);
  giaiPhongBoNho($link, $so_luong_nhan_vien);
  ?>
    <!-- Page Title -->
    <section id="page-title">
      <div class="container">
        <div class="home-title">
          <img src="./icon/nhanvien-diamond-2.svg" alt="" />
          <h1 class="title">Danh sách nhân viên</h1>
          <div class="add-new-button2" onclick="window.location.href = 'themnhanvien.php?opt=add_nv'" >Thêm mới</button>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section id="main-content">
      <!-- Search -->
    <form action="?opt=search_nv" method="post" class="filter-nv">
      <select name="filterNV" id="filterNV" class="filter">
        <option value="0">--Chọn điều kiện lọc--</option>
        <option value="1">Mã Sản phẩm</option>
        <option value="2">Tên Sản phẩm</option>
      </select>
      <input type="text" id="giatri" class="filter-input" />
      <input type="image" src="./icon/nhanvien-search.svg" alt="" class="filter-btn">
    </form>
      
      <!-- Table -->
      <table class="nhanvien-list">
        <thead>
          <tr>
            <th>Mã NV</th>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Trạng thái</th>
            <th>SĐT</th>
            <th>Địa chỉ cư trú</th>
            <th>Ngày tham gia</th>
            <th>Tác vụ</th>
          </tr>
        </thead>
        <tbody>
        <?php
        //View
        function view_nv()
        {
          $link = null;
          taoKetNoi($link);
          //Xác định trang hiện tại
          $trang_hien_tai = isset($_GET["trang"]) ? $_GET["trang"] : 1;
          //Kết nối và lấy dữ liệu từ CSDL
          $nhanvien_start = ($trang_hien_tai - 1) * 10;
          $result = chayTruyVanTraVeDL($link, "SELECT ma_nhan_vien, ho_ten, gioi_tinh, email, so_dien_thoai, dia_chi_cu_tru, ngay_tham_gia FROM tbl_nhanvien LIMIT $nhanvien_start, 10");
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
              echo "<td>" . $row["ma_nhan_vien"] . "</td>";
              echo "<td>" . $row["ho_ten"] . "</td>";
              echo "<td>" . $row["gioi_tinh"] . "</td>";
              echo "<td>" . $row["email"] . "</td>";
              echo "<td>" . $row["so_dien_thoai"] . "</td>";
              echo "<td>" . $row["dia_chi_cu_tru"] . "</td>";
              echo "<td>" . $row["ngay_tham_gia"] . "</td>";
              echo "<td>";
              echo "<div class='action'>";
              echo "<a href='suanhanvien.php?id=".$row["ma_nhan_vien"]."'><img src='./icon/nhanvien-edit.svg' alt='Sửa' /></a>";   
              echo "<a href='?opt=del_nv&id=".$row["ma_nhan_vien"]."' onclick='return confirm(\"Bạn có chắc chắn muốn xoá nhân viên ".$row["ho_ten"]."?\");'><img src='./icon/nhanvien-delete.svg' alt='Xóa' /></a>";  
              echo "</div>";
              echo "</td>";
              echo "</tr>";
              }
          giaiPhongBoNho($link, $result);
        }
          //Search
          function search_nv()
          {
            $link = null;
            taoKetNoi($link);
            //Kiểm tra có phương thức POST gửi lên hay không - bắt đầu khi click nút search > submit pt POST
            if (isset($_POST["filterNV"]) && isset($_POST["giatri"])) {
              $_filterNV = $_POST["filterNV"];
              $_giatri = $_POST["giatri"];
              if ($_filterNV == 0) {
                //Tạo câu lệnh SQL search mã nhân viên
                $sql = "SELECT ma_nhan_vien, ho_ten, gioi_tinh, email, so_dien_thoai, dia_chi_cu_tru, ngay_tham_gia FROM tbl_nhanvien WHERE ma_nhan_vien = $_giatri";
              } else if ($_filterNV == 1) {
                //Tạo câu lệnh SQL search tên nhân viên
                $sql = "SELECT ma_nhan_vien, ho_ten, gioi_tinh, email, so_dien_thoai, dia_chi_cu_tru, ngay_tham_gia FROM tbl_nhanvien WHERE ho_ten LIKE '%" . $_giatri . "%'";
              }
              $rs = chayTruyVanTraVeDL($link, $sql);
              while ($row = mysqli_fetch_assoc($rs)) {
                if ($row["ma_nhan_vien"] == null) {
                  echo "<script>alert('Nhân viên không tồn tại!');</script>";
                  echo "<script>window.location.href = 'nhanvien.php?opt=view_nv';</script>";
                } else {
                  echo "<tr>";
                  echo "<td>" . $row["ma_nhan_vien"] . "</td>";
                  echo "<td>" . $row["ho_ten"] . "</td>";
                  echo "<td>" . $row["gioi_tinh"] . "</td>";
                  echo "<td>" . $row["email"] . "</td>";
                  echo "<td>" . $row["so_dien_thoai"] . "</td>";
                  echo "<td>" . $row["dia_chi_cu_tru"] . "</td>";
                  echo "<td>" . $row["ngay_tham_gia"] . "</td>";
                  echo "<td>
                      <div class='action'>
                        <a href='./suanhanvien.php?id='><img src='./icon/nhanvien-edit.svg' alt='Sửa' /></a>
                        <a href='?opt=del_nv&id=" . $row["ma_nhan_vien"] . "'><img src='./icon/nhanvien-delete.svg' alt='Xóa' /></a>
                      </div>
                    </td>";
                  echo "</tr>";
                }
              }
            }
              giaiPhongBoNho($link, $rs);
          }
      
        //Delete
        function delete_nv()
          {
            $link = null;
            taoKetNoi($link);
            if (isset($_GET["id"])) {
              $_ma_nhan_vien = $_GET["id"];
              // Xoá nhân viên từ bảng tbl_nhanvien
              $sql = "DELETE FROM tbl_nhanvien WHERE ma_nhan_vien=" . $_ma_nhan_vien;
              $result = chayTruyVanKhongTraVeDL($link, $sql);
              if ($result) {
                echo "<script>alert('Xoá nhân viên thành công!');</script>";
                echo "<script>window.location.href = 'nhanvien.php?opt=view_nv';</script>";
              } else {
                echo "<script>alert('Xoá nhân viên thất bại!');</script>";
                echo "<script>window.location.href = 'nhanvien.php?opt=view_nv';</script>";
              }
            }
            giaiPhongBoNho($link, $result);
          }
        // Add
        function add_nv()
          {
            $link = null;
            taoKetNoi($link);
            //Kiểm tra có phương thức POST gửi lên hay không
            if (isset($_POST["hotennv"]) && isset($_POST["gioitinhnv"]) && isset($_POST["emailnv"]) && isset($_POST["sodienthoainv"]) && isset($_POST["diachicutru"]) && isset($_POST["ngaythamgia"])) {
              $_ho_ten = $_POST["hotennv"];
              $_gioi_tinh = $_POST["gioitinhnv"];
              $_email = $_POST["emailnv"];
              $_so_dien_thoai = $_POST["sodienthoainv"];
              $_dia_chi_cu_tru = $_POST["diachicutru"];
              $_ngay_tham_gia = $_POST["ngaythamgia"];

              //Tạo câu lệnh SQL thêm vào bảng nhân viên
              $sql = "INSERT INTO tbl_nhanvien (ho_ten, gioi_tinh, email, so_dien_thoai, dia_chi_cu_tru, ngay_tham_gia) values ('$_ho_ten','$_gioi_tinh','$_email', '$_so_dien_thoai','$_dia_chi_cu_tru' , '$_ngay_tham_gia')";
              //Kiểm tra biến tên có dữ liệu hay không
              if ($_ho_ten != "") {
                // Thêm nhân viên thành công
                $rs = chayTruyVanKhongTraVeDL($link, $sql);
                echo "<script>alert('Thêm nhân viên thành công!');</script>";
                echo "<script>window.location.href = 'nhanvien.php?opt=view_nv';</script>";
              }
            } else {
              // Xử lý khi không nhận được đủ dữ liệu từ biểu mẫu
              echo "<script>alert('Dữ liệu nhập không hợp lệ!');</script>";
              echo "<script>window.location.href = 'nhanvien.php?opt=view_nv';</script>";
            }
            giaiPhongBoNho($link, $rs);
          }
        // Update
        function update_nv()
        {
          $link = null;
          taoKetNoi($link);
          //Kiểm tra có phương thức POST gửi lên hay không
          if (isset($_POST)) {
            $_ma_nhan_vien = $_POST["manv"];
            $_ho_ten = $_POST["hotennv"];
            $_gioi_tinh = $_POST["gioitinhnv"];
            $_email = $_POST["emailnv"];
            $_so_dien_thoai = $_POST["sodienthoainv"];
            $_dia_chi_cu_tru = $_POST["diachicutru"];
            $_ngay_tham_gia = $_POST["NgayTG"];
       
            }
            
            // Xử lý cơ sở dữ liệu 
            //Cập nhật trước ở bảng nhân viên
            $sql_nv = "UPDATE tbl_nhanvien SET ho_ten='$_ho_ten', gioi_tinh='$_gioi_tinh', email='$_email', so_dien_thoai='$_so_dien_thoai', dia_chi_cu_tru='$_dia_chi_cu_tru', ngay_tham_gia='$_ngay_tham_gia' where ma_nhan_vien='$_ma_nhan_vien'";
            // Thực thi truy vấn và gán kết quả cho biến $rs
            $rs = chayTruyVanKhongTraVeDL($link, $sql_nv);
            //Kiểm tra update
            if($rs){
              echo "<script>alert('Cập nhật thành công');</script>";
              echo "<script>window.location.href = 'nhanvien.php?opt=view_nv';</script>";
              }else{
              echo "<script>alert('Cập nhật thất bại');</script>";
              echo "<script>window.location.href = 'nhanvien.php?opt=view_nv';</script>";
              }
            
          giaiPhongBoNho($link, $rs);
        }

        //Xử lý các option
        if (isset($_GET["opt"])) {
          $_opt = $_GET["opt"];
          switch ($_opt) {
            case "search_nv":
              search_nv();
              break;
            case "add_nv":
              add_nv();
              break;
            case "update_nv":
              update_nv();
              break;
            case "del_nv":
              delete_nv();
              break;
            default:
              view_nv();
          }
        } else {
          $_opt = view_nv();
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
        <?php echo "<a href='./nhanvien.php?trang=" . $trang_truoc . "'>&lt &lt</a>" ?>
      </button>
      <?php
      for ($i = 1; $i <= $so_trang; $i = $i + 1) {
        echo "<button><a href='./nhanvien.php?trang=" . $i . "'>$i</a></button>";
      }
      ?>
      <button>
        <?php echo "<a href='./nhanvien.php?trang=" . $trang_sau . "'>&gt &gt</a>" ?>
      </button>
    </div>
  </section>
</body>
</html>