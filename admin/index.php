<?php
session_start();

// if ($_SESSION['username'] != null && $_SESSION['password'] != null) { 
  
if(!isset($_SESSION['username']) ){
        header("location:login.php");
        exit(0);
    }else {  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>ระบบฐานข้อมูลนักเรียน</title>
  </head>

  <body>
    <div class="container">
      <div class="row">
        <div class="col">
          <p class=" p-3 fs-1 text-center text-white bg-primary">ระบบฐานข้อมูลนักเรียน</p>
          <p>ยินดีต้อนรับคุณ : <?php echo $_SESSION['username']; ?></p>
        </div>
      </div>

      <div class="row">
        <div class="col" style="height: 80vh;">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php?type=01">ข้อมูลนักเรียน</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?type=02">ข้อมูลแผนก</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">ข้อมูลครู</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
        <div class="col-10" style="height: 80vh;">
          <?php
          //include_once('db.php');
          require_once('../service/db.php');
          $total_record = null;
         if (!isset($_GET['type']) || $_GET['type'] == "01") {  ?>
            <div class="row">
              <!-- ค้นหาข้อมูลตามรหัสนักศึกษา -->
              <div class="col">
                <form action="index.php" action="GET">
                  <input type="hidden" name="type" value="01" />
                  <input type="text" class="w-50" name="id" value="" placeholder="กรอกรหัสนักศึกษา" />
                  <input type="submit" name="findById" value="ค้นหา" class="btn btn-primary btn-sm" />
                </form>
              </div>

              <!-- ค้นหาข้อมูลตามเพศนักศึกษา -->
              <div class="col-2">
                <form action="index.php" action="GET">
                  <input type="hidden" name="type" value="01" />
                  <select name="pre">
                    <option value="นาย">ชาย</option>
                    <option value="นางสาว">หญิง</option>
                  </select>
                  <input type="submit" name="findByPre" value="ค้นหา" class="btn btn-primary btn-sm" />
                </form>
              </div>

              <!-- ค้นหาข้อมูลตามชื่อหรือนามสกุลนักศึกษา -->
              <div class="col">
                <form action="index.php" action="GET">
                  <input type="hidden" name="type" value="01" />
                  <input type="text" name="fname" class="w-50" value="" placeholder="กรอกชื่อหรือนามสกุล" />
                  <input type="submit" name="findByFname" value="ค้นหา" class="btn btn-primary btn-sm" />
                </form>
              </div>

              <!-- ค้นหาข้อมูลตามแผนกวิชา -->
              <div class="col-4">
                <?php $sqldep =  "SELECT  id_dep, name_dep FROM  	dep";
                $result = $conn->query($sqldep);
                ?>

                <form action="index.php" action="GET">
                  <input type="hidden" name="type" value="01" />
                  <select name="id_dep">
                    <?php if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id_dep'] ?>"><?php echo $row['name_dep']  ?></option>

                    <?php }
                    } ?>
                  </select>
                  <input type="submit" name="findByIdDep" value="ค้นหา" class="btn btn-primary btn-sm" />
                </form>
              </div>
            </div>
            <?php

            if (isset($_GET['findById']) && (isset($_GET['id'])) && $_GET['id'] != null) {
              $id = $_GET['id'];
              $sql =  "SELECT     s.id, s.pre, s.fname, s.lname, s.age,d.name_dep 
                      FROM  		  Student s
                      INNER JOIN  dep d
                      ON		      s.id_dep = d.id_dep
                      WHERE       s.id = $id";
            } else if (isset($_GET['findByPre']) && (isset($_GET['pre'])) && $_GET['pre'] != null) {
              $pre = $_GET['pre'];
              $sql =  "SELECT      s.id, s.pre, s.fname, s.lname, s.age,d.name_dep 
                      FROM  		  Student s
                      INNER JOIN  dep d
                      ON		      s.id_dep = d.id_dep
                      WHERE       s.pre like '$pre'";
            } else if (isset($_GET['findByFname']) && (isset($_GET['fname'])) && $_GET['fname'] != null) {
              $fname = $_GET['fname'];
              $sql =  "SELECT      s.id, s.pre, s.fname, s.lname, s.age,d.name_dep 
                      FROM  		  Student s
                      INNER JOIN  dep d
                      ON		      s.id_dep = d.id_dep
                      WHERE       s.fname like '%$fname%'
                      OR          s.lname like '%$fname%'";
            } else if (isset($_GET['findByIdDep']) && (isset($_GET['id_dep'])) && $_GET['id_dep'] != null) {
              $id_dep = $_GET['id_dep'];
              $sql =  "SELECT      s.id, s.pre, s.fname, s.lname, s.age,d.name_dep 
                      FROM  		  Student s
                      INNER JOIN  dep d
                      ON		      s.id_dep = d.id_dep
                      WHERE       s.id_dep = $id_dep";
            } else {
              $perpage = 7;
              if (isset($_GET['page'])) {
                $page = $_GET['page'];
              } else {
                $page = 1;
              }

              $start = ($page - 1) * $perpage;

              $sql = "SELECT      s.id, s.pre, s.fname, s.lname, s.age,d.name_dep 
                      FROM  		  Student s
                      INNER JOIN  dep d
                      ON		      s.id_dep = d.id_dep
                      LIMIT       {$start} , {$perpage}";

              $sql2 = "SELECT      s.id, s.pre, s.fname, s.lname, s.age,d.name_dep 
                      FROM  		  Student s
                      INNER JOIN  dep d
                      ON		      s.id_dep = d.id_dep ";


              $result2 = $conn->query($sql2);
              $total_record = $result2->num_rows;
              $total_page = ceil($total_record / $perpage);
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
                    <th><a href='?type=02'>แผนก</a></th>
                  </tr>
                </thead>
                <?php
                while ($row = $result->fetch_assoc()) {  ?>
                  <tr>
                    <td><?php echo  $row["id"] ?> </td>
                    <td><?php echo  $row["pre"] ?> </td>
                    <td><?php echo  $row["fname"] ?> </td>
                    <td><?php echo  $row["lname"] ?> </td>
                    <td><?php echo  $row["age"] ?> </td>
                    <td><?php echo  $row["name_dep"] ?> </td>
                  <tr>
                  <?php  }  ?>
                  <table>
        </div>
        <?php if ($total_record != null) { ?>
          <div>
            <nav aria-label="Page navigation students">
              <ul class="pagination   justify-content-center">
                <?php if ($page == 1) { ?>
                  <li class="page-item disabled">
                  <?php } else { ?>
                  <li class="page-item ">
                  <?php } ?>
                  <a class="page-link" href="index.php?type=01&page=1">Previous</a>
                  </li>


                  <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                    <?php if ($page == $i) { ?>
                      <li class="page-item active " aria-current="page">
                      <?php } else { ?>
                      <li class="page-item ">
                      <?php }  ?>
                      <a class="page-link" href="index.php?type=01&page=<?php echo $i; ?>"> <?php echo $i; ?></a>
                      </li>
                    <?php } ?>

                    <?php if ($page == $total_page) { ?>
                      <li class="page-item disabled">
                      <?php } else { ?>
                      <li class="page-item ">
                      <?php } ?>
                      <a class="page-link" href="index.php?type=01&page=<?php echo $total_page; ?>">Next</a>
                      </li>
              </ul>
            </nav>
          </div>

        <?php }
            } else {  ?>
        <div class="alert alert-danger" role="alert">
          <h1>ไม่พบข้อมูล</h1>
        </div>

      <?php  }
          } else if (isset($_GET['type']) && $_GET['type'] == '02') {  ?>
      <table class="table  table-striped table-hover">
        <thead>
          <tr>
            <th>รหัสแผนก</th>
            <th>ชื่อแผนก</th>

          </tr>
        </thead>
        <?php
            $sql =  "SELECT  id_dep, name_dep FROM  	dep";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

              while ($row = $result->fetch_assoc()) {  ?>
            <tr>
              <td> <?php echo $row["id_dep"] ?> </td>
              <td> <?php echo $row["name_dep"] ?> </td>
              <td>
                <a class='btn btn-danger' role='button' href='delDep.php?id_dep=<?php echo $row["id_dep"] ?>'>
                  Del</a>
              </td>
              <td>
                <a class='btn btn-warning' role='button' href='formUpdateDep.php?id_dep=<?php echo $row["id_dep"] ?>'>
                  Update</a>
              </td>
            </tr>
          <?php
              }
          ?>
          <table>
        <?php
            }
          }
          $conn->close();
        ?>
      </div>
      <div class="row">
        <div>
          <p class="bg-warning">Footer</p>
        </div>
      </div>
    </div>
  </body>

  </html>



<?php
} 
?>