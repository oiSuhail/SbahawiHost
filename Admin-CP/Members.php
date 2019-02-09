<?php
    ob_start();
	session_start();

	$pageTitle = "Members";

	if (isset($_SESSION['username'])) {
        if($_SESSION['rank'] == "Member") {
            header("Location: ../Member-CP/index.php");
        } elseif($_SESSION['rank'] == "Support") {
            header("Location: ../Support-CP/index.php");
        }

		include 'LinkFiles.php';

		$do = isset($_GET['do']) ? $_GET['do'] : "Manage";

		if ($do == "Manage") {
?>
            <div class="container text-center">
                <div class="tickets-table">
                    <p class="lead">جميع الأعضاء :</p>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col"><i class="fas fa-cogs"></i></th>
                          <th scope="col">تاريخ دخوله</th>
                          <th scope="col">البريد الالكتروني</th>
                          <th scope="col">اسم المستخدم</th>
                          <th scope="col">#id</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            $stmt = $con->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $rows = $stmt->fetchAll();

                            foreach($rows as $row) {
                                    echo '<tr>';
                                    echo '<td>';
                                    echo '<a href="Members.php?do=Delete&uid=' . $row['userid'] . '" class="btn btn-danger members-btn delete-btn ';
                                    echo ($row['rank'] == "Admin") ? "disabled" : '';
                                    echo'">';
                                        echo 'حذف';
                                    echo '</a>';
                                        echo '<a href="Members.php?do=Edit&uid=' . $row['userid'] . '"class="btn btn-primary members-btn">تعديل</a>';
                                    echo '</td>';
                                    echo '<td>' . $row['date'] . '</td>';
                                    echo '<td>' . $row['email'] . '</td>';
                                    echo '<td>' . $row['username'] . '</td>';
                                    echo '<td>' . $row['userid'] . '</td>';
                                echo '</tr>';
                            }
                           ?>
                      </tbody>
                    </table>
                </div>
            </div>

<?php
            
		} elseif ($do == "Edit") {
        $userid = isset($_GET['uid']) && is_numeric($_GET['uid']) ? intval($_GET['uid']) : 0;
            
        $stmt = $con->prepare("SELECT * FROM users WHERE userid = ? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if($count > 0) {
                                  ?>
		    <h1 class="text-center">تعديل بيانات العضو</h1>
            <div class="edit-form text-right">
                <div class="container">
                    <form action="?do=Update" method="POST">
                        <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                        <!-- Start Username Field -->
                            <label class="col-sm-2 control-label">اسم المستخدم</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="username" class="form-control" value="<?php echo $row['username'];?>" required="required" autocomplete="off">
                            </div>
                        <!-- End Username Field -->

                        <!-- Start Password Field -->
                            <label class="col-sm-2 control-label">كلمة المرور</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="hidden" name="oldpassword" value="<?php echo $row['password']; ?>">
                                <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="اتركه فارغََا اذا لم ترد تغيير كلمة المرور">
                            </div>
                        <!-- End Password Field -->

                        <!-- Start Email Field -->
                            <label class="col-sm-2 control-label">البريد الإلكتروني</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="email" name="email" value="<?php echo $row['email'] ?>" class="form-control" required="required">
                            </div>
                        <!-- End Email Field -->

                        <!-- Start Full Name Field -->
                            <label class="col-sm-2 control-label">إسمك الكامل</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="full" value="<?php echo $row['fullname'] ?>" class="form-control" required="required">
                            </div>
                        <!-- End Full Name Field -->
                        
                        <!-- Start Rank Field -->
                            <label for="userrank">الرتبة</label>
                            <select class="form-control" name="userrank" id="userrank">
                                <option value="Member"<?php echo ($row['rank'] == "Member") ? ' selected="selected"' : ''; ?>>عضو</option>
                                <option value="Support"<?php echo ($row['rank'] == "Support") ? ' selected="selected"' : ''; ?>>مساعد</option>
                                <option value="Admin"<?php echo ($row['rank'] == "Admin") ? ' selected="selected"' : ''; ?>>رئيس</option>
                            </select>
                        <!-- End Rank Field -->
                        
                        <!-- Start submit Field -->
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="احفظ" class="btn btn-success edit-btn">
                                <a href="Members.php" class="btn btn-outline-secondary edit-btn">رجوع</a>
                            </div>
                        <!-- End submit Field -->
                    </form>
                </div>
            </div>
		<?php } else {

			echo "<div class='container'>";

            $theMsg = "<div class='alert alert-warning'>هذا المعرف غير موجود</div>";

			redirectHome($theMsg);

			echo "</div>";

		}
		} elseif ($do == "Update") {
		echo "<div class='container'>";

		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			// get the vars 

			$userid = $_POST['userid'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			$fullname = $_POST['full'];
            $rank = $_POST['userrank'];

			// password trick

		    $password = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);;

			// validate the form

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
            
			if (empty($fullname)) {
				$formErrors[] = "اسمك كاملا لا يمكن أن يكون فارغا";
			}

			if (empty($email)) {
				$formErrors[] = "البريد الإلكتروني لا يمكن أن يكون فارغا";
			}
        
			foreach ($formErrors as $error) {
				echo "<div class='alert alert-danger'>" . $error . "</div>";
			}

			if (empty($formErrors)) {

			// Update the database

			$stmt = $con->prepare("Update users SET username = ?, email = ?, fullname = ?, password = ?, rank = ? WHERE userid = ?");
			$stmt->execute(array($username, $email, $fullname, $password, $rank, $userid));

			$theMsg = "<div class='alert alert-success'>تم تعديل البيانات</div>";

			redirectHome($theMsg, "back");
		}


		} else {

			$theMsg = "<div class='alert alert-danger'>عذرََا لا يمكن دخول هذه الصفحة</div>";

			redirectHome($theMsg);

		}
		echo "</div>";
        

		} elseif ($do == "Delete") {
            
    	$userid = isset($_GET['uid']) && is_numeric($_GET['uid']) ? intval($_GET['uid']) : 0;

        $check = checkItem("userid", "users", $userid);
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            
            if ($check > 0) {

                $stmt = $con->prepare("DELETE FROM tickets WHERE tickets.userid = ?;
                                       DELETE FROM users WHERE users.userid = ?");            
                $stmt->execute(array($userid, $userid));

                $theMsg = "<div class='alert alert-success'>تم الحذف</div>";

                echo "<div class='container'>";

                redirectHome($theMsg, "back");

                echo "</div>";


            } else {

                $theMsg = "<div class='alert alert-warning'>هذا المعرف غير موجود</div>";

                echo "<div class='container'>";

                redirectHome($theMsg);

                echo "</div>";

            }  
        } else {
            $theMsg = "<div class='alert alert-warning'>طريقة دخولك خاطئة</div>";
            
            echo "<div class='container'>";
            
            redirectHome($theMsg);
            
            echo "</div>";
        }

	} else {            

			$theMsg = "<div class='alert alert-danger'>عذرََا لا يمكن دخول هذه الصفحة</div>";

            redirectHome($theMsg, "back");

		}
    
    
    } else {

		header("Location: ../index.php");

		exit();
	}

    include $tmp . "footer.php";

    ob_end_flush();
        
?>