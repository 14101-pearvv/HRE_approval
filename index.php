<?php
// 1. เริ่มต้น Session และเชื่อมต่อฐานข้อมูล
session_start();
include("connectdb.php");

// ถ้าผู้ใช้งานมีการเข้าสู่ระบบอยู่แล้ว (Session ยังไม่ตาย) ให้ดีดไปหน้าหลักทันที ไม่ต้องให้ล็อกอินซ้ำ
if (isset($_SESSION['u_id'])) {
    header("location: home.php"); 
    exit();
}

$message_text = "";
$message_type = "";

// 2. ตรวจสอบเมื่อมีการกดปุ่ม "เข้าสู่ระบบ" ของนักวิจัย
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $table_name = "user"; 

    // ตรวจสอบข้อมูลแมปกับฟิลด์ u_username และ u_pass
    $sql = "SELECT * FROM $table_name WHERE u_username = '$username' AND u_pass = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user_data = mysqli_fetch_assoc($result);
        
        // บันทึกข้อมูลลง Session (ใช้ u_id และ u_name เป็นหลัก)
        $_SESSION['u_id'] = $user_data['u_id'];
        $_SESSION['u_name'] = $user_data['u_name'];
        
        header("location: home.php"); 
        exit();
    } else {
        $message_text = "บัญชีผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง !";
        $message_type = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ระบบบริหารจัดการการขออนุมัติจริยธรรมการวิจัยในมนุษย์</title>
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
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .header-container {
            text-align: center;
            margin-bottom: 25px;
            max-width: 800px;
        }
        .title-th {
            font-size: 1.7rem;
            font-weight: bold;
            color: #1a365d;
            margin-bottom: 5px;
            line-height: 1.3;
        }
        .title-en {
            font-size: 1.1rem;
            color: #4a5568;
            margin-top: 0;
            font-weight: 500;
        }
        .login-card {
            background: #ffffff;
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04); 
            width: 100%;
            max-width: 420px;
        }
        .login-tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 2px solid #edf2f7;
        }
        .tab-btn {
            flex: 1;
            padding: 10px;
            background: none;
            border: none;
            font-size: 1.2rem;
            font-weight: bold;
            color: #a0aec0;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }
        .tab-btn:hover {
            color: #4a5568;
        }
        .tab-btn.active {
            color: #3182ce;
            border-bottom: 3px solid #3182ce;
            margin-bottom: -2px;
        }
        .tab-btn.active.staff {
            color: #dd6b20;
            border-bottom: 3px solid #dd6b20;
        }
        .login-form-panel {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }
        .login-form-panel.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-group {
            margin-bottom: 16px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #1a365d;
            font-size: 1.2rem;
            font-weight: bold;
        }
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            font-size: 1.15rem;
            transition: all 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: #3182ce;
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            background-color: #3182ce;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1.25rem;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.2s;
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }
        .btn-submit:hover {
            background-color: #2b6cb0;
        }
        .btn-staff {
            background-color: #dd6b20;
        }
        .btn-staff:hover {
            background-color: #c05621;
        }
        .form-footer-links {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 15px;
            font-size: 1.1rem;
        }
        .form-link {
            color: #3182ce;
            text-decoration: none;
            cursor: pointer;
            font-weight: bold;
        }
        .form-link:hover {
            text-decoration: underline;
        }
        .register-text {
            text-align: center;
            margin-top: 20px;
            font-size: 1.1rem;
            color: #4a5568;
            padding-top: 15px;
            border-top: 1px solid #edf2f7;
        }
        .message-box {
            padding: 8px 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 1.15rem;
            display: none;
            font-weight: bold;
            text-align: center;
        }
        .message-box.error {
            background-color: #fff5f5;
            color: #c53030;
            border: 1px solid #feb2b2;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <h1 class="title-th">
            ระบบบริหารจัดการการขออนุมัติจริยธรรมการวิจัยในมนุษย์<br>มหาวิทยาลัยมหาสารคาม
        </h1>
        <p class="title-en">
            Human Research Ethics Approval Management System<br>Mahasarakham University
        </p>
    </div>

    <div class="login-card">
        <div class="login-tabs">
            <button class="tab-btn active" onclick="switchTab('user')">
                <i class="fa-solid fa-user-graduation"></i> นักวิจัย / ผู้ยื่นขอ
            </button>
            <button class="tab-btn" id="staff-tab" onclick="switchTab('staff')">
                <i class="fa-solid fa-user-shield"></i> เจ้าหน้าที่
            </button>
        </div>

        <div id="system-message" class="message-box <?php echo $message_type; ?>" style="<?php echo !empty($message_text) ? 'display: block;' : ''; ?>">
            <i class="fa-solid fa-circle-exclamation"></i> <?php echo $message_text; ?>
        </div>

        <div id="user-panel" class="login-form-panel active">
            <form id="user-login-form" method="POST" action="">
                <div class="form-group">
                    <label for="user-username">Username</label>
                    <input type="text" id="user-username" name="username" class="form-control" placeholder="กรอกชื่อผู้ใช้งาน" required />
                </div>
                <div class="form-group">
                    <label for="user-password">Password</label>
                    <input type="password" id="user-password" name="password" class="form-control" placeholder="กรอกรหัสผ่าน" required />
                </div>

                <button type="submit" name="login_user" class="btn-submit">
                    <i class="fa-solid fa-right-to-bracket"></i> เข้าสู่ระบบ
                </button>

                <div class="form-footer-links">
                    <a onclick="forgotPassword()" class="form-link">ลืมรหัสผ่าน?</a>
                </div>
                <div class="register-text">
                    ยังไม่มีบัญชีใช่หรือไม่?
                    <a href="register.php" class="form-link" style="margin-left: 5px;">ลงทะเบียนบัญชีใหม่</a>
                </div>
            </form>
        </div>

        <div id="staff-panel" class="login-form-panel">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="staff-id">ชื่อผู้ใช้งานเจ้าหน้าที่</label>
                    <input type="text" id="staff-id" name="staff_identity" class="form-control" placeholder="Username" required />
                </div>
                <div class="form-group">
                    <label for="staff-password">รหัสผ่าน</label>
                    <input type="password" id="staff-password" name="password" class="form-control" placeholder="Password" required />
                </div>
                <div class="form-group">
                    <label for="staff-role">สิทธิ์การใช้งาน (Role)</label>
                    <select id="staff-role" name="role" class="form-control">
                        <option value="officer">เจ้าหน้าที่กองวิจัย (Staff)</option>
                        <option value="committee">กรรมการพิจารณา (Committee)</option>
                        <option value="admin">ผู้ดูแลระบบ (Admin)</option>
                    </select>
                </div>
                <button type="submit" class="btn-submit btn-staff">
                    <i class="fa-solid fa-key"></i> เข้าสู่ระบบ
                </button>
            </form>
        </div>
    </div>

    <script>
        function switchTab(type) {
            document.getElementById("system-message").style.display = "none";
            document.getElementById("user-login-form").reset();

            document.querySelectorAll(".tab-btn").forEach((btn) => btn.classList.remove("active", "staff"));
            document.querySelectorAll(".login-form-panel").forEach((panel) => panel.classList.remove("active"));

            if (type === "user") {
                document.querySelectorAll(".tab-btn")[0].classList.add("active");
                document.getElementById("user-panel").classList.add("active");
            } else if (type === "staff") {
                const staffBtn = document.getElementById("staff-tab");
                staffBtn.classList.add("active", "staff");
                document.getElementById("staff-panel").classList.add("active");
            }
        }

        function forgotPassword() {
            alert("กรุณาติดต่อเจ้าหน้าที่กองวิจัยเพื่อรีเซ็ตรหัสผ่านของคุณในระบบฐานข้อมูล");
        }
    </script>
</body>
</html>