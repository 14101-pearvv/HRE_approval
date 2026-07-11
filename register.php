<?php
// 1. เริ่มต้น Session และเชื่อมต่อฐานข้อมูล
session_start();
include("connectdb.php");

$message_text = "";
$message_type = "";

// 2. เมื่อมีการกดปุ่ม "ยืนยันการลงทะเบียน"
if (isset($_POST['register_user'])) {
    // รับค่าจากฟอร์มและป้องกัน SQL Injection
    $u_title    = mysqli_real_escape_string($conn, $_POST['u_title']);
    $u_name     = mysqli_real_escape_string($conn, $_POST['u_name']);
    $u_email    = mysqli_real_escape_string($conn, $_POST['u_email']);
    $u_phone    = mysqli_real_escape_string($conn, $_POST['u_phone']);
    $u_faculty  = mysqli_real_escape_string($conn, $_POST['u_faculty']); // รับค่าจาก Select Box
    $u_username = mysqli_real_escape_string($conn, $_POST['u_username']);
    $u_pass     = mysqli_real_escape_string($conn, $_POST['u_pass']);

    // 3. ตรวจสอบชื่อผู้ใช้งานซ้ำในตาราง users
    $check_user = "SELECT * FROM user WHERE u_username = '$u_username'";
    $query_check = mysqli_query($conn, $check_user);

    if (mysqli_num_rows($query_check) > 0) {
        $message_text = "ชื่อผู้ใช้งาน หรือ รหัสนิสิตนี้เคยลงทะเบียนแล้ว !";
        $message_type = "error";
    } else {
        // 4. บันทึกข้อมูลลงตารางให้แมปตรงกับโครงสร้างจริงในตาราง MySQL
        $sql = "INSERT INTO user (u_title, u_name, u_email, u_phone, u_faculty, u_username, u_pass) 
                VALUES ('$u_title', '$u_name', '$u_email', '$u_phone', '$u_faculty', '$u_username', '$u_pass')";
        
        if (mysqli_query($conn, $sql)) {
            $message_text = "ลงทะเบียนบัญชีใหม่สำเร็จแล้ว !";
            $message_type = "success";
            
            // หน่วงเวลา 2 วินาทีแล้วพากลับไปหน้าเข้าสู่ระบบ (index.php)
            echo "<script>
                    setTimeout(function(){
                        window.location.href = 'index.php';
                    }, 2000);
                  </script>";
        } else {
            $message_text = "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . mysqli_error($conn);
            $message_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียนบัญชีใหม่ - ระบบขออนุมัติจริยธรรมการวิจัย</title>
    <link href="https://fonts.googleapis.com/css2?family=TH+Sarabun+New:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "TH Sarabun New", "Sarabun", sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            box-sizing: border-box;
        }
        .register-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 500px;
        }
        .form-title {
            font-size: 1.6rem;
            font-weight: bold;
            color: #1a365d;
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #3182ce;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 1.1rem;
            font-weight: bold;
            color: #2d3748;
        }
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1.05rem;
            font-family: inherit;
        }
        .form-control:focus {
            outline: none;
            border-color: #3182ce;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
        }
        .row-grid {
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: 10px;
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            background-color: #3182ce;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 15px;
        }
        .btn-submit:hover {
            background-color: #2b6cb0;
        }
        .link-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 1.05rem;
        }
        .link-footer a {
            color: #3182ce;
            text-decoration: none;
            font-weight: bold;
        }
        .link-footer a:hover {
            text-decoration: underline;
        }
        .message-box {
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 1.1rem;
            font-weight: bold;
            text-align: center;
            display: none;
        }
        .message-box.error { background-color: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }
        .message-box.success { background-color: #f0fff4; color: #22543d; border: 1px solid #9ae6b4; }
    </style>
</head>
<body>

    <div class="register-card">
        <h2 class="form-title">ลงทะเบียนบัญชีผู้ใช้งานใหม่</h2>

        <?php if (!empty($message_text)): ?>
            <div class="message-box <?php echo $message_type; ?>" style="display: block;">
                <?php echo $message_text; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>ชื่อ-นามสกุล</label>
                <div class="row-grid">
                    <select name="u_title" class="form-control" required>
                        <option value="">คำนำหน้า</option>
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>
                    <input type="text" name="u_name" class="form-control" placeholder="ชื่อ และ นามสกุล" required>
                </div>
            </div>

            <div class="form-group">
                <label for="u_email">อีเมล (E-mail)</label>
                <input type="email" id="u_email" name="u_email" class="form-control" placeholder="example@msu.ac.th" required>
            </div>

            <div class="form-group">
                <label for="u_phone">เบอร์โทรศัพท์</label>
                <input type="text" id="u_phone" name="u_phone" class="form-control" maxlength="10" placeholder="เช่น 089xxxxxxx" required>
            </div>

            <div class="form-group">
                <label for="u_faculty">คณะ / หน่วยงานที่สังกัด</label>
                <select id="u_faculty" name="u_faculty" class="form-control" required>
                    <option value="">-- คณะที่สังกัด --</option>
                    <option value="คณะวิทยาศาสตร์">คณะวิทยาศาสตร์</option>
                    <option value="คณะเทคโนโลยี">คณะเทคโนโลยี</option>
                    <option value="คณะวิศวกรรมศาสตร์">คณะวิศวกรรมศาสตร์</option>
                    <option value="คณะวิทยาการสารสนเทศ">คณะวิทยาการสารสนเทศ</option>
                    <option value="คณะสิ่งแวดล้อมและทรัพยากรศาสตร์">คณะสิ่งแวดล้อมและทรัพยากรศาสตร์</option>
                    <option value="คณะสถาปัตยกรรมศาสตร์ ผังเมือง และนฤมิตศิลป์">คณะสถาปัตยกรรมศาสตร์ ผังเมือง และนฤมิตศิลป์</option>
                    <option value="คณะแพทยศาสตร์">คณะแพทยศาสตร์</option>
                    <option value="คณะเภสัชศาสตร์">คณะเภสัชศาสตร์</option>
                    <option value="คณะพยาบาลศาสตร์">คณะพยาบาลศาสตร์</option>
                    <option value="คณะสาธารณสุขศาสตร์">คณะสาธารณสุขศาสตร์</option>
                    <option value="คณะสัตวแพทยศาสตร์">คณะสัตวแพทยศาสตร์</option>
                    <option value="คณะมนุษยศาสตร์และสังคมศาสตร์">คณะมนุษยศาสตร์และสังคมศาสตร์</option>
                    <option value="คณะศึกษาศาสตร์">คณะศึกษาศาสตร์</option>
                    <option value="คณะการบัญชีและการจัดการ">คณะการบัญชีและการจัดการ</option>
                    <option value="คณะการท่องเที่ยวและการโรงแรม">คณะการท่องเที่ยวและการโรงแรม</option>
                    <option value="วิทยาลัยการเมืองการปกครอง (รัฐศาสตร์)">วิทยาลัยการเมืองการปกครอง (รัฐศาสตร์)</option>
                    <option value="วิทยาลัยดุริยางคศิลป์">วิทยาลัยดุริยางคศิลป์</option>
                    <option value="คณะวัฒนธรรมศาสตร์">คณะวัฒนธรรมศาสตร์</option>
                    <option value="คณะนิติศาสตร์">คณะนิติศาสตร์</option>
                </select>
            </div>

            <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 20px 0;">

            <div class="form-group">
                <label for="u_username">Username (รหัสนิสิต / ชื่อผู้ใช้)</label>
                <input type="text" id="u_username" name="u_username" class="form-control" placeholder="ใช้สำหรับเข้าสู่ระบบ" required>
            </div>

            <div class="form-group">
                <label for="u_pass">Password (รหัสผ่าน)</label>
                <input type="password" id="u_pass" name="u_pass" class="form-control" minlength="4" placeholder="ตั้งรหัสผ่านของคุณ" required>
            </div>

            <button type="submit" name="register_user" class="btn-submit">ยืนยันการลงทะเบียน</button>
        </form>

        <div class="link-footer">
            มีบัญชีอยู่แล้ว? <a href="index.php">Log in</a>
        </div>
    </div>

</body>
</html>