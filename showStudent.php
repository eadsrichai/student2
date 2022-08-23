<html>
<head>
  <title>ระบบฐานข้อมูลนักเรียน</title>
  <link rel='stylesheet' href='../bootstrap-5.1.3/css/bootstrap.min.css'>
</head>
<body>
  <div class='container-fluid'>
    <div>
      <p class='mt-3 p-3  text-center bg bg-primary text-white fs-1'>ระบบฐานข้อมูลนักเรียน</p>
    </div>
    <div class="row">
    <!-- ค้นหาข้อมูลตามรหัสนักศึกษา -->
    <div class="col">
        <form action="index.php" action="GET">
          <input type="text" name="id" value="" placeholder="กรอกรหัสนักศึกษา" />
          <input type="submit" name="findById" value="ค้นหาโดยรหัส"  class="btn btn-primary btn-sm" />
        </form>
    </div>

    <!-- ค้นหาข้อมูลตามเพศนักศึกษา -->
  <div class="col">
    <form action="index.php" action="GET">
      <select name="pre">
          <option value="นาย">ชาย</option>
          <option value="นางสาว">หญิง</option>
      </select>
      <input type="submit" name="findByPre" value="ค้นหาโดยเพศ" class="btn btn-primary btn-sm"  />
    </form>
  </div>

    <!-- ค้นหาข้อมูลตามชื่อนักศึกษา -->
<div class="col">
  <form action="index.php" action="GET">
    <input type="text" name="fname" value="" placeholder="กรอกชื่อนักศึกษา" />
    <input type="submit" name="findByFname" value="ค้นหาโดยชื่อ" class="btn btn-primary btn-sm" />
  </form>
</div>

    <!-- ค้นหาข้อมูลตามแผนกวิชา -->
    <div class="col">
  <form action="index.php" action="GET">
    <select name="id_dep">
    <option value="01">ช่างยนต์</option>
    <option value="02">ช่างกลโรงงาน</option>
    <option value="09">เทคโนโลยีสารสนเทศ</option>
    </select>
    <input type="submit" name="findByIdDep" value="ค้นหาโดยแผนก" class="btn btn-primary btn-sm" />
  </form>
</div>

    </div>

<?php
//include_once('db.php');
require_once('service/db.php');
if(isset($_GET['findById']) && (isset($_GET['id'])) && $_GET['id'] != null){
    $id = $_GET['id'];

$sql =  "SELECT      s.id, s.pre, s.fname, s.lname, s.age,d.name_dep 
        FROM  		  Student s
        INNER JOIN  dep d
        ON		      s.id_dep = d.id_dep
        WHERE       s.id = $id";
}else if(isset($_GET['findByPre']) && (isset($_GET['pre'])) && $_GET['pre'] != null){
  $pre = $_GET['pre'];
  $sql =  "SELECT      s.id, s.pre, s.fname, s.lname, s.age,d.name_dep 
  FROM  		  Student s
  INNER JOIN  dep d
  ON		      s.id_dep = d.id_dep
  WHERE       s.pre like '$pre'";

}else if(isset($_GET['findByFname']) && (isset($_GET['fname'])) && $_GET['fname'] != null){
 $fname = $_GET['fname'];
 $sql =  "SELECT      s.id, s.pre, s.fname, s.lname, s.age,d.name_dep 
 FROM  		  Student s
 INNER JOIN  dep d
 ON		      s.id_dep = d.id_dep
 WHERE       s.fname like '%$fname%'";

}else if(isset($_GET['findByIdDep']) && (isset($_GET['id_dep'])) && $_GET['id_dep'] != null){
  $id_dep = $_GET['id_dep'];
  $sql =  "SELECT      s.id, s.pre, s.fname, s.lname, s.age,d.name_dep 
  FROM  		  Student s
  INNER JOIN  dep d
  ON		      s.id_dep = d.id_dep
  WHERE       s.id_dep = $id_dep";

}else {
      $sql = "SELECT      s.id, s.pre, s.fname, s.lname, s.age,d.name_dep 
      FROM  		  Student s
      INNER JOIN  dep d
      ON		      s.id_dep = d.id_dep;";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) { ?>
      <table class='table table-striped table-hover'>
        <thead>
          <tr>
            <th>รหัส</th>
            <th>คำนำหน้า</th>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>อายุ</th>
            <th><a href='showDep.php'>แผนก</a></th>
          </tr>
        </thead>
      <?php
        while($row = $result->fetch_assoc()) {  ?>
          <tr>
            <td><?php echo  $row["id"] ?> </td>
            <td><?php echo  $row["pre"]?> </td>
            <td><?php echo  $row["fname"]?> </td>
            <td><?php echo  $row["lname"]?> </td>
            <td><?php echo  $row["age"]?> </td>
            <td><?php echo  $row["name_dep"]?> </td>
          <tr>
        <?php  }  ?>
        <table>
    </div>
    <body>
</html>
<?php } else {  ?>
  <div class="alert alert-danger" role="alert">
  <h1>ไม่พบข้อมูล</h1>
</div>

<?php  }
$conn->close();
?>