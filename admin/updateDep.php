<?php
    // รับข้อมูล รหัส และ ชื่อแผนก เก็บไว้ในตัวแปร
    $id_dep = $_GET['id_dep'];
    $name_dep = $_GET['name_dep'];

    // ติดต่อฐานข้อมูล
   // include_once('db.php');
    require_once('../service/db.php');
    // คำสั่ง sql สำหรับ การ update ชื่อแผนกที่เปลี่ยนแปลง
    $sql = "UPDATE  dep SET  name_dep=? WHERE id_dep = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $name,$id);
    $name = $name_dep;
    $id = $id_dep;

    $stmt->execute();

    // ปิดการเชื่อมต่อฐานข้อมูล
    $stmt->close();
    $conn->close();
    
    // ไปยังไฟล์ showDep.php
    header( "location: showDep.php" );
    exit(0);
?>