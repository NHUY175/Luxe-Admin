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
          <button class="add-new-button" href="them-khuyenmai.php" >Thêm mới</button>
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
          <option value="2">Trạng thái</option>
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
            $khuyenmai_start = ($trang_hien_tai - 1)* 10;     
            $result = chayTruyVanTraVeDL($link,"SELECT ma_coupon, thoi_gian_bat_dau, thoi_gian_ket_thuc, trang_thai, gia_tri_giam, gia_tri_don_toi_thieu, luot_su_dung
            FROM tbl_khuyenmai 
            GROUP BY ma_coupon
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
              echo "<a href='ql-khuyenmai.php?id=".$row["ma_coupon"]."'><img src='./icon/khuyenmai-edit.svg' alt='Sửa' /></a>";   //Dẫn qua page sửa coupon với tham số mã coupon trên URL 
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
            //Kiểm tra có phương thức POST gửi lên hay không - bắt đầU khi click nút search > submit pt POST
            if(isset($_POST)){
              $_dieukien = $_POST["dieukien"];
              $_giatri = $_POST["giatri"];
              if ($_dieukien == 0) {
                //Tạo câu lệnh SQL search mã coupon
                $sql = "SELECT ma_coupon, thoi_gian_bat_dau, thoi_gian_ket_thuc, trang_thai, gia_tri_giam, gia_tri_don_toi_thieu, luot_su_dung
                        FROM tbl_khuyenmai
                        WHERE ma_coupon = $_giatri";                                             
              }
              else if ($_dieukien == 1) {
                //Tạo câu lệnh SQL search giá trị giảm
                $sql = "SELECT ma_coupon, thoi_gian_bat_dau, thoi_gian_ket_thuc, trang_thai, gia_tri_giam, gia_tri_don_toi_thieu, luot_su_dung
                        FROM tbl_khuyenmai
                        WHERE gia_tri_giam <= $_giatri";
                //Tạo câu lệnh SQL search trạng thái
                $sql = "SELECT ma_coupon, thoi_gian_bat_dau, thoi_gian_ket_thuc, trang_thai, gia_tri_giam, gia_tri_don_toi_thieu, luot_su_dung
                       FROM tbl_khuyenmai
                       WHERE trang_thai = $_giatri";            
              }
              $rs = chayTruyVanTraVeDL($link, $sql);
              while ($row = mysqli_fetch_assoc($rs)) {
                if ($row["ma_coupon"] == null) {
                  echo "<script>alert('Coupon không tồn tại!');</script>";
                  echo "<script>window.location.href = 'ds-khuyenmai.php?opt=view_cp';</script>";
                }
                else {
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
                  echo "<a href='ql-khuyenmai.php?id=".$row["ma_coupon"]."'><img src='./icon/khuyenmai-edit.svg' alt='Sửa' /></a>";   //Dẫn qua page sửa coupon với tham số mã coupon trên URL 
                  echo "<a href='?opt=del_cp&id=".$row["ma_coupon"]."' onclick='return confirm(\"Bạn có chắc chắn muốn xoá coupon này ".$row["ma_coupon"]."?\");'><img src='./icon/khuyenmai-delete.svg' alt='Xóa' /></a>";  
                  echo "</div>";
                  echo "</td>";
                  echo "</tr>";
                }              
              }
            }         
            giaiPhongBoNho($link,$rs);
          }
          //Delete
          function delete_cp() {
            $link = null;
            taoKetNoi($link);
            if(isset($_GET["id"])){
                $_ma_coupon = $_GET["id"];
                $sql = "DELETE from tbl_khuyenmai where ma_coupon=".$_ma_coupon;
                $result = chayTruyVanKhongTraVeDL($link,$sql);
                if ($result) {
                  echo "<script>alert('Xoá sản phẩm thành công!');</script>";
                  echo "<script>window.location.href = 'ds-khuyenmai.php?opt=view_cp';</script>";
                } else {
                  echo "<script>alert('Xoá sản phẩm thất bại!');</script>";
                  echo "<script>window.location.href = 'ds-khuyenmai.php?opt=view_cp';</script>";
                }
            }
            giaiPhongBoNho($link,$result);
          }
          // Add
          function add_sp() {
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
              //Tạo câu lệnh SQL thêm vào bảng khuyến mãi
              $sql = "INSERT INTO tbl_khuyenmai (ma_coupon, thoi_gian_bat_dau, thoi_gian_ket_thuc, trang_thai, gia_tri_giam, gia_tri_don_toi_thieu, luot_su_dung) values ('$_ma_coupon','$_thoi_gian_bat_dau','$_thoi_gian_ket_thuc', '$_trang_thai','$_gia_tri_giam' , '$_gia_tri_don_toi_thieu', '$_luot_su_dung')";
              //Kiểm tra biến tên có dữ liệu hay không
              if($_ten_san_pham != ""){
                  // Thêm sản phẩm thành công
                  $rs = chayTruyVanKhongTraVeDL($link, $sql);
                  //Kiểm tra insert
                  if($rs2){
                    echo "<script>alert('Thêm thành công');</script>";
                    echo "<script>window.location.href = 'ds-khuyenmai.php?opt=view_cp';</script>";
                  }else{
                    echo "<script>alert('Thêm thất bại');</script>";
                    echo "<script>window.location.href = 'ds-khuyenmai.php?opt=view_cp';</script>";
                  }
                }
              }
            giaiPhongBoNho($link,$rs);
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
                case "search_sp": search_cp();
                  break;
                case "add_sp": add_cp();
                  break;
                case "update_sp": update_cp();
                  break;
                case "del_sp": delete_cp();
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