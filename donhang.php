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
      $donhang = chayTruyVanTraVeDL($link,"SELECT COUNT(*) AS so_luong_don_hang FROM tbl_donhang");
      $so_luong_don_hang = mysqli_fetch_assoc($donhang)["so_luong_don_hang"];
      // Tính toán số trang
      $so_trang = ceil($so_luong_don_hang / 5);
      giaiPhongBoNho($link,$so_luong_don_hang);
    ?>
    <!-- Page Title -->
    <section id="page-title">
      <div class="container">
        <div class="home-title">
          <h1 class="title">Quản lý đơn hàng</h1>
          
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section id="main-content">
      <!-- Search -->
      <form action="?opt=search_dh" method="post" class="filter-cp">
        <select name="dieukien" id="filterCP" class="filter">
        <option value="0">--Chọn điều kiện lọc--</option>
          <option value="1">Mã đơn hàng</option>
          <option value="2">Tình trạng</option>
        </select>
        <input type="text" name="giatri" id="data" class="filter-input" />
        <input type="image" src="./icon/khuyenmai-search.svg" class="filter-btn">
      </form>
        <!-- Table -->
        <table class="DH-list">
        <thead>
          <tr>
                <th>Mã đơn</th>
                <th>Ngày tạo</th>
                <th>Địa chỉ giao</th>
                <th>Tổng tiền</th>
                <th>Giảm giá</th>
                <th>Tổng thanh toán</th>
                <th>Phương thức thanh toán</th>
                <th>Tình trạng</th>
                <th>Ghi chú</th>
                <th>Mã khách hàng</th>
                <th>Mã Coupon</th>
                <th>Tác vụ</th>
          </tr>
        </thead>
        <tbody>
        <?php
          //View
          function view_dh() {
            $link = null;
            taoKetNoi($link);  
            //Xác định trang hiện tại
            $trang_hien_tai = isset($_GET["trang"]) ? $_GET["trang"] : 1;
            //Kết nối và lấy dữ liệu từ CSDL
            $donhang_start = ($trang_hien_tai - 1)* 5;     
            $result = chayTruyVanTraVeDL($link,"SELECT *
            FROM tbl_donhang 
            LIMIT  $donhang_start, 5");//Giới hạn mỗi trang show 5 đơn hàng
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . $row["ma_don_hang"] . "</td>";
              echo "<td>" . $row["ngay_tao"] . "</td>";
              echo "<td>" . $row["dia_chi_giao_hang"] . "</td>";
              echo "<td>" . $row["tong_tien"] . "</td>";
              echo "<td>" . $row["giam_gia"] . "</td>";
              echo "<td>" . $row["tong_thanh_toan"] . "</td>";
              echo "<td>" . $row["phuong_thuc_thanh_toan"] . "</td>";
              echo "<td>" . $row["tinh_trang"] . "</td>";
              echo "<td>" . $row["ghi_chu"] . "</td>";
              echo "<td>" . $row["ma_khach_hang"] . "</td>";
              echo "<td>" . $row["ma_coupon"] . "</td>";
              echo "<td>";
              echo "<div class='action'>";
              echo "<a href='suadonhang.php?id=".$row["ma_don_hang"]."'><img src='./icon/khuyenmai-edit.svg' alt='Sửa' /></a>";   //Dẫn qua page sửa hoadon với tham số mã hoadon trên URL 
              echo "<a href='?opt=del_hd&id=".$row["ma_don_hang"]."' onclick='return confirm(\"Bạn có chắc chắn muốn xoá đơn hàng ".$row["ma_don_hang"]."?\");'><img src='./icon/khuyenmai-delete.svg' alt='Xóa' /></a>";  
              echo "</div>";
              echo "</td>";
              echo "</tr>";
              }
              giaiPhongBoNho($link,$result);
          }   
        //Search
        function search_dh() {
            $link = null;
            taoKetNoi($link);
            
            // Kiểm tra có phương thức POST gửi lên hay không
            if (isset($_POST)) {
                $_dieukien = $_POST["dieukien"];
                $_giatri = $_POST["giatri"];
        
                if ($_dieukien == 1) {
                    //Tạo câu lệnh SQL search mã đơn hàng
                    $sql = "SELECT *
                            FROM tbl_donhang
                            WHERE ma_don_hang = '$_giatri'";
                } else if ($_dieukien == 2) {
                    //Tạo câu lệnh SQL search tình trạng đơn hàng
                    $sql = "SELECT *
                            FROM tbl_donhang
                            WHERE tinh_trang = '$_giatri'";
                } 
                $rs = chayTruyVanTraVeDL($link, $sql); 
                 // Kiểm tra số lượng dòng trả về
                 if(mysqli_num_rows($rs) > 0) {
                    while ($row = mysqli_fetch_assoc($rs)) {
                        echo "<tr>";
                        echo "<td>" . $row["ma_don_hang"] . "</td>";
                        echo "<td>" . $row["ngay_tao"] . "</td>";
                        echo "<td>" . $row["dia_chi_giao_hang"] . "</td>";
                        echo "<td>" . $row["tong_tien"] . "</td>";
                        echo "<td>" . $row["giam_gia"] . "</td>";
                        echo "<td>" . $row["tong_thanh_toan"] . "</td>";
                        echo "<td>" . $row["phuong_thuc_thanh_toan"] . "</td>";
                        echo "<td>" . $row["tinh_trang"] . "</td>";
                        echo "<td>" . $row["ghi_chu"] . "</td>";
                        echo "<td>" . $row["ma_khach_hang"] . "</td>";
                        echo "<td>" . $row["ma_coupon"] . "</td>";
                        echo "<td>";
                        echo "<div class='action'>";
                        echo "<a href='suadonhang.php?id=".$row["ma_don_hang"]."'><img src='./icon/khuyenmai-edit.svg' alt='Sửa' /></a>";   //Dẫn qua page sửa hoadon với tham số mã hoadon trên URL 
                        echo "<a href='?opt=del_hd&id=".$row["ma_don_hang"]."' onclick='return confirm(\"Bạn có chắc chắn muốn xoá đơn hàng ".$row["ma_don_hang"]."?\");'><img src='./icon/khuyenmai-delete.svg' alt='Xóa' /></a>";  
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Không tìm thấy đơn hàng</td></tr>";
                }
        
                giaiPhongBoNho($link,$rs);
            }
        }
           // Add
        function add_dh()
        {
          $link = null;
          taoKetNoi($link);
          //Kiểm tra có phương thức POST gửi lên hay không
          if (isset($_POST)) {
            $_ten_dh = $_POST["tendh"];
            $_ngay_tao = $_POST["ngaytao"];
            $_dia_chi_giao = $_POST["diachigiao"];
            $_tong_tien = $_POST["tongtien"];
            $_ma_coupon= $_POST["macoupon"];
            $_ma_khach_hang = $_POST["makhachhang"];
            $_giam_gia = $_POST["giamgia"];
            $_tong_thanh_toan = $_POST["tongthanhtoan"];
            $_phuong_thuc_thanh_toan = $_POST["phuongthucthanhtoan"];
            $_tinh_trang = $_POST["tinhtrang"];
            $_ghi_chu = $_POST["ghichu"];
           
          }
            //Tạo câu lệnh SQL thêm vào bảng donhang
            $sql = "INSERT INTO tbl_donhang ( ngay_tao, dia_chi_giao_hang, tong_tien,giam_gia, tong_thanh_toan, phuong_thuc_thanh_toan, tinh_trang,ghi_chu, ma_khach_hang, ma_coupon) values (' $_ngay_tao',' $_dia_chi_giao', $_tong_tien, $_giam_gia , $_tong_thanh_toan, '$_phuong_thuc_thanh_toan', '$_tinh_trang', '$_ghi_chu', $_ma_khach_hang, '$_ma_coupon')";
            //Kiểm tra biến tên có dữ liệu hay không
            if ($_ten_dh != "") {
              // Thêm donhang thành công
              $rs = chayTruyVanKhongTraVeDL($link, $sql);
            }
              //Kiểm tra insert
              if ($rs) {
                echo "<script>alert('Thêm thành công');</script>";
                echo "<script>window.location.href = 'donhang.php?opt=view_sp';</script>";
              } else {
                echo "<script>alert('Thêm thất bại');</script>";
                echo "<script>window.location.href = 'donhang.php?opt=view_sp';</script>";
              }        
              giaiPhongBoNho($link, $rs);
        }

         //Delete
         function delete_dh() {
            $link = null;
            taoKetNoi($link);
            if (isset($_GET["id"])) {
              $_ma_don_hang = $_GET["id"];
              // Xoá hóa đơn từ bảng tbl_donhang
              $sql = "DELETE FROM tbl_donhang WHERE ma_don_hang=".$_ma_don_hang;
              $result = chayTruyVanKhongTraVeDL($link, $sql);
              if ($result) {
                echo "<script>alert('Xoá đơn hàng thành công!');</script>";
                echo "<script>window.location.href = 'donghang.php?opt=view_dh';</script>";
              } else {
                echo "<script>alert('Xoá đơn hàng thất bại!');</script>";
                echo "<script>window.location.href = 'donhang.php?opt=view_dh';</script>";
              }
            }
            giaiPhongBoNho($link, $result);
         }
         // Update
         function update_dh() {
            $link = null;
            taoKetNoi($link);
            // Kiểm tra có phương thức POST gửi lên hay không
            if(isset($_POST["submit_btn"])) { // Sửa để kiểm tra nút submit đã được nhấn
                $_ten_dh = $_POST["tendh"];
                $_ngay_tao = $_POST["ngaytao"];
                $_dia_chi_giao = $_POST["diachigiao"];
                $_tong_tien = $_POST["tongtien"];
                $_ma_coupon= $_POST["macoupon"];
                $_ma_khach_hang = $_POST["makhachhang"];
                $_giam_gia = $_POST["giamgia"];
                $_tong_thanh_toan = $_POST["tongthanhtoan"];
                $_phuong_thuc_thanh_toan = $_POST["phuongthucthanhtoan"];
                $_tinh_trang = $_POST["tinhtrang"];
                $_ghi_chu = $_POST["ghichu"];
                // Xử lý cơ sở dữ liệu 
                // Cập nhật ở bảng khuyến mãi
                $sql_cp = "UPDATE tbl_donhang SET ngay_tao='$_ngay_tao', dia_chi_giao_hang=' $_dia_chi_giao', tong_tien=$_tong_tien,giam_gia=$_giam_gia, tong_thanh_toan= $_tong_thanh_toan, phuong_thuc_thanh_toan='$_phuong_thuc_thanh_toan', tinh_trang='$_tinh_trang',ghi_chu='$_ghi_chu', ma_khach_hang=$_ma_khach_hang, ma_coupon='$_ma_coupon' WHERE ma_don_hang=$_ten_dh"; // Thêm điều kiện WHERE để chỉ cập nhật hàng cụ thể
                echo ($sql_cp);
                $result = chayTruyVanKhongTraVeDL($link, $sql_cp);
                
                // Kiểm tra update
                if($result){
                    echo "<script>alert('Cập nhật thành công');</script>";
                    echo "<script>window.location.href = 'donghang.php?opt=view_cp';</script>";
                } else {
                    echo "<script>alert('Cập nhật thất bại');</script>";
                    echo "<script>window.location.href = 'donhang.php?opt=view_cp';</script>";
                }
            }
            giaiPhongBoNho($link,$result);
        }        

        //Xử lý các option
        if (isset($_GET["opt"])) { 
            $_opt = $_GET["opt"];
            switch ($_opt) {
                case "search_dh": search_dh();
                break;
                case "add_dh": add_dh();
                break;
                case "del_dh":delete_dh();
                break;
                case "upd_dh":update_dh();
                break;
                default: view_dh();
                }
            } else {
                $_opt = view_dh();
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
          }
          else ($trang_truoc = $trang_hien_tai - 1 );         
          if ($trang_hien_tai == $so_trang) {
            $trang_sau = $so_trang;
          }
          else ($trang_sau = $trang_hien_tai + 1 );
        ?>
        <button><?php echo "<a href='./donhang.php?trang=".$trang_truoc."'>&lt &lt</a>"?></button>
        <?php
          for ($i=1; $i <= $so_trang; $i++) {
            echo "<button><a href='./donhang.php?trang=".$i."'>$i</a></button>";
          }
        ?>
        <button><?php echo "<a href='./donhang.php?trang=".$trang_sau."'>&gt &gt</a>"?></button>
      </div>
    </section>
  </body>
</html>