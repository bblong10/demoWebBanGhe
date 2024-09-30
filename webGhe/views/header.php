<section class="myheader">
        <div class="container py-3">
            <div class="row align-items-center">
                <!-- Logo Section -->
                <div class="col-md-3 d-flex justify-content-center">
                    <img src="../public/images/logo1.png" class="img-fluid" alt="Logo">
                </div>

                <!-- Search Box Section -->
                <div class="col-md-4">
                    <div class="input-group my-3">
                        <input type="text" class="form-control" placeholder="Từ khóa tìm kiếm"
                            aria-label="Từ khóa tìm kiếm" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </div>
                </div>

                <!-- Contact and User Section -->
                <div class="col-md-4">
                    <div class="row">
                        <!-- Phone Support Section -->
                        <div class="col-6 d-flex align-items-center" onclick="showPhoneNumber()"
                            style="cursor: pointer;">
                            <div class="col-3 fs-3 text-danger">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="col-9">
                                <a href="tel:0853482417" id="supportText">Tư Vấn Hỗ Trợ</a><br>
                                <strong id="phoneNumber" class="text-danger" style="display: none;">0853482417</strong>
                            </div>
                        </div>

                        <!-- User Login Section -->
                        <div class="col-6 d-flex align-items-center">
                            <div class="col-3 fs-3 text-danger">
                                <i class="fa-regular fa-circle-user"></i>
                            </div>
                            <div class="col-9">
                                Xin chào<br>
                                <?php if($nameuser != ""){ ?>
                                <a href="/views/admin.php?page=order"
                                    style="text-decoration: none;"><b><?php echo $nameuser; ?></b></a>
                                <?php }else{ ?>
                                <a href="/views/login.php" style="text-decoration: none;"><strong
                                        class="text-danger">Đăng nhập</strong></a>
                                <?php }?>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shopping Bag Section -->
                <div class="col-md-1 d-flex justify-content-center align-items-center">
                    <a href="#" class="position-relative" data-bs-toggle="modal" data-bs-target="#exampleModalCart">
                        <span class="fs-3"><i class="fa-solid fa-bag-shopping"></i></span>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            id="count_card">
                            0
                        </span>
                    </a>
                </div>
            </div>
        </div>

    </section>