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
    <link rel="stylesheet" href="css/khachhang.css" />
    <link rel="stylesheet" href="css/header.css" />
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
      //Số lượng khách hàng
      $khachhang = chayTruyVanTraVeDL($link,"SELECT COUNT(*) AS so_luong_khach_hang FROM tbl_khachhang");
      $so_luong_khach_hang = mysqli_fetch_assoc($khachhang)["so_luong_khach_hang"];
      // Tính toán số trang
      $so_trang = ceil($so_luong_khach_hang / 7);
      giaiPhongBoNho($link,$so_luong_khach_hang);
    ?>
    <!-- Page Title -->
    <section id="page-title">
      <div class="container">
        <div class="home-title">
          <div class="home-title">
            <img src="./icon/khachhang-diamond-2.svg" alt="" />
            <h1 class="title" style="white-space: nowrap;">Danh sách khách hàng</h1>
          </div>
          <div class="home-title">
            <button class="page-btn" onclick="window.location.href = 'themkhachhang.php?opt=add_kh'">Thêm mới</button>
          </div>
      </div>
    </section>
    <!-- Main content -->
    <section id="main-content">
      <!-- Filter -->
      <form action="?opt=search_kh" method="post" class="filter-kh">
        <select name="dieukien" id="filterKH" class="filter">
          <option value="0">--Chọn điều kiện lọc--</option>
          <option value="1">Mã KH</option>
          <option value="2">Tên</option>
          <option value="3">Số điện thoại</option>
        </select>
        <input type="text" name="giatri" id="data" class="filter-input" />
        <input type="image" src="./icon/khachhang-search.svg" alt="" class="filter-btn" />
      </form>
      <!-- Table -->
      <table class="customer-list">
        <thead>
          <tr>
            <th>Mã KH</th>
            <th>Tên</th>
            <th>Giới tính</th>
            <th>Ngày sinh</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Tác vụ</th>
          </tr>
        </thead>
        <tbody>
        <?php
          //View
          function view_kh() {
            $link = null;
            taoKetNoi($link);  
            //Xác định trang hiện tại
            $trang_hien_tai = isset($_GET["trang"]) ? $_GET["trang"] : 1;
            //Kết nối và lấy dữ liệu từ CSDL
            $khachhang_start = ($trang_hien_tai - 1)* 7;     
            $result = chayTruyVanTraVeDL($link,"SELECT ma_khach_hang, ho_ten, gioi_tinh, ngay_sinh, email, so_dien_thoai, dia_chi
            FROM tbl_khachhang
            LIMIT $khachhang_start, 7");//Giới hạn mỗi trang show 7 khách hàng
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . $row["ma_khach_hang"] . "</td>";
              echo "<td>" . $row["ho_ten"] . "</td>";
              echo "<td>" . $row["gioi_tinh"] . "</td>";
              echo "<td>" . $row["ngay_sinh"] . "</td>";
              echo "<td>" . $row["email"] . "</td>";
              echo "<td>" . $row["so_dien_thoai"] . "</td>";
              echo "<td>" . $row["dia_chi"] . "</td>";
              echo "<td>";
              echo "<div class='action'>";
              echo "<a href='suakhachhang.php?id=".$row["ma_khach_hang"]."'><img src='./icon/khachhang-edit.svg' alt='Sửa' /></a>";   //Dẫn qua page sửa khách hàng với tham số mã khách hàng trên URL 
              echo "<a href='?opt=del_kh&id=".$row["ma_khach_hang"]."' onclick='return confirm(\"Bạn có chắc chắn muốn xoá khách hàng ".$row["ho_ten"]."?\");'><img src='./icon/khachhang-delete.svg' alt='Xóa' /></a>";  
              echo "</div>";
              echo "</td>";
              echo "</tr>";
              }
              giaiPhongBoNho($link,$result);
          }
          //Search
          function search_kh() {
            $link = null;
            taoKetNoi($link);
            
            // Kiểm tra có phương thức POST gửi lên hay không
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $_dieukien = $_POST["dieukien"];
                $_giatri = $_POST["giatri"];
        
                if ($_dieukien == 1) {
                    //Tạo câu lệnh SQL search mã coupon
                    $sql = "SELECT ma_khach_hang, ho_ten, gioi_tinh, ngay_sinh, email, so_dien_thoai, dia_chi
                            FROM tbl_khachhang
                            WHERE ma_khach_hang = '$_giatri'";
                } else if ($_dieukien == 2) {
                    //Tạo câu lệnh SQL search giá trị giảm
                    $sql = "SELECT ma_khach_hang, ho_ten, gioi_tinh, ngay_sinh, email, so_dien_thoai, dia_chi
                            FROM tbl_khachhang
                            WHERE ho_ten LIKE '%$_giatri%'";
                } else if ($_dieukien == 3) {
                    //Tạo câu lệnh SQL search trạng thái
                    $sql = "SELECT ma_khach_hang, ho_ten, gioi_tinh, ngay_sinh, email, so_dien_thoai, dia_chi
                           FROM tbl_khachhang
                           WHERE so_dien_thoai = '$_giatri'";
                } else {
                  echo "<script>alert('Vui lòng chọn điều kiện lọc!');</script>";
                  echo "<script>window.location.href = 'khachhang.php?opt=view_kh';</script>";
                }
                $rs = chayTruyVanTraVeDL($link, $sql);
                while ($row = mysqli_fetch_assoc($rs)) {
                    if ($row["ma_khach_hang"] == null) {
                      echo "<script>alert('Khách hàng không tồn tại!');</script>";
                      echo "<script>window.location.href = 'khachhang.php?opt=view_kh';</script>";
                    } else {
                      echo "<tr>";
                      echo "<td>" . $row["ma_khach_hang"] . "</td>";
                      echo "<td>" . $row["ho_ten"] . "</td>";
                      echo "<td>" . $row["gioi_tinh"] . "</td>";
                      echo "<td>" . $row["ngay_sinh"] . "</td>";
                      echo "<td>" . $row["email"] . "</td>";
                      echo "<td>" . $row["so_dien_thoai"] . "</td>";
                      echo "<td>" . $row["dia_chi"] . "</td>";
                      echo "<td>";
                      echo "<div class='action'>";
                      echo "<a href='suakhachhang.php?id=".$row["ma_khach_hang"]."'><img src='./icon/khachhang-edit.svg' alt='Sửa' /></a>";   //Dẫn qua page sửa khách hàng với tham số mã khách hàng trên URL 
                      echo "<a href='?opt=del_kh&id=".$row["ma_khach_hang"]."' onclick='return confirm(\"Bạn có chắc chắn muốn xoá khách hàng này ".$row["ma_khach_hang"]."?\");'><img src='./icon/khachhang-delete.svg' alt='Xóa' /></a>";  
                      echo "</div>";
                      echo "</td>";
                      echo "</tr>";
                    }
                  }
                }
                giaiPhongBoNho($link, $rs);
              }
            //Delete
            function delete_kh() {
            $link = null;
            taoKetNoi($link);
            
            if(isset($_GET["id"])) {
                $_ma_khach_hang = $_GET["id"];
        
                // Sử dụng prepared statement để tránh lỗ hổng SQL Injection
                $sql = "DELETE FROM tbl_khachhang WHERE ma_khach_hang=?";
                $stmt = mysqli_prepare($link, $sql);
                
                // Kiểm tra xem prepared statement có được chuẩn bị thành công hay không
                if ($stmt) {
                    // Gán giá trị cho tham số và thực thi câu lệnh
                    mysqli_stmt_bind_param($stmt, "s", $_ma_khach_hang);
                    $result = mysqli_stmt_execute($stmt);
                    
                    // Kiểm tra kết quả và thông báo tương ứng
                    if ($result) {
                        echo "<script>alert('Xoá khách hàng thành công!');</script>";
                    } else {
                        echo "<script>alert('Xoá khách hàng thất bại!');</script>";
                    }
                    
                    // Giải phóng prepared statement
                    mysqli_stmt_close($stmt);
                } else {
                    // Nếu không thể chuẩn bị prepared statement, thông báo lỗi
                    echo "<script>alert('Xoá khách hàng thất bại do lỗi truy vấn!');</script>";
                }
        
                // Chuyển hướng sau khi xử lý xong
                echo "<script>window.location.href = 'khachhang.php?opt=view_kh';</script>";
            }
            
            giaiPhongBoNho($link, $result);
            }
            // Add
            function add_kh() {
            $link = null;
            taoKetNoi($link);
            
            // Kiểm tra có phương thức POST gửi lên hay không
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $_ho_ten = $_POST["hoten"];
                $_gioi_tinh = $_POST["gioitinh"];
                $_ngay_sinh = $_POST["ngaysinh"];
                $_email = $_POST["email"];
                $_so_dien_thoai = $_POST["sodienthoai"];
                $_dia_chi = $_POST["diachi"];
                
                // Sử dụng prepared statement để tránh SQL Injection
                $sql = "INSERT INTO tbl_khachhang (ho_ten, gioi_tinh, ngay_sinh, email, so_dien_thoai, dia_chi) VALUES ('$_ho_ten', '$_gioi_tinh', '$_ngay_sinh', '$_email', '$_so_dien_thoai', '$_dia_chi')";
                //Kiểm tra biến tên có dữ liệu hay không
                if ($_ho_ten != "") {
                    //Thêm khách hàng thành công
                    $rs = chayTruyVanKhongTraVeDL($link, $sql);
                }
                //Kiểm tra insert
                if ($rs) {
                echo "<script>alert('Thêm thành công');</script>";
                echo "<script>window.location.href = 'khachhang.php?opt=view_kh';</script>";
                } else {
                echo "<script>alert('Thêm thất bại');</script>";
                echo "<script>window.location.href = 'khachhang.php?opt=view_kh';</script>";
                }
              }
              giaiPhongBoNho($link,$rs);
            }
            // Update
            function update_kh()
            {
            $link = null;
            taoKetNoi($link);
            // Kiểm tra có phương thức POST gửi lên hay không
            if(isset($_POST)) {
                $_ma_khach_hang = $_POST["makhachhang"];
                $_ho_ten = $_POST["hoten"];
                $_gioi_tinh = $_POST["gioitinh"];
                $_ngay_sinh = $_POST["ngaysinh"];
                $_email = $_POST["email"];
                $_so_dien_thoai = $_POST["sodienthoai"];
                $_dia_chi = $_POST["diachi"];
                // Xử lý cơ sở dữ liệu 
                //Cập nhật trước ở bảng khách hàng
                $sql_kh = "UPDATE tbl_khachhang SET ho_ten = '$_ho_ten', gioi_tinh = '$_gioi_tinh', ngay_sinh = '$_ngay_sinh', email = '$_email', so_dien_thoai = '$_so_dien_thoai', dia_chi = '$_dia_chi' where ma_khach_hang = $_ma_khach_hang"; 
                $rs = chayTruyVanTraVeDL($link, $sql_kh);
                
                //Kiểm tra update
                if($rs){
                echo "<script>alert('Cập nhật thành công');</script>";
                echo "<script>window.location.href = 'khachhang.php?opt=view_kh';</script>";
                }else{
                echo "<script>alert('Cập nhật thất bại');</script>";
                echo "<script>window.location.href = 'khachhang.php?opt=view_kh';</script>";
                }
            }
            giaiPhongBoNho($link,$rs);
            }
            //Xử lý các option
            if (isset($_GET["opt"])) { 
                $_opt = $_GET["opt"];
                switch ($_opt) {
                    case "search_kh": search_kh();
                    break;
                    case "add_kh": add_kh();
                    break;
                    case "update_kh": update_kh();
                    break;
                    case "del_kh": delete_kh();
                    break;
                    default: view_kh();
                    }
                } else {
                    $_opt = view_kh();
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
        <?php echo "<a href='./khachhang.php?trang=" . $trang_truoc . "'>&lt &lt</a>" ?>
      </button>
      <?php
      for ($i = 1; $i <= $so_trang; $i = $i + 1) {
        echo "<button><a href='./khachhang.php?trang=" . $i . "'>$i</a></button>";
      }
      ?>
      <button>
        <?php echo "<a href='./khachhang.php?trang=" . $trang_sau . "'>&gt &gt</a>" ?>
      </button>
    </div>
  </section>
</body>
</html>
