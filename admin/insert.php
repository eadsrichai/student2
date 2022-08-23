<?php
    $id_dep = $_GET['id_dep'];
    $name_dep = $_GET['name_dep'];

    include_once('db.php');
    
    $sql = "INSERT INTO dep (id_dep, name_dep) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $id, $name);
    $id = $id_dep;
    $name = $name_dep;

    $stmt->execute();
    echo "New records created successfully";

    $stmt->close();
    $conn->close();
    header( "location: showDep.php" );
    exit(0);
?>