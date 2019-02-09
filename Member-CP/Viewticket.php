<?php
    ob_start();
	session_start();

	$pageTitle = "Tickets";

	if (isset($_SESSION['username'])) {
        
		include 'LinkFiles.php';

    	$ticketid = isset($_GET['tid']) && is_numeric($_GET['tid']) ? intval($_GET['tid']) : 0;
        
        $stmt = $con->prepare("SELECT ticketid FROM tickets WHERE tickets.ticketid = ? AND tickets.userid = ?");
        $stmt->execute(array($ticketid,$_SESSION['userid']));
        $rows = $stmt->rowCount();
        
        if ($rows > 0) {
        
            $stmt = $con->prepare("SELECT ticketTitle,tickets.Date,ticketDescribe,priorityLevel,ticketSection,replyStatus,username FROM tickets,users WHERE tickets.ticketid = ? AND tickets.userid = users.userid");
            $stmt->execute(array($ticketid));
            $rows = $stmt->fetchAll();


            $check = checkItem("ticketid", "tickets", $ticketid);

            if($check > 0) {
            ?>

                <div class="ViewTicket">
                    <div class="container text-right">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="info-list">
                                    <div class="info-header"><p class="lead">معلومات التذكرة :</p></div>
                                    <div class="info-body">
                                        <ul class="list-unstyled">
                                            <?php foreach ($rows as $row) { ?>
                                            <li>
                                                <span>أهمية التذكرة :</span>
                                                <br>
                                                <p class="lead"><?php echo $row['priorityLevel'] ?></p>
                                            </li>
                                            <li>
                                                <span>قسم التذكرة :</span>
                                                <br>
                                                <p class="lead"><?php echo $row['ticketSection'] ?></p>
                                            </li>
                                            <li>
                                                <span>حالة التذكرة :</span>
                                                <br>
                                                <p class="lead"><?php echo $row['replyStatus'] ?></p>
                                            </li>
                                            <li>
                                                <span>تاريخ التذكرة :</span>
                                                <br>
                                                <p class="lead"><?php echo $row['Date'] ?></p>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                            <div class="Close-tag" style="
                                                    <?php if ($row['replyStatus'] == "مفتوحة") { echo "background-color: #5cb85c"; } 
                                                          elseif ($row['replyStatus'] == "مغلقة") { echo "background-color: #e65864"; }
                                                    ?>">
                            <?php foreach ($rows as $row) { echo $row['replyStatus']; } ?>
                            </div>
                                <h1 class="ViewTicketHeader">عرض التذكرة</h1>
                                <div class="ViewTicketBody">
                                    <div class="ViewTicketBodyDes">
                                    <p class="lead">عنوان التذكرة :</p>
                                    <?php 
                                    foreach($rows as $row) {
                                        echo '<h4>' . $row['ticketTitle'] . '</h4>';
                                    ?>
                                    <p class="lead">وصف التذكرة :</p>
                                        <?php
                                            echo '<div class="ticketDescribe">';
                                                echo '<div class="ticketDescribeInfo">';
                                                    echo '<p>اسم المستخدم : ' . $row['username'] . '</p>';
                                                    echo '<p>نشر بتاريخ : ' . $row['Date'] . '</p>';
                                                echo '</div>';
                                                echo '<div class="ticketDescribeBody">';
                                                    echo '<p class="lead">' . $row['ticketDescribe'] . '</p>';
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                    ?>
                                    </div>
                                    <p class="lead">الردود :</p>
                                    <?php 

                                    $stmt = $con->prepare("SELECT username,commentDate,commentDescribe FROM users,ticketcomments WHERE users.userid = ticketcomments.userid AND ticketcomments.ticketid = ?");
                                    $stmt->execute(array($ticketid));
                                    $rows = $stmt->fetchAll();

                                        foreach($rows as $row) {
                                            echo '<div class="CommentDescribe">';
                                                echo '<div class="ticketCommentInfo">';
                                                    echo '<p>اسم المستخدم : ' . $row['username'] . '</p>';
                                                    echo '<p>نشر بتاريخ : ' . $row['commentDate'] . '</p>';
                                                echo '</div>';
                                                echo '<div class="ticketCommentBody">';
                                                    echo '<p class="lead">' . $row['commentDescribe'] . '</p>';
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                    ?>
                                    <br>
                                    <button class="btn btn-primary add-comment-btn" type="button" data-toggle="collapse" data-target="#addCommentBody" aria-expanded="false" aria-controls="addCommentBody">إضافة رد <i class="far fa-plus-square fa-1x"></i></button>
                                    <div class="collapse multi-collapse" id="addCommentBody">
                                        <div class="card card-body addComment">
                                        <?php 
            
                                        $stmt = $con->prepare("SELECT replyStatus FROM tickets,users WHERE tickets.ticketid = ? AND tickets.userid = users.userid");
                                        $stmt->execute(array($ticketid));
                                        $rows = $stmt->fetchAll();
                                        foreach ($rows as $row) {
                                            if ($row['replyStatus'] == "مفتوحة") {
                                                    echo '<form action="viewticket.php?do=Add&tid=' . $ticketid . '&uid=' . $_SESSION['userid'] . '" method="post">';
                                                        echo '<textarea class="form-control" name="comment" rows="6" placeholder="أكتب الرد هنا"></textarea>';
                                                        echo '<input type="submit" class="btn btn-success" value="أرسل">';
                                                        echo '<input type="file" class="form-control-file" name="file">';
                                                    echo '</form>';
                                                  } elseif ($row['replyStatus'] == "مغلقة") {
                                                echo "<div class='alert alert-danger'>التذكرة مغلقة</div>";
                                            }
                                        }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            <?php
                    $do = isset($_GET['do']) ? $_GET['do'] : "Manage";

                    if ($do == "Add") {
                        $ticketid = isset($_GET['tid']) && is_numeric($_GET['tid']) ? intval($_GET['tid']) : 0;

                        $stmt = $con->prepare("SELECT replyStatus FROM tickets,users WHERE tickets.ticketid = ? AND tickets.userid = users.userid");
                        $stmt->execute(array($ticketid));
                        $rows = $stmt->fetchAll();

                        foreach ($rows as $row) {
                        if ($row['replyStatus'] == "مفتوحة") {
                        
                        $comment = $_POST['comment'];
                        $file = $_POST['file'];

                        $formErrors = array();

                        if (strlen($comment) <= 35) {
                            $formErrors[] = "نص الرد لا يمكن أن يكون أقل من 35 حرف";
                        }

                        if (strlen($comment) >= 950) {
                            $formErrors[] = "نص الرد لا يمكن أن يكون أكثر من 950 حرف";
                        }

                        if (empty($comment)) {
                            $formErrors[] = "لا يمكن أن تترك خانة الرد فارغة";
                        }

                        foreach ($formErrors as $error) {
                            echo "<div class='container'>";
                                echo "<div class='alert alert-danger'>" . $error . "</div>";
                            echo "</div>";
                        }

                        if (empty($formErrors)) {                

                            // insert into database
                                $stmt = $con->prepare("INSERT INTO 
                                                                ticketcomments(commentDescribe, commentDate, ticketid, userid) 
                                                                VALUES(:comment, now(), :ticketid, :userid) ");

                                $stmt->execute(array (
                                    'comment' => $comment,
                                    'ticketid' => $ticketid,
                                    'userid' => $_SESSION['userid']
                                ));

                                header("Location: Viewticket.php?tid=$ticketid");
                    }
                    } elseif ($row['replyStatus'] == "مغلقة") {
                        
                        $theMsg = "<div class='alert alert-danger'>التذكرة مغلقة</div>";

                        echo "<div class='container'>";

                        redirectHome($theMsg);

                        echo "</div>";

                    }
                    }
                    }
            } else {

                    $theMsg = "<div class='alert alert-warning'>هذه التذكرة غير موجودة</div>";

                    echo "<div class='container'>";

                    redirectHome($theMsg);

                    echo "</div>";

            }
            include $tmp . "footer.php";
        } else {
                    $theMsg = "<div class='alert alert-warning'>لا تملك الصلاحية لعرض تذاكر لأشخاص آخرين</div>";

                    echo "<div class='container'>";

                    redirectHome($theMsg);

                    echo "</div>";
        }
	} else {

		header("Location: ../index.php");

		exit();
	}

    ob_end_flush();
?>