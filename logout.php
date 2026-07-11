<?php
session_start();

// 1. ล้างค่าตัวแปร Session ทั้งหมดในระบบ
$_SESSION = array();

// 2. ลบ Cookie ของ Session ทิ้งถาวร
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. ทำลาย Session บน Server
session_destroy();

// 4. สั่งเคลียร์แคชของหน้า Logout เองด้วย
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// 5. ส่งกลับไปหน้าแรก (index.php)
header("Location: index.php");
exit();
?>