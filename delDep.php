<?php
    $id_dep = $_GET['id_dep'];

    //include_once('db.php');
    require_once('service/db.php');
    $sql = "DELETE FROM  dep WHERE id_dep = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $id);
    $id = $id_dep;

    $stmt->execute();

    $stmt->close();
    $conn->close();
    header( "location: showDep.php" );
    exit(0);
?>