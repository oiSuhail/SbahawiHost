<?php
    ob_start();
	session_start();

	$pageTitle = "Tickets";

	if (isset($_SESSION['username'])) {

		include 'LinkFiles.php';

		$do = isset($_GET['do']) ? $_GET['do'] : "Manage";

		if ($do == "Manage") {
?>
            <div class="container text-center">
                <div class="tickets-table">
                    <p class="lead">تذاكرك :</p>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col"><i class="fas fa-cogs"></i></th>
                          <th scope="col">تاريخ فتحها</th>
                          <th scope="col">حالتها</th>
                          <th scope="col">الأهمية</th>
                          <th scope="col">القسم</th>
                          <th scope="col">عنوان التذكرة</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php          
                            $stmt = $con->prepare("SELECT * FROM tickets WHERE userid = ?");
                            $stmt->execute(array($_SESSION['userid']));
                            $rows = $stmt->fetchAll();

                            foreach($rows as $row) {
                                echo '<tr>';
                                  echo '<td>';
                                      echo '<a href="Tickets.php?do=Close&tid='. $row['ticketid'] . '" class="btn btn-danger tickets-btn ';
                                      echo ($row['replyStatus'] == "مغلقة") ? "disabled" : '';
                                      echo'">';
                                          echo ($row['replyStatus'] == "مغلقة") ? "مغلقة" : "إغلاق";
                                      echo '</a>';
                                      echo '<a href="#" class="btn btn-primary tickets-btn">تعديل</a>';
                                      echo '<a href="Viewticket.php?tid='. $row['ticketid'] . '" class="btn btn-success tickets-btn">عرض</a>';
                                  echo '</td>';
                                  echo '<td>' . $row['date'] . '</td>';
                                  echo '<td>' . $row['replyStatus'] . '</td>';
                                  echo '<td>' . $row['priorityLevel'] . '</td>';
                                  echo '<td>' . $row['ticketSection'] . '</td>';
                                  echo '<td class="ticket-title">' . $row['ticketTitle'] . '</td>';
                                echo '</tr>';
                            }
                           ?>
                      </tbody>
                    </table>
                </div>
            </div>

<?php
		} elseif ($do == "Add") {
            ?>

            <div class="addForm">
                <div class="container">
                    <h1>فتح تذكرة</h1>
                    <br>
                    <form action="?do=Insert" method="POST">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="ticketSection">القسم</label>
                                <select class="form-control" name="ticketSection" id="ticketSection">
                                    <option selected="selected">المبيعات والاستفسارات</option>
                                    <option>سيرفرات ماينكرافت</option>
                                    <option>سيرفرات ماينكرافت مودباك</option>
                                    <option>سيرفرات آرك سيرفايفل</option>
                                    <option>غير محدد</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="priorityLevel">الأهمية</label>
                                <select class="form-control" name="priorityLevel" id="priorityLevel">
                                    <option>عالية</option>
                                    <option selected="selected">متوسطة</option>
                                    <option>عادية</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <br>
                                <label for="ticketTitle">عنوان التذكرة</label>
                                <input class="form-control" name="ticketTitle" type="text" id="ticketTitle">
                            </div>
                            <div class="col-lg-12">
                                <br>
                                <label for="text">نص التذكرة</label>
                                <textarea class="form-control" name="ticketText" rows="6" id="ticketText"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <br>
                                <input type="submit" value="ارسال" class="btn btn-default">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            
		} elseif ($do == "Insert") {

        if($_SERVER['REQUEST_METHOD'] == "POST") {

			// get the vars 

			$ticketSection = $_POST['ticketSection'];
            $priorityLevel = $_POST['priorityLevel'];
			$ticketTitle = $_POST['ticketTitle'];
			$ticketText = $_POST['ticketText'];

            
			// validate the form

			$formErrors = array();

			if (strlen($ticketTitle) <= 8) {
				$formErrors[] = "عنوان التذكرة لا يمكن ان يكون اقل من 8 احرف";
			}

			if (strlen($ticketTitle) >= 55) {
				$formErrors[] = "عنوان التذكرة لا يمكن أن يكون اكثر من 55 حرف";
			}

            if (strlen($ticketText) <= 35) {
                $formErrors[] = "نص التذكرة لا يمكن أن يكون أقل من 35 حرف";
            }
            
            if (strlen($ticketText) >= 950) {
                $formErrors[] = "نص التذكرة لا يمكن أن يكون أكثر من 950 حرف";
            }
            
			if (empty($ticketTitle)) {
				$formErrors[] = "لا يمكن أن تترك العنوان فارغََا";
			}
            
			if (empty($ticketText)) {
				$formErrors[] = "لا يمكن أن تترك النص فارغََا";
			}

			foreach ($formErrors as $error) {
                echo "<div class='container'>";
                    echo "<div class='alert alert-danger'>" . $error . "</div>";
                echo "</div>";
			}

			if (empty($formErrors)) {                

				// insert into database
	                $stmt = $con->prepare("INSERT INTO 
	                								tickets(ticketTitle, ticketDescribe, priorityLevel, ticketSection, replyStatus, date, userid) 
	                                       			VALUES(:Title, :Describe, :Priority, :Section, :replay, now(), :userid) ");
	                
	                $stmt->execute(array (
	                    'Title' => $ticketTitle,
	                    'Describe' => $ticketText,
	                    'Priority' => $priorityLevel,
                        'Section' => $ticketSection,
	                    'userid' => $_SESSION['userid'],
                        'replay' => "مفتوحة"
	                ));
	                
                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " عملية ادخلت" . "</div>";

                        redirectHome($theMsg, "back");


		}

		} else {            

			$theMsg = "<div class='alert alert-danger'>عذرََا لا يمكن دخول هذه الصفحة</div>";

            redirectHome($theMsg, "back");

		}
		echo "</div>";
        
        
        
		} elseif ($do == "Edit") {


		} elseif ($do == "Close") {
            
            $ticketid = isset($_GET['tid']) && is_numeric($_GET['tid']) ? intval($_GET['tid']) : 0;
            
            $stmt = $con->prepare("SELECT ticketid FROM tickets WHERE tickets.ticketid = ? AND tickets.userid = ?");
            $stmt->execute(array($ticketid,$_SESSION['userid']));
            $rows = $stmt->rowCount();

            if ($rows > 0) {
            
            $check = checkItem("ticketid", "tickets", $ticketid);
            
            if($_SERVER['REQUEST_METHOD'] == "GET") {
            
            if ($check > 0) {

                $stmt = $con->prepare("UPDATE tickets SET replyStatus = 'مغلقة' WHERE ticketid = ?");            
                $stmt->execute(array($ticketid));

                $theMsg = "<div class='alert alert-success'>تم الإغلاق</div>";

                echo "<div class='container'>";

                redirectHome($theMsg, "back");

                echo "</div>";


            } else {

                $theMsg = "<div class='alert alert-warning'>هذا المعرف غير موجود</div>";

                echo "<div class='container'>";

                redirectHome($theMsg);

                echo "</div>";

            }  
        }

	} else {
                    $theMsg = "<div class='alert alert-warning'>لا تملك الصلاحية لإغلاق تذاكر أشخاص آخرين</div>";

                    echo "<div class='container'>";

                    redirectHome($theMsg);

                    echo "</div>";
            }

		include $tmp . "footer.php";
        }
	} else {

		header("Location: ../Login.php");

		exit();
	}

    ob_end_flush();
?>