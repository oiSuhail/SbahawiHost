<?php
    ob_start();
	session_start();
	$pageTitle = "Login";
    $noNavbar = "";
    $noFooter = "";

    if(isset($_SESSION['username'])) { 
        if($_SESSION['rank'] == "Member") {
            header("Location: Member-CP/index.php");
        } elseif($_SESSION['rank'] == "Support") {
            header("Location: Support-CP/index.php");
        } elseif($_SESSION['rank'] == "Admin") {
            header("Location: Admin-CP/index.php");
        }
    }
    include "LinkFiles.php";
        
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedPass = sha1($password);

        $stmt = $con->prepare("SELECT userid, username, password, rank FROM users WHERE username = ? AND password = ? LIMIT 1");

        $stmt->execute(array($username, $hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if($count > 0) {
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $row['userid'];
            $_SESSION['rank'] = $row['rank'];
            
            header("Location: index.php");
            } else {
            header("Location: Login.php");
            }
            exit();
        }
?>
    <div class="login-form text-center">
        <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <h4 class="text-center">تسجيل دخول</h4>
            <input class="form-control" type="text" name="username" placeholder="اسم المستخدم">
            <input class="form-control" type="password" name="password" placeholder="كلمة المرور">
            <input class="btn btn-primary btn-block" type="submit" value="Login">
        </form>
        <div class="login-form-bottom">
            <a href="#"><p class="lead">هل نسيت كلمة المرور ؟</p></a>
            <a href="index.php"><p class="lead back">الرجوع الى الصفحة الرئيسية</p></a>
        </div>
    </div>

<?php include $tmp . "footer.php";
ob_end_flush();
?>