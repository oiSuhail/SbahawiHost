<?php
    ob_start();
    session_start();
	$pageTitle = "Admin cp";

    include "LinkFiles.php";

    if(isset($_SESSION['username'])) { 
        if($_SESSION['rank'] == "Member") {
            header("Location: ../Member-CP/index.php");
        } elseif($_SESSION['rank'] == "Support") {
            header("Location: ../Support-CP/index.php");
        }
        
        ?>    
        
        <div class="status">
            <div class="container text-center">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="state members-box">
                            <p class="lead">جميع الأعضاء</p>
                            <span><a href="Members.php"><?php echo countItems("userid", "users"); ?></a></span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="state tickets-box">
                            <p class="lead">جميع التذاكر</p>
                            <span><a href="Tickets.php"><?php echo countItems("ticketid", "tickets"); ?></a></span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="state ticket-pending">
                            <p class="lead">تذاكر مفتوحة</p>
                            <span><a href="#"><?php echo checkItem("replyStatus", "tickets", "مفتوحة") ?></a></span>
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="state servers-box">
                            <p class="lead">جميع السيرفرات</p>
                            <span><a href="#"><?php //  echo countItems("serverid", "servers"); ?>0</a></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="home-table">
                            <p class="lead">آخر التذاكر :</p>
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th scope="col">تاريخ فتحها</th>
                                  <th scope="col">حالتها</th>
                                  <th scope="col">عنوان التذكرة</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                    $getLatest = getLatest("*", "tickets", "ticketid", "5");
        
                                    foreach($getLatest as $Latest) {
                                        echo '<tr>';
                                          echo '<td>' . $Latest['date'] . '</td>';
                                          echo '<td>' . $Latest['replyStatus'] . '</td>';
                                          echo '<td class="ticket-title">' . $Latest['ticketTitle'] . '</td>';
                                        echo '</tr>';
                                    }
                                   ?>
                              </tbody>
                            </table>
                        </div>
                        <a href="Tickets.php"><p class="lead">&#x02A2D; عرض الكل &#x02A2E;</p></a>
                    </div>
                    <div class="col-lg-6">
                        <div class="home-table">
                            <p class="lead">آخر الأعضاء :</p>
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th scope="col">تاريخ تسجيله</th>
                                  <th scope="col">اسم المستخدم</th>
                                  <th scope="col">#</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                    $getLatest = getLatest("*", "users", "userid", "10");
        
                                    foreach($getLatest as $Latest) {
                                        echo '<tr>';
                                          echo '<td>' . $Latest['date'] . '</td>';
                                          echo '<td>' . $Latest['username'] . '</td>';
                                          echo '<th scope="row">' . $Latest['userid'] . '</th>';
                                        echo '</tr>';
                                    }
                                   ?>
                              </tbody>
                            </table>
                        </div>
                        <a href="Members.php"><p class="lead">&#x02A2D; عرض الكل &#x02A2E;</p></a>
                    </div>
                </div>
            </div>
        </div>
        
        
        <?php
        include $tmp . "footer.php";
        
    } else {
        header("Location: ../index.php");
    }
    ob_end_flush();
?>