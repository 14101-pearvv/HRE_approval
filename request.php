<?php
session_start();
include("connectdb.php");
if (!isset($_SESSION['u_id'])) { header("location: index.php"); exit(); }

if (isset($_POST['submit_research'])) {
    echo "<script>alert('ส่งคำร้องเรียบร้อยแล้ว'); window.location.href='home.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ยื่นขออนุมัติจริยธรรม</title>
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
            margin-bottom: 16px; 
        }
        label { 
            display: block; 
            margin-bottom: 6px; 
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
            background: #fff;
        }
        .form-control:focus {
            outline: none;
            border-color: #3182ce;
        }
        .btn-submit { 
            background: #3182ce; 
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
            margin-top: 10px;
        }
        .btn-submit:hover { 
            background: #2b6cb0; 
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="home.php" class="btn-back"><i class="fa-solid fa-angle-left"></i> กลับหน้าหลัก</a>
        <h2><i class="fa-solid fa-file-pen" style="color: #3182ce;"></i> ยื่นคำร้องขออนุมัติโครงการวิจัยใหม่</h2>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>ชื่อโครงการวิจัย (ภาษาไทย)</label>
                <input type="text" name="res_title_th" class="form-control" required placeholder="กรอกชื่อโครงการภาษาไทย">
            </div>
            <div class="form-group">
                <label>ชื่อโครงการวิจัย (ภาษาอังกฤษ)</label>
                <input type="text" name="res_title_en" class="form-control" required placeholder="กรอกชื่อโครงการภาษาอังกฤษ">
            </div>
            <div class="form-group">
                <label>ประเภทการวิจัย</label>
                <select name="res_type" class="form-control" required>
                    <option value="">-- กรุณาเลือกประเภท --</option>
                    <option value="การวิจัยเชิงทดลอง">การวิจัยเชิงทดลอง (Experimental)</option>
                    <option value="การวิจัยเชิงสำรวจ">การวิจัยเชิงสำรวจ (Survey)</option>
                </select>
            </div>
            <div class="form-group">
                <label>แนบไฟล์เอกสารโครงการวิจัย (.pdf เท่านั้น)</label>
                <input type="file" name="res_file" class="form-control" accept=".pdf" required>
            </div>
            <button type="submit" name="submit_research" class="btn-submit"><i class="fa-solid fa-paper-plane"></i> ส่งเอกสารคำร้อง</button>
        </form>
    </div>
</body>
</html>