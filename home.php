<?php
    session_start();

    // 1. ส่ง Header สั่งห้ามเก็บ Cache (ฝั่ง Server)
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 

    // 2. เช็กสถานะล็อกอิน ถ้าไม่มี Session ให้ดีดกลับทันที
    if (!isset($_SESSION['u_id'])) {
        header("Location: index.php");
        exit();
    }
?>
<script>
    window.addEventListener('pageshow', function (event) {
        // หากหน้าเว็บนี้ถูกดึงมาจาก Cache (เช่น ตอนกดปุ่ม Back) ให้บังคับรีเฟรชตัวเองเพื่อไปเช็ก PHP ใหม่
        if (event.persisted || (typeof window.performance != "undefined" && window.performance.navigation.type === 2)) {
            window.location.reload();
        }
    });
</script>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลักระบบ - จริยธรรมการวิจัยในมนุษย์ มมส.</title>
    <link href="https://fonts.googleapis.com/css2?family=TH+Sarabun+New:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #1a365d;
            --accent-color: #3182ce;
            --bg-color: #f0f4f8;
            --text-color: #2d3748;
        }

        body {
            font-family: "TH Sarabun New", "Sarabun", sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            padding: 0;
            color: var(--text-color);
        }

        /* ส่วนหัวของหน้าเว็บ (Navbar) */
        .navbar {
            background-color: var(--primary-color);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-size: 1.4rem;
            font-weight: bold;
            line-height: 1.2;
        }
        .user-info {
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-logout {
            background-color: #e53e3e;
            color: white;
            text-decoration: none;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: bold;
            transition: background 0.2s;
        }
        .btn-logout:hover {
            background-color: #c53030;
        }

        /* ส่วนเนื้อหาหลัก */
        .main-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .welcome-text {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 25px;
        }

        /* เมนูกล่อง Grid (เมนู 1-4) */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }
        .menu-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
            text-decoration: none;
            color: var(--text-color);
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
            border: 2px solid transparent;
            cursor: pointer;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(66, 153, 225, 0.15);
            border-color: var(--accent-color);
        }
        .menu-icon {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 15px;
        }
        .menu-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 8px;
        }
        .menu-desc {
            font-size: 1.05rem;
            color: #718096;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="navbar-brand">
            ระบบบริหารจัดการการขออนุมัติจริยธรรมการวิจัยในมนุษย์<br>
            <span style="font-size: 1rem; font-weight: normal; opacity: 0.8;">มหาวิทยาลัยมหาสารคาม</span>
        </div>
        <div class="user-info">
            <i class="fa-solid fa-user-circle" style="font-size: 1.5rem;"></i>
            <span>สวัสดีคุณ: <strong><?php echo $_SESSION['u_name']; ?></strong></span>
            <a href="logout.php" class="btn-logout" onclick="return confirm('คุณต้องการออกจากระบบใช่หรือไม่?')">
                <i class="fa-solid fa-right-from-bracket"></i> ออกจากระบบ
            </a>
        </div>
    </nav>

    <main class="main-container">
        <div class="welcome-text">
            <i class="fa-solid fa-gauge-high"></i> หน้าหลักผู้ใช้งาน (Dashboard)
        </div>

        <div class="menu-grid">
            <a href="my_research.php" class="menu-card">
                <div class="menu-icon"><i class="fa-solid fa-book-bookmark"></i></div>
                <div class="menu-title">งานวิจัยของฉัน</div>
                <div class="menu-desc">ประวัติ รายละเอียดโครงการวิจัย และรูปเล่มรายงานทั้งหมด</div>
            </a>

            <a href="request.php" class="menu-card">
                <div class="menu-icon"><i class="fa-solid fa-file-signature"></i></div>
                <div class="menu-title">ยื่นขออนุมัติจริยธรรม</div>
                <div class="menu-desc">การยื่นคำร้อง และส่งเอกสารขออนุมัติโครงการวิจัยใหม่</div>
            </a>

            <a href="status.php" class="menu-card">
                <div class="menu-icon"><i class="fa-solid fa-list-check"></i></div>
                <div class="menu-title">สถานะการขออนุมัติ</div>
                <div class="menu-desc">ติดตามขั้นตอนการพิจารณา ตรวจสอบข้อแก้ไขจากกรรมการ</div>
            </a>

            <a href="profile.php" class="menu-card">
                <div class="menu-icon"><i class="fa-solid fa-id-card"></i></div>
                <div class="menu-title">ข้อมูลส่วนตัว</div>
                <div class="menu-desc">แก้ไขข้อมูลส่วนตัว หรือรหัสผ่าน</div>
            </a>
        </div>
    </main>

</body>
</html>