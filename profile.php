<?php
session_start();
include("connectdb.php");
if (!isset($_SESSION['u_id'])) { header("location: index.php"); exit(); }

$u_id = $_SESSION['u_id'];
$message = "";

// ดึงข้อมูลผู้ใช้ปัจจุบันมาแสดงผล
$query = mysqli_query($conn, "SELECT * FROM user WHERE u_id = '$u_id'");
$user = mysqli_fetch_assoc($query);

if (isset($_POST['update_profile'])) {
    $u_title = mysqli_real_escape_string($conn, $_POST['u_title']);
    $u_name = mysqli_real_escape_string($conn, $_POST['u_name']);
    $u_email = mysqli_real_escape_string($conn, $_POST['u_email']);
    $u_phone = mysqli_real_escape_string($conn, $_POST['u_phone']);
    
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];
    
    $is_error = false;
    $update_password_query = "";

    // กรณีที่ผู้ใช้ต้องการเปลี่ยนรหัสผ่านใหม่
    if (!empty($old_pass) || !empty($new_pass) || !empty($confirm_pass)) {
        if (empty($old_pass) || empty($new_pass) || empty($confirm_pass)) {
            $message = "<div class='alert-danger'><i class='fa-solid fa-circle-xmark'></i> กรุณากรอกข้อมูลรหัสผ่านให้ครบทั้ง 3 ช่อง</div>";
            $is_error = true;
        }
        elseif ($old_pass !== $user['u_pass']) {
            $message = "<div class='alert-danger'><i class='fa-solid fa-circle-xmark'></i> รหัสผ่านเดิมไม่ถูกต้อง!</div>";
            $is_error = true;
        }
        elseif ($new_pass !== $confirm_pass) {
            $message = "<div class='alert-danger'><i class='fa-solid fa-circle-xmark'></i> รหัสผ่านใหม่และช่องยืนยันไม่ตรงกัน!</div>";
            $is_error = true;
        }
        else {
            $safe_new_pass = mysqli_real_escape_string($conn, $new_pass);
            $update_password_query = ", u_pass='$safe_new_pass'";
        }
    }

    // หากไม่มีอะไรผิดพลาด ให้ทำการอัปเดตลงฐานข้อมูล (รวม u_prefix เข้าไปด้วย)
    if (!$is_error) {
        $update_sql = "UPDATE user SET u_title='$u_title', u_name='$u_name', u_email='$u_email', u_phone='$u_phone' $update_password_query WHERE u_id='$u_id'";
        
        if (mysqli_query($conn, $update_sql)) {
            $_SESSION['u_name'] = $u_name;
            $message = "<div class='alert-success'><i class='fa-solid fa-circle-check'></i> บันทึกการแก้ไขข้อมูลเรียบร้อยแล้ว!</div>";
            
            // โหลดข้อมูลล่าสุดมาแสดงผลใหม่
            $query = mysqli_query($conn, "SELECT * FROM user WHERE u_id = '$u_id'");
            $user = mysqli_fetch_assoc($query);
        } else {
            $message = "<div class='alert-danger'><i class='fa-solid fa-circle-xmark'></i> เกิดข้อผิดพลาดในการบันทึกข้อมูล</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ข้อมูลส่วนตัว</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;700&family=TH+Sarabun+New:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }
        body, input, select, textarea, button { 
            font-family: "TH Sarabun New", "Sarabun", sans-serif;
        }
        body { 
            background-color: #f5f7fb; 
            padding: 30px 15px; 
            margin: 0; 
            color: #333333;
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            background: #ffffff; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.04); 
        }
        h2 { 
            color: #1a365d; 
            border-bottom: 2px solid #edf2f7; 
            padding-bottom: 10px; 
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-back { 
            background: #4a5568; 
            color: white; 
            text-decoration: none; 
            padding: 4px 14px; 
            border-radius: 6px; 
            font-weight: bold; 
            display: inline-flex; 
            align-items: center;
            gap: 6px;
            margin-bottom: 20px;
            font-size: 1.15rem;
            transition: all 0.2s;
        }
        .btn-back:hover {
            background: #2d3748;
        }
        .form-group { 
            margin-bottom: 15px; 
        }
        .name-row {
            display: flex;
            gap: 15px;
        }
        .col-prefix {
            flex: 0 0 130px;
        }
        .col-name {
            flex: 1;
        }
        label { 
            display: block; 
            margin-bottom: 5px; 
            font-weight: bold; 
            font-size: 1.25rem; 
            color: #1a365d; 
        }
        .form-control { 
            width: 100%; 
            padding: 8px 12px; 
            border: 1px solid #cbd5e0; 
            border-radius: 6px; 
            box-sizing: border-box; 
            font-size: 1.2rem; 
            height: 42px;
        }
        .form-control:focus {
            outline: none;
            border-color: #3182ce;
        }
        .form-control:disabled {
            background: #edf2f7; 
            color: #718096; 
            cursor: not-allowed;
            border-color: #e2e8f0;
        }
        .password-section {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px dashed #edf2f7;
        }
        .password-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: #2b6cb0;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .password-note {
            font-size: 1.1rem;
            color: #718096;
            margin-bottom: 15px;
            margin-top: -5px;
        }
        .alert-success {
            background-color: #f0fff4;
            color: #2f855a;
            border: 1px solid #c6f6d5;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 1.2rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .alert-danger {
            background-color: #fff5f5;
            color: #c53030;
            border: 1px solid #feb2b2;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 1.2rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .btn-save { 
            background: #38a169; 
            color: white; 
            border: none; 
            padding: 10px 15px; 
            border-radius: 6px; 
            font-size: 1.3rem; 
            font-weight: bold; 
            cursor: pointer; 
            width: 100%; 
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            margin-top: 15px;
        }
        .btn-save:hover {
            background: #2f855a;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="home.php" class="btn-back"><i class="fa-solid fa-angle-left"></i> กลับหน้าหลัก</a>
        <h2><i class="fa-solid fa-user-gear" style="color: #3182ce;"></i> จัดการข้อมูลส่วนตัว</h2>
        
        <?php echo $message; ?>

        <form action="" method="POST">
            
            <div class="form-group">
                <label>ชื่อผู้ใช้งาน (Username)</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['u_username']); ?>" disabled>
            </div>

            <div class="name-row">
                <div class="form-group col-prefix">
                    <label>คำนำหน้า</label>
                    <select name="u_title" class="form-control" required>
                        <option value="นาย" <?php if($user['u_title'] == 'นาย') echo 'selected'; ?>>นาย</option>
                        <option value="นาง" <?php if($user['u_title'] == 'นาง') echo 'selected'; ?>>นาง</option>
                        <option value="นางสาว" <?php if($user['u_title'] == 'นางสาว') echo 'selected'; ?>>นางสาว</option>
                    </select>
                </div>
                <div class="form-group col-name">
                    <label>ชื่อ-นามสกุล</label>
                    <input type="text" name="u_name" class="form-control" value="<?php echo htmlspecialchars($user['u_name']); ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>คณะ / หน่วยงานที่สังกัด</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['u_faculty']); ?>" disabled>
            </div>
            
            <div class="form-group">
                <label>อีเมลติดต่อ</label>
                <input type="email" name="u_email" class="form-control" value="<?php echo htmlspecialchars($user['u_email']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>เบอร์โทรศัพท์</label>
                <input type="text" name="u_phone" class="form-control" value="<?php echo htmlspecialchars($user['u_phone']); ?>" maxlength="10" required>
            </div>

            <div class="password-section">
                <div class="password-title"><i class="fa-solid fa-lock"></i> เปลี่ยนรหัสผ่านใหม่</div>
                
                <div class="form-group">
                    <label>รหัสผ่านเดิม (Current Password)</label>
                    <input type="password" name="old_pass" class="form-control" placeholder="กรอกรหัสผ่านเดิมเพื่อยืนยัน">
                </div>
                <div class="form-group">
                    <label>รหัสผ่านใหม่ (New Password)</label>
                    <input type="password" name="new_pass" class="form-control" placeholder="ตั้งรหัสผ่านใหม่">
                </div>
                <div class="form-group">
                    <label>ยืนยันรหัสผ่านใหม่ (Confirm New Password)</label>
                    <input type="password" name="confirm_pass" class="form-control" placeholder="พิมพ์รหัสผ่านใหม่อีกครั้ง">
                </div>
            </div>

            <button type="submit" name="update_profile" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> บันทึกข้อมูล</button>
        </form>
    </div>
</body>
</html>