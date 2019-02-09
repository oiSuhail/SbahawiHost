<?php
    ob_start();
	session_start();

	$pageTitle = "Tickets";

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
                <p class="lead">جميع التذاكر :</p>
                <div class="ticket-table">
                    <table class="table table-striped ticket-table">
                      <thead>
                        <tr>
                          <th scope="col"><i class="fas fa-cogs"></i></th>
                          <th scope="col">تاريخ فتحها</th>
                          <th scope="col">حالتها</th>
                          <th scope="col">الأهمية</th>
                          <th scope="col">القسم</th>
                          <th scope="col">اسم المستخدم</th>
                          <th scope="col">عنوان التذكرة</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php          
                            $stmt = $con->prepare("SELECT * FROM tickets,users WHERE tickets.userid = users.userid");
                            $stmt->execute();
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
                                  echo '<td>' . $row['username'] . '</td>';
                                  echo '<td class="ticket-title">' . $row['ticketTitle'] . '</td>';
                                echo '</tr>';
                            }
                           ?>
                      </tbody>
                    </table>
                </div>
            </div>

<?php
		} elseif ($do == "Edit") {


		} elseif ($do == "Update") {


		} elseif ($do == "Close") {
            
        	$ticketid = isset($_GET['tid']) && is_numeric($_GET['tid']) ? intval($_GET['tid']) : 0;

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

	}

		include $tmp . "footer.php";

	} else {

		header("Location: ../index.php");

		exit();
	}

    ob_end_flush();
?>