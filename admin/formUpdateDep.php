<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.1.3/css/bootstrap.min.css">
    <title>update ข้อมูล</title>
</head>
<body>
    <?php
        require_once('../service/db.php');
        $id_dep = $_GET['id_dep'];
        $sql = "SELECT * FROM  	Dep WHERE id_dep = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s",$id);
        $id = $id_dep;

        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        ?>
    <div class="container">
        <div class="mt-3 p-3">
            <form action="updateDep.php" method="get">
            <label>รหัสแผนก</label>
            <input type="text" class="m-3" name="id_dep" readonly value="<?php echo $row['id_dep'] ?>" placeholder="รหัสแผนก" />
            <br>
            <label>ชื่อแผนก</label>
            <input type="text" class="m-3" name="name_dep" value="<?php echo $row['name_dep'] ?>" placeholder="ชื่อแผนก" />
            <br>
            <input type="submit" class="btn btn-primary" name="submit" value="Save" />
            </form>
        </div>
    </div>
    <?php } ?>
</body>
</html>