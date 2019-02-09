<?php
    ob_start();
    session_start();
	$pageTitle = "Member cp";

    include "LinkFiles.php";

    if(isset($_SESSION['username'])) { 
        
        ?>    
        
        <div class="status">
            <div class="container text-center">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="state members-box">
                            <p class="lead">جميع فواتيرك</p>
                            <span><a href="#"><?php // echo countItems("billid", "bills"); ?>0</a></span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="state ticket-pending">
                            <p class="lead">تذاكر مفتوحة</p>
                            <span><a href="#"><?php echo checkItemTicket("*", "tickets", "userid", $_SESSION['userid'], "replyStatus", "مفتوح"); ?></a></span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="state tickets-box">
                            <p class="lead">جميع تذاكرك</p>
                            <span><a href="Tickets.php"><?php echo checkItem("userid", "tickets", $_SESSION['userid']); ?></a></span>
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="state servers-box">
                            <p class="lead">جميع سيرفراتك</p>
                            <span><a href="#"><?php //  echo countItems("serverid", "servers"); ?>0</a></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="home-table">
                            <p class="lead">السيرفرات :</p>
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th scope="col">المتبقي عليه</th>
                                  <th scope="col">تاريخ فتحه</th>
                                  <th scope="col">المتواجدون فيه</th>
                                  <th scope="col">اي بي السيرفر</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php /*
                                    $getLatest = getLatest("*", "servers", "userid", "100");
        
                                    foreach($getLatest as $Latest) {
                                        echo '<tr>';
                                          echo '<td>' . $Latest['date'] . '</td>';
                                          echo '<td>' . $Latest['username'] . '</td>';
                                          echo '<th scope="row">' . $Latest['userid'] . '</th>';
                                        echo '</tr>';
                                    } 
                                    */
                                   ?>
                              </tbody>
                            </table>
                            <a href="#"><p class="lead">&#x02A2D; عرض الكل &#x02A2E;</p></a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="home-table">
                            <p class="lead">آخر التذاكر</p>
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
                                    $getLatest = getLatest("*", "tickets", "userid", $_SESSION['userid'], "userid", "5");
        
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
                            <a href="Tickets.php"><p class="lead">&#x02A2D; عرض الكل &#x02A2E;</p></a>
                        </div>
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