
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">
        <img src="includes/images/s-logo.png" style="width: 35px; hight: 35px;">
        SbHost
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php 
        if(!isset($_SESSION['username'])) {
            echo '<ul class="navbar-nav mr-auto">';
                    echo '<form class="form-inline">';
                        echo '<a href="SignUp.php"><button class="btn btn-success navbar-btn" type="button">تسجيل</button></a>';
                        echo '<a href="Login.php"><button class="btn btn-outline-success navbar-btn" type="button">تسجيل دخول</button></a>';
                    echo '</form>';
            echo '</ul>';
            
        }elseif(isset($_SESSION['username'])) {
            echo '<ul class="navbar-nav">';
                echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link dropdown-toggle user-name lead" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$_SESSION['username'].'</a>';
                    echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
                        echo '<a class="dropdown-item" href="#">تعديل بيانات الحساب</a>';
                        echo '<div class="dropdown-divider"></div>';
                        echo '<a class="dropdown-item" href="Logout.php">تسجيل الخروج</a>';
                    echo '</div>';
                echo '</li>';
            echo '</ul>';
        }

        ?>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="Member-CP/Tickets.php?do=Add">افتح تذكرة</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php 
                                          
                                          if(isset($_SESSION['username']) && $_SESSION['rank'] == "Member") {
                                              echo "Member-CP/index.php";
                                          } elseif(isset($_SESSION['username']) && $_SESSION['rank'] == "Support") {
                                              echo "Support-CP/index.php";
                                          } elseif(isset($_SESSION['username']) && $_SESSION['rank'] == "Admin") {
                                              echo "Admin-CP/index.php";
                                          } else {
                                              echo "Login.php";
                                          }
                                          
                                          ?>">منطقة العملاء</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="index.php">الرئيسية <span class="sr-only">(current)</span></a>
            </li>
            <div class="navbar-Line"></div>
        </ul>
    </div>
</nav>