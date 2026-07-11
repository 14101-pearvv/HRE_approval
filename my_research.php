<?php
session_start();
include("connectdb.php");
if (!isset($_SESSION['u_id'])) { header("location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>งานวิจัยของฉัน</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;700&family=TH+Sarabun+New:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        * {
            box-sizing: border-box;
        }
        /* กำหนดฟอนต์ให้เฉพาะข้อความ ไม่กระทบไอคอน */
        body, input, select, textarea, button, table { 
            font-family: "TH Sarabun New", "Sarabun", sans-serif;
        }
        body { 
            background-color: #f5f7fb; 
            padding: 30px 15px; 
            margin: 0; 
            color: #333333;
            -webkit-font-smoothing: antialiased;
        }
        .container { 
            max-width: 950px; 
            margin: 0 auto; 
            background: #ffffff; 
            padding: 25px 30px; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.04); 
        }
        h2 { 
            color: #1a365d; 
            border-bottom: 2px solid #edf2f7; 
            padding-bottom: 10px; 
            margin-top: 0;
            margin-bottom: 5px;
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        p {
            font-size: 1.25rem;
            color: #666666;
            margin-top: 0;
            margin-bottom: 20px;
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
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 1.2rem; 
            background: white;
        }
        th { 
            background-color: #1a365d; 
            color: white; 
            padding: 10px 14px; 
            text-align: left; 
            font-weight: bold;
        }
        td { 
            padding: 12px 14px; 
            border-bottom: 1px solid #edf2f7; 
            line-height: 1.4;
        }
        tr:last-child td {
            border-bottom: none;
        }
        tr:hover { 
            background-color: #f8fafc; 
        }
        
        /* 🛠️ ปรับแต่งขนาดตัวอักษรของวันที่ส่งให้กะทัดรัดขึ้น */
        .date-text {
            color: #4a5568;
            font-size: 1.05rem; /* ลดขนาดลงมาจาก 1.2rem */
        }

        /* 🛠️ ปรับแต่งปุ่มดูข้อมูลให้ขนาดตัวอักษรพอดีกับไอคอนดวงตา */
        .btn-action {
            color: #3182ce;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.05rem; /* ปรับลดขนาดฟอนต์ของปุ่ม */
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 2px 8px; /* ปรับ Padding ให้สมดุลขึ้น */
            border-radius: 4px;
            background: #ebf8ff;
            transition: all 0.2s;
        }
        .btn-action:hover {
            background: #3182ce;
            color: white;
        }
        /* ล็อกขนาดไอคอนในปุ่มไม่ให้หดตามขนาดฟอนต์ข้อความ */
        .btn-action i {
            font-size: 0.95rem; 
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="home.php" class="btn-back"><i class="fa-solid fa-angle-left"></i> กลับหน้าหลัก</a>
        <h2><i class="fa-solid fa-folder-open" style="color: #3182ce;"></i> งานวิจัยของฉัน</h2>
        <p>ประวัติและรายละเอียดโครงการวิจัยทั้งหมดของคุณในระบบ</p>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th width="15%">รหัสโครงการ</th>
                        <th width="55%">ชื่อโครงการวิจัย (ไทย/อังกฤษ)</th>
                        <th width="18%">วันที่ยื่น</th>
                        <th width="12%" style="text-align: center;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: bold; color: #4a5568;">RE-69001</td>
                        <td>
                            <strong style="color: #1a365d;">การพัฒนาระบบขออนุมัติจริยธรรมการวิจัยออนไลน์</strong>
                            <div style="color:#718096; font-size:1.05rem; margin-top: 2px;">Online Research Ethics Approval System Development</div>
                        </td>
                        <td class="date-text">06 ก.ค. 2026</td>
                        <td style="text-align: center;">
                            <a href="#" class="btn-action"><i class="fa-solid fa-eye"></i> ดูข้อมูล</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>