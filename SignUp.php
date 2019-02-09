<?php 
    ob_start();
    session_start();
    $pageTitle = "Sign Up";
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
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashedPass = sha1($password);
        
        checkItem("username", "users", $username);
        checkItem("email", "users", $email);
        
			$formErrors = array();

			if (strlen($username) < 5) {
				$formErrors[] = "اسم المستخدم لا يمكن أن يكون أقل من 4 أحرف";
			}

			if (strlen($username) > 16) {
				$formErrors[] = "اسم المتخدم لا يمكن أن يكون أكثر من 16 حرف";
			}

			if (empty($username)) {
				$formErrors[] = "اسم المستخدم لا يمكن أن يكون فارغا";
			}
            
			if (empty($password)) {
				$formErrors[] = "كلمة المرور لا يمكن أن تكون فارغة";
			}

			if (empty($fullname)) {
				$formErrors[] = "اسمك كاملا لا يمكن أن يكون فارغا";
			}

			if (empty($email)) {
				$formErrors[] = "البريد الإلكتروني لا يمكن أن يكون فارغا";
			}
        
            $count = checkItem("username", "users", $username);
            
            if ($count > 0) {
                $formErrors[] = "اسم المستخدم مستخدم من قبل";
            }
        
            $count = checkItem("email", "users", $email);
        
            if ($count > 0) {
                $formErrors[] = "البريد الإلكتروني مستخدم من قبل";
            }

			foreach ($formErrors as $error) {
				echo "<div class='text-center alert alert-danger error-msg'>" . $error . "</div>";
			}
        
            if (empty($formErrors)) {
                $stmt = $con->prepare("INSERT INTO `users` (`username`, `password`, `email`, `fullname`, `date`) VALUES (:username, :password, :email, :fname, now());");
                
                $stmt->execute(array(
                    'username' => $username,
                    'password' => $hashedPass,
                    'email' => $email,
                    'fname' => $fullname
                ));
                echo "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Inserted" . "</div>";
                header("refresh:3;url=index.php");
            }
    }

?>


    <div class="login-form text-center">
        <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <h4 class="text-center">تسجيل</h4>
            <input class="form-control" type="text" name="username" placeholder="اسم المستخدم">
            <input class="form-control" type="text" name="fullname" placeholder="اسمك الكامل">
            <input class="form-control" type="email" name="email" placeholder="بريدك الإلكتروني">
            <input class="form-control" type="password" name="password" placeholder="كلمة المرور">
            <input class="btn btn-primary btn-block" type="submit" value="تسجيل">
        </form>
        <div class="login-form-bottom">
            <a href="index.php"><p class="lead back">الرجوع الى الصفحة الرئيسية</p></a>
        </div>
    </div>

<?php ob_end_flush(); ?>