<?php   
    session_start();
    if(isset($_SESSION['username']) ){
        header("location:index.php");
        exit(0);
    }else {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../service/css/bootstrap.min.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="border justify-content-center border-primary mt-5 row">
            <form action="login.php" method="GET">
                <div class="mb-3 row mt-5 justify-content-center">
                    <div class="col-sm-4 text-center">
                        Login
                    </div>
                </div>
                <div class="mb-3 row justify-content-center ">
                    <label for="username" class="col-sm-1 col-form-label">Username</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="username" id="username" value="">
                    </div>
                </div>
                <div class="mb-3 row justify-content-center">
                    <label for="password" class="col-sm-1 col-form-label">Password</label>
                    <div class="col-sm-2">
                        <input type="password" class="form-control" name="password" id="pasword">
                    </div>
                </div>
                <div class="mb-3 row justify-content-center">
                    <div class="col-1">
                        <input type="submit" value="Login" class="btn btn-primary" name="login" />
                    </div>

                </div>
            </form>
        </div>

    </div>
</body>

</html>
<?php
if (isset($_GET['username']) && isset($_GET['password']) && isset($_GET['login'])) {
    $u = $_GET['username'];
    $p = $_GET['password'];


    require_once('../service/db.php');

    $sqlLogin = "SELECT * FROM account WHERE username   = ? AND password = ? AND id_type = '0'";

    $stmt = $conn->prepare($sqlLogin);

    $stmt->bind_param("ss", $u, $p);


    $stmt->execute();
    $result = $stmt->get_result();
   
    if($row = $result->fetch_assoc()){
        session_start();
        $_SESSION['username'] = $row['username'];
        $_SESSION['password'] = $row['password'];
        header('location:index.php');
        
    }
   
    $stmt->close();
    $conn->close();

} }
?>