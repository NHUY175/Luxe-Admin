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
      $khuyenmai = chayTruyVanTraVeDL($link,"SELECT COUNT(*) AS so_luong_ma_coupon FROM tbl_khuyenmai");
      $so_luong_ma_coupon = mysqli_fetch_assoc($khuyenmai)["so_luong_ma_coupon"];
      // Tính toán số trang
      $so_trang = ceil($so_luong_ma_coupon / 5);
      giaiPhongBoNho($link,$so_luong_ma_coupon);
    ?>
    <!-- Page Title -->
    <section id="page-title">
      <div class="container">
        <div class="home-title">
          <img src="./icon/khuyenmai-diamond-2.svg" alt="" />
          <h1 class="title">Danh sách coupon</h1>
          <button class="add-new-button" onclick="window.location.href = 'them-khuyenmai.php?opt=add_cp'" >Thêm mới</button>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section id="main-content">
      <!-- Search -->
      <form action="?opt=search_cp" method="post" class="filter-cp">
        <select name="dieukien" id="filterCP" class="filter">
        <option value="0">--Chọn điều kiện lọc--</option>
          <option value="1">Mã coupon</option>
          <option value="2">Giá trị giảm</option>
          <option value="3">Trạng thái</option>
        </select>
        <input type="text" name="giatri" id="data" class="filter-input" />
        <input type="image" src="./icon/khuyenmai-search.svg" class="filter-btn">
      </form>
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
        <?php
          //View
          function view_cp() {
            $link = null;
            taoKetNoi($link);  
            //Xác định trang hiện tại
            $trang_hien_tai = isset($_GET["trang"]) ? $_GET["trang"] : 1;
            //Kết nối và lấy dữ liệu từ CSDL
            $khuyenmai_start = ($trang_hien_tai - 1)* 5;     
            $result = chayTruyVanTraVeDL($link,"SELECT ma_coupon, thoi_gian_bat_dau, thoi_gian_ket_thuc, trang_thai, gia_tri_giam, gia_tri_don_toi_thieu, luot_su_dung
            FROM tbl_khuyenmai 
            LIMIT $khuyenmai_start, 5");//Giới hạn mỗi trang show 5 sản phẩm
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . $row["ma_coupon"] . "</td>";
              echo "<td>" . $row["thoi_gian_bat_dau"] . "</td>";
              echo "<td>" . $row["thoi_gian_ket_thuc"] . "</td>";
              echo "<td>" . $row["trang_thai"] . "</td>";
              echo "<td>" . $row["gia_tri_giam"] . "</td>";
              echo "<td>" . $row["gia_tri_don_toi_thieu"] . "</td>";
              echo "<td>" . $row["luot_su_dung"] . "</td>";
              echo "<td>";
              echo "<div class='action'>";
              echo "<a href='sua-khuyenmai.php?id=".$row["ma_coupon"]."'><img src='./icon/khuyenmai-edit.svg' alt='Sửa' /></a>";   //Dẫn qua page sửa coupon với tham số mã coupon trên URL 
              echo "<a href='?opt=del_cp&id=".$row["ma_coupon"]."' onclick='return confirm(\"Bạn có chắc chắn muốn xoá coupon này ".$row["ma_coupon"]."?\");'><img src='./icon/khuyenmai-delete.svg' alt='Xóa' /></a>";  
              echo "</div>";
              echo "</td>";
              echo "</tr>";
              }
              giaiPhongBoNho($link,$result);
          }          
          //Search
          function search_cp() {
            $link = null;
            taoKetNoi($link);
            
            // Kiểm tra có phương thức POST gửi lên hay không
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $_dieukien = $_POST["dieukien"];
                $_giatri = $_POST["giatri"];
        
                if ($_dieukien == 1) {
                    //Tạo câu lệnh SQL search mã coupon
                    $sql = "SELECT ma_coupon, thoi_gian_bat_dau, thoi_gian_ket_thuc, trang_thai, gia_tri_giam, gia_tri_don_toi_thieu, luot_su_dung
                            FROM tbl_khuyenmai
                            WHERE ma_coupon = '$_giatri'";
                } else if ($_dieukien == 2) {
                    //Tạo câu lệnh SQL search giá trị giảm
                    $sql = "SELECT ma_coupon, thoi_gian_bat_dau, thoi_gian_ket_thuc, trang_thai, gia_tri_giam, gia_tri_don_toi_thieu, luot_su_dung
                            FROM tbl_khuyenmai
                            WHERE gia_tri_giam = '$_giatri'";
                } else if ($_dieukien == 3) {
                    //Tạo câu lệnh SQL search trạng thái
                    $sql = "SELECT ma_coupon, thoi_gian_bat_dau, thoi_gian_ket_thuc, trang_thai, gia_tri_giam, gia_tri_don_toi_thieu, luot_su_dung
                           FROM tbl_khuyenmai
                           WHERE trang_thai = '$_giatri'";
                }
        
                $rs = chayTruyVanTraVeDL($link, $sql);
        
                // Kiểm tra số lượng dòng trả về
                if(mysqli_num_rows($rs) > 0) {
                    while ($row = mysqli_fetch_assoc($rs)) {
                        echo "<tr>";
                        echo "<td>" . $row["ma_coupon"] . "</td>";
                        echo "<td>" . $row["thoi_gian_bat_dau"] . "</td>";
                        echo "<td>" . $row["thoi_gian_ket_thuc"] . "</td>";
                        echo "<td>" . $row["trang_thai"] . "</td>";
                        echo "<td>" . $row["gia_tri_giam"] . "</td>";
                        echo "<td>" . $row["gia_tri_don_toi_thieu"] . "</td>";
                        echo "<td>" . $row["luot_su_dung"] . "</td>";
                        echo "<td>";
                        echo "<div class='action'>";
                        echo "<a href='sua-khuyenmai.php?id=".$row["ma_coupon"]."'><img src='./icon/khuyenmai-edit.svg' alt='Sửa' /></a>";
                        echo "<a href='?opt=del_cp&id=".$row["ma_coupon"]."' onclick='return confirm(\"Bạn có chắc chắn muốn xoá coupon này ".$row["ma_coupon"]."?\");'><img src='./icon/khuyenmai-delete.svg' alt='Xóa' /></a>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Không tìm thấy coupon</td></tr>";
                }
        
                giaiPhongBoNho($link,$rs);
            }
        }
        
          //Delete
          function delete_cp() {
            $link = null;
            taoKetNoi($link);
            
            if(isset($_GET["id"])) {
                $_ma_coupon = $_GET["id"];
        
                // Sử dụng prepared statement để tránh lỗ hổng SQL Injection
                $sql = "DELETE FROM tbl_khuyenmai WHERE ma_coupon=?";
                $stmt = mysqli_prepare($link, $sql);
                
                // Kiểm tra xem prepared statement có được chuẩn bị thành công hay không
                if ($stmt) {
                    // Gán giá trị cho tham số và thực thi câu lệnh
                    mysqli_stmt_bind_param($stmt, "s", $_ma_coupon);
                    $result = mysqli_stmt_execute($stmt);
                    
                    // Kiểm tra kết quả và thông báo tương ứng
                    if ($result) {
                        echo "<script>alert('Xoá sản phẩm thành công!');</script>";
                    } else {
                        echo "<script>alert('Xoá sản phẩm thất bại!');</script>";
                    }
                    
                    // Giải phóng prepared statement
                    mysqli_stmt_close($stmt);
                } else {
                    // Nếu không thể chuẩn bị prepared statement, thông báo lỗi
                    echo "<script>alert('Xoá sản phẩm thất bại do lỗi truy vấn!');</script>";
                }
        
                // Chuyển hướng sau khi xử lý xong
                echo "<script>window.location.href = 'ds-khuyenmai.php?opt=view_cp';</script>";
            }
            
            giaiPhongBoNho($link);
        }        
          // Add
          function add_cp() {
            $link = null;
            taoKetNoi($link);
            
            // Kiểm tra có phương thức POST gửi lên hay không
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $_ma_coupon = $_POST["macoupon"];
                $_thoi_gian_bat_dau = $_POST["thoigianbatdau"];
                $_thoi_gian_ket_thuc = $_POST["thoigianketthuc"];
                $_trang_thai = $_POST["trangthai"];
                $_gia_tri_giam = $_POST["giatrigiam"];
                $_gia_tri_don_toi_thieu = $_POST["giatridontoithieu"];
                $_luot_su_dung = $_POST["luotsudung"];
                
                // Sử dụng prepared statement để tránh SQL Injection
                $sql = "INSERT INTO tbl_khuyenmai (ma_coupon, thoi_gian_bat_dau, thoi_gian_ket_thuc, trang_thai, gia_tri_giam, gia_tri_don_toi_thieu, luot_su_dung) VALUES ('$_ma_coupon', '$_thoi_gian_bat_dau', '$_thoi_gian_ket_thuc', '$_trang_thai', '$_gia_tri_giam', '$_gia_tri_don_toi_thieu', '$_luot_su_dung')";
                //Kiểm tra biến tên có dữ liệu hay không
                if ($_ma_coupon != "") {
                  // Thêm sản phẩm thành công
                  $rs = chayTruyVanKhongTraVeDL($link, $sql);
                }
                //Kiểm tra insert
                if ($rs) {
                echo "<script>alert('Thêm thành công');</script>";
                echo "<script>window.location.href = 'ds-khuyenmai.php?opt=view_cp';</script>";
                } else {
                echo "<script>alert('Thêm thất bại');</script>";
                echo "<script>window.location.href = 'ds-khuyenmai.php?opt=view_cp';</script>";
                }
              }
              giaiPhongBoNho($link);
          }        
          // Update
          function update_cp() {
            $link = null;
            taoKetNoi($link);
            //Kiểm tra có phương thức POST gửi lên hay không
            if(isset($_POST)){
              $_ma_coupon = $_POST["macoupon"];
              $_thoi_gian_bat_dau = $_POST["thoigianbatdau"];
              $_thoi_gian_ket_thuc = $_POST["thoigianketthuc"];
              $_trang_thai = $_POST["trangthai"];
              $_gia_tri_giam = $_POST["giatrigiam"];
              $_gia_tri_don_toi_thieu = $_POST["giatridontoithieu"];
              $_luot_su_dung = $_POST["luotsudung"];
              // Xử lý cơ sở dữ liệu 
              //Cập nhật ở bảng khuyến mãi
              $sql_cp = "UPDATE tbl_khuyenmai SET ma_coupon='$_ma_coupon', thoi_gian_bat_dau='$_thoi_gian_bat_dau', thoi_gian_ket_thuc='$_thoi_gian_ket_thuc, trang_thai='$_trang_thai', gia_tri_giam='$_gia_tri_giam', gia_tri_don_toi_thieu='$_gia_tri_don_toi_thieu', luot_su_dung='$_luot_su_dung'";
              $rs = chayTruyVanKhongTraVeDL($link, $sql_cp);
              
              //Kiểm tra update
              if($rs){
                echo "<script>alert('Cập nhật thành công');</script>";
                echo "<script>window.location.href = 'ds-khuyenmai.php?opt=view_cp';</script>";
              }else{
                echo "<script>alert('Cập nhật thất bại');</script>";
                echo "<script>window.location.href = 'ds-khuyenmai.php?opt=view_cp';</script>";
              }
            }
            giaiPhongBoNho($link,$rs);
          }

          //Xử lý các option
          if (isset($_GET["opt"])) { 
            $_opt = $_GET["opt"];
            switch ($_opt) {
                case "search_cp": search_cp();
                  break;
                case "add_cp": add_cp();
                  break;
                case "update_cp": update_cp();
                  break;
                case "del_cp": delete_cp();
                  break;
                default: view_cp();
                }
            } else {
                $_opt = view_cp();
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
        <button><?php echo "<a href='./ds-khuyenmai.php?trang=".$trang_truoc."'>&lt &lt</a>"?></button>
        <?php
          for ($i=1; $i <= $so_trang; $i = $i + 1) {
            echo "<button><a href='./ds-khuyenmai.php?trang=".$i."'>$i</a></button>";
          }
        ?>
        <button><?php echo "<a href='./ds-khuyenmai.php?trang=".$trang_sau."'>&gt &gt</a>"?></button>
      </div>
    </section>
  </body>
</html>