<?php
session_start();
include("connectdb.php");
if (!isset($_SESSION['u_id'])) { header("location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สถานะการขออนุมัติ</title>
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
            max-width: 750px; 
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
        .project-info {
            background: #f8fafc; 
            padding: 14px; 
            border-radius: 8px; 
            margin-top: 15px; 
            font-size: 1.25rem;
            border-left: 4px solid #1a365d;
        }
        .status-box { 
            border-left: 2px solid #e2e8f0; 
            padding-left: 20px; 
            margin-left: 10px; 
            margin-top: 25px; 
        }
        .status-item { 
            margin-bottom: 25px; 
            position: relative; 
        }
        .status-item::before { 
            content: ""; 
            width: 12px; 
            height: 12px; 
            background: #cbd5e0; 
            border-radius: 50%; 
            position: absolute; 
            left: -27px; 
            top: 6px; 
            border: 2px solid white;
        }
        .status-item.active::before { 
            background: #38a169; 
            box-shadow: 0 0 0 3px rgba(56, 161, 105, 0.2); 
        }
        .status-title { 
            font-size: 1.3rem; 
            font-weight: bold; 
            color: #4a5568; 
        }
        .status-item.active .status-title {
            color: #38a169;
        }
        .status-date { 
            font-size: 1.1rem; 
            color: #718096; 
        }
        .comment-area { 
            background: #fffaf0; 
            border: 1px solid #feebc8; 
            padding: 12px; 
            border-radius: 8px; 
            margin-top: 8px; 
            color: #c05621; 
            font-size: 1.15rem;
            line-height: 1.4;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="home.php" class="btn-back"><i class="fa-solid fa-angle-left"></i> กลับหน้าหลัก</a>
        <h2><i class="fa-solid fa-list-check" style="color: #3182ce;"></i> ติดตามสถานะการขออนุมัติ</h2>
        
        <div class="project-info">
            <span style="color: #718096; font-size: 1.05rem; display:block;">โครงการวิจัยของคุณ:</span>
            <strong>การพัฒนาระบบขออนุมัติจริยธรรมการวิจัยออนไลน์ (RE-69001)</strong>
        </div>

        <div class="status-box">
            <div class="status-item">
                <div class="status-title"><i class="fa-solid fa-circle-check" style="color:#3182ce;"></i> ขั้นตอนที่ 1: ยื่นเอกสารคำร้องสำเร็จ</div>
                <div class="status-date">06 กรกฎาคม 2026 - 10:30 น.</div>
            </div>
            <div class="status-item active">
                <div class="status-title"><i class="fa-solid fa-circle-exclamation" style="color:#dd6b20;"></i> ขั้นตอนที่ 2: กรรมการตรวจสอบและส่งข้อแก้ไข (กำลังดำเนินการ)</div>
                <div class="status-date">06 กรกฎาคม 2026 - 14:15 น.</div>
                <div class="comment-area">
                    <strong><i class="fa-solid fa-comment-dots"></i> ข้อความจากกรรมการ:</strong><br>
                    "กรุณาเพิ่มเติมรายละเอียดในแบบฟอร์มในส่วนที่ 3 ให้ชัดเจนรอบด้านยิ่งขึ้น"
                </div>
            </div>
        </div>
    </div>
</body>
</html>