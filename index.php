<?php

    session_start();

    $pageTitle = "Home";

    include "LinkFiles.php";

?>

<!-- start carousel -->

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="http://www.petrodata.net/img/Server-Room-2.jpg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS1YgDdP9T-C1oWzJkeLPJ8CItcVRjMrKQeQtxH3dYz19YmUEz-" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRFqo3vgYNCCf4P1kaLjsaXWhJ8Tkze6lPqm5xQikD1Q7SpSkk8" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<!-- end carousel -->


<!-- start about -->

<div class="about">
    <div class="container text-center">
        <h3>
            استضافة اس بي هوست
        </h3>
        <p class="lead">
            نسعى نحن استضافة اس بي هوست لتقديم افضل العروض للإستضافات وبافضل الاسعار وبآداء رائع وسريع
        </p>
    </div>
</div>

<!-- end about -->


<!-- start Features -->

<div class="features">
    <div class="container text-center">
        <h3>المميزات</h3>
        <div class="row">
            <div class="col-lg-3">
                <div class="fea-item">
                    <i class="fas fa-comments fa-5x"></i>
                    <h5>مساعدة فورية</h5>
                    <p class="lead">
                        نملك فريق عمل لمساعدتك في أقرب وقت
                    </p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="fea-item">
                    <i class="fas fa-cogs fa-5x"></i>
                    <h5>لوحة تحكم</h5>
                    <p class="lead">
                        نقدم لك لوحة تحكم سهلة الاستخدام ومتعددة الخصائص
                    </p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="fea-iteem">
                    <i class="fas fa-server fa-5x"></i>
                    <h5>سرعة الاستضافة</h5>
                    <p class="lead">
                        نملك افضل انواع الخوادم والسيرفرات
                    </p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="fea-item">
                    <i class="fas fa-shopping-cart  fa-5x"></i>
                    <h5>شراء الاستضافة</h5>
                    <p class="lead">
                        لدينا عدة وسائل للدفع وطريقة الشراء سهلة
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end Features -->


<!-- start goto -->

<div class="goto">
    <div class="container text-center">
        <i class="fas fa-chevron-circle-down fa-5x"></i>
        <div class="row">
            <div class="col-lg-12">
                <div class="goto-item">
                    <h3>الاستضافات</h3>
                    <i class="fas fa-sort-down fa-3x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end goto -->


<!-- start websites offers -->

<div class="wb-offers">
    <div class="container text-center">
        <p class="lead">استضافات المواقع</p>
        <div class="row">
            <div class="col-lg-4">
                <div class="offer-item">
                    استضافة 1
                </div>
            </div>
            <div class="col-lg-4">
                <div class="offer-item">
                    استضافة 2
                </div>
            </div>
            <div class="col-lg-4">
                <div class="offer-item">
                    استضافة 3
                </div>
            </div>
            <div class="col-lg-4">
                <div class="offer-item">
                    استضافة 4
                </div>
            </div>
            <div class="col-lg-4">
                <div class="offer-item">
                    استضافة 5
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end websites offers -->


<!-- footer -->

<?php include $tmp . "footer.php"; ?>


