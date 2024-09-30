    <?php
    session_start();
    // $_SESSION = array();
    // Kiểm tra nếu giỏ hàng đã được tạo
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    $check = 0;
    $nameuser = "";
    if (isset($_SESSION["userid"]) && isset($_SESSION["username"])) {
        $check = 1;
        $nameuser = $_SESSION["username"];
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DuyLongShop</title>
        <link rel="stylesheet" href="../public/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="../public/css/style.css?v=1.0.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <style>

        </style>


    </head>

    <body>
        <?php
        include('../views/header.php');
        ?>
        <section class="mymainmenu bg-danger">
            <div class="container">
                <div class="row">
                    <div class="col-md">
                        <nav class="navbar navbar-expand-lg bg-danger">
                            <div class="container-fluid">
                                <a class="navbar-brand d-none" href="#">Navbar</a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                        <li class="nav-item">
                                            <a class="nav-link text-white active" aria-current="page" href="index.php">Trang chủ</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <div class="dropdown">
                                                <a class="nav-link dropdown-toggle text-white" id="categoryMenu" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Sản phẩm
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="categoryMenu">
                                                    <!-- Dropdown items will be inserted here -->
                                                </ul>
                                            </div>


                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-white" href="tintuc.php">Tin tức</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-white" href="chinhsach.php">Chính sách bảo hành</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-white" href="lienhe.php">Liên hệ</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <?php
        include('../views/banner.php');
        ?>

        <div class="container">
            <div class="row" id="listproduct">
            </div>
        </div>
        <div class="container" id="listcategory">

        </div>
        <!-- Cart Modal -->
        <div class="modal fade" id="exampleModalCart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Giỏ hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="cart-content"></div>
                        <!-- Customer Information Section -->
                        <div class="mt-4">
                            <h5>Thông tin khách hàng</h5>
                            <form id="customer-info-form">
                                <div class="mb-3">
                                    <label for="customer-name" class="form-label">Tên khách hàng</label>
                                    <input type="text" class="form-control" id="customer-name"
                                        placeholder="Nhập tên của bạn" required>
                                </div>
                                <div class="mb-3">
                                    <label for="customer-address" class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control" id="customer-address"
                                        placeholder="Nhập địa chỉ của bạn" required>
                                </div>
                                <div class="mb-3">
                                    <label for="customer-phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="customer-phone"
                                        placeholder="Nhập số điện thoại của bạn" required>
                                </div>
                                <div class="mb-3">
                                    <label for="customer-notes" class="form-label">Ghi chú</label>
                                    <textarea class="form-control" id="customer-notes" rows="3"
                                        placeholder="Ghi chú thêm"></textarea>
                                </div>
                            </form>
                        </div>
                        <div id="check_login">
                            <?php if ($check == 1) { ?>
                            <?php } else { ?>
                                <p>Vui lòng đăng nhập để gửi đơn hàng</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" onclick="submitOrder()">Gửi đơn hàng</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="../public/js/jquery-3.7.1.min.js"></script>
        <script src="../public/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function loadCategoryMenu() {
                $.ajax({
                    url: '/views/admin/controller/products.php',
                    type: 'POST',
                    data: {
                        action: 'getcategory'
                    },
                    dataType: 'json',
                    success: function(categories) {
                        var menuHtml = '';
                        var firstCategoryId = null;



                        $.each(categories, function(index, category) {
                            if (firstCategoryId === null) {
                                firstCategoryId = category.category_id; // Set the first category ID
                            }

                            menuHtml += `<li><a class="dropdown-item" href="#" onclick="loadProducts(${category.category_id});return false; ">
                    ${category.category_name}
                </a></li>`;
                        });

                        $('.dropdown-menu').html(menuHtml); // Ensure #categoryMenu exists in your HTML

                        if (firstCategoryId !== null) {
                            loadProducts(firstCategoryId);
                        }
                    },
                    error: function() {
                        console.error("Error loading categories.");
                    }
                });

            }

            function loadProducts(category_id) {
                console.log("Loading products for category:", category_id);
                $.ajax({
                    url: '/views/admin/controller/products.php',
                    type: 'POST',
                    data: {
                        action: 'get',
                        category_id: category_id // Gửi category_id tới server
                    },
                    dataType: 'json',
                    success: function(data) {
                        var html = '';

                        $.each(data, function(index, product) { // Sửa lỗi đóng ngoặc tại đây
                            var price = Number(product.price).toLocaleString('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });

                            html += `<div class="col-md-3">
                            <div class="card">
                                <img src="/public/images/${product.image}" alt="${product.name}" class="card-img-top rounded-0">
                                <h4 class="card-title m-2">${product.name}</h4>
                                <div class="d-flex justify-content-between px-2">
                                    <h6>${price} VND</h6>
                                    <a href="#" onclick="addtocard(${product.id})" title="Thêm vào giỏ hàng">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-bag-dash" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M5.5 10a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5" />
                                            <path
                                                d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                                        </svg>
                                    </a>


                                    </div>
                                </div>
                            </div>`;
                        });

                        $('#listproduct').html(html); // Đảm bảo phần tử này tồn tại trong HTML



                    },
                    error: function() {

                    }
                });
            }


            function loadCategory() {
                $.ajax({
                    url: '/views/admin/controller/products.php',
                    type: 'POST',
                    data: {
                        action: 'getcategory'
                    },
                    dataType: 'json',
                    success: function(categories) {
                        var html = '';

                        // Iterate over each category and fetch products for each category
                        $.each(categories, function(index, category) {
                            html += `<div class="card">
                                <div class="card-title title_category">${category.category_name}</div>
                                <div class="card-body">
                                    <div class="row" id="category_${category.category_id}"></div>
                                </div>
                            </div>`;

                            // Fetch products for each category
                            loadProductsnew(category.category_id);
                        });
                        $('#listcategory').html(html); // Update the HTML structure with the categories
                        
                    },
                    error: function() {
                        console.error("Error loading categories.");
                    }
                });
            }

            function loadProductsnew(categoryId) {
                $.ajax({
                    url: '/views/admin/controller/products.php',
                    type: 'POST',
                    data: {
                        action: 'getproductwithcategory',
                        categoryid: categoryId
                    },
                    dataType: 'json',
                    success: function(products) {
                        var productHtml = '';
                        $.each(products, function(index, product) {
                            var price = Number(product.price).toLocaleString('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });

                            productHtml += `<div class="col-md-3">
                                        <div class="card">
                                            <img src="/public/images/${product.image}" alt="${product.name}" class="card-img-top rounded-0">
                                            <h4 class="card-title m-2">${product.name}</h4>
                                            <div class="d-flex justify-content-between px-2">
                                                <h6>${price} VND</h6>
                                                <a href="#" onclick="addtocard(${product.id})" title="Thêm vào giỏ hàng">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                        class="bi bi-bag-dash" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M5.5 10a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5" />
                                                        <path
                                                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>`;
                        });

                        // Append the products to the respective category's row
                        $(`#category_${categoryId}`).html(productHtml);
                    },
                    error: function() {}
                });
            }

            $('#exampleModalCart').on('show.bs.modal', function(e) {
                showCart();
            });

            function submitOrder() {
                // Collect customer information
                const customerName = $('#customer-name').val();
                const customerAddress = $('#customer-address').val();
                const customerPhone = $('#customer-phone').val();
                const customerNotes = $('#customer-notes').val();

                if (!customerName || !customerAddress || !customerPhone) {
                    Swal.fire({
                        title: 'Vui lòng điền đầy đủ thông tin!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Prepare order data
                const orderData = {
                    name: customerName,
                    address: customerAddress,
                    phone: customerPhone,
                    notes: customerNotes
                };

                // Send order data to the server
                $.ajax({
                    url: '/controller/submitorder.php', // Adjust the URL to your actual endpoint
                    type: 'POST',
                    data: orderData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Đơn hàng đã được gửi thành công!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Optional: Clear the form fields
                                $('#customer-info-form')[0].reset();
                                // Optionally, close the modal
                                $('#exampleModalCart').modal('hide');
                            });
                        } else {
                            Swal.fire({
                                title: 'Gửi đơn hàng thất bại!',
                                text: response.message || '',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Lỗi khi gửi đơn hàng!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }

            function showCart() {
                $.ajax({
                    url: '/controller/getcart.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        html += `<table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tên sản phẩm</th>
                                        <th scope="col">Hình ảnh</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Đơn giá</th>
                                        <th scope="col">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>`;
                        if (data.length > 0) {
                            $i = 1;
                            var total = 0;
                            $.each(data, function(index, item) {
                                var price = Number(item.price).toLocaleString('en-US', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                                var thanhtien = (Number(item.price) * Number(item.quantity));
                                total += thanhtien;
                                var thanhtienfix = Number(thanhtien).toLocaleString('en-US', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                                html += `
                                    <tr>
                                        <th scope="row">` + $i + `</th>
                                        <td>${item.name}</td>
                                        <td><img src="/public/images/${item.image}" alt="${item.name}" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover;"></td>
                                        <td>
                                        <button class="btn btn-sm btn-danger" onclick="changeQuantity(${item.id}, -1)">-</button>
                                        ${item.quantity}
                                        <button class="btn btn-sm btn-success" onclick="changeQuantity(${item.id}, 1)">+</button>
                                    </td>
                                        <td>${price} VND</td>
                                        <td>` + thanhtienfix + ` VND</td>
                                    </tr>`;
                                $i++;
                            });
                            html += `  </tbody></table>`;
                            var totalfix = total.toLocaleString('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                            html +=
                                `<p style="text-align: right;font-weight: bold">Tổng: <span class="text-danger">` +
                                totalfix + ` VND </span></p>`
                        } else {
                            html =
                                `<h4>Chưa có sản phẩm nào trong giỏ hàng <i class="fa-regular fa-face-sad-tear"></i></h4>`
                        }
                        $('#cart-content').html(html);
                    },
                    error: function() {
                        $('#cart-content').html('Error loading cart.');
                    }
                });
            }

            function changeQuantity(id, delta) {
                $.ajax({
                    url: '/controller/changequantity.php',
                    type: 'POST',
                    data: {
                        id: id,
                        quantity: delta
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            showCart();
                            updateCartCount();
                        } else {
                            Swal.fire({
                                title: 'Lỗi khi thay đổi số lượng!',
                                text: "",
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Lỗi kết nối!',
                            text: "",
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }


            function addtocard(id) {
                $.ajax({
                    url: '/controller/addtocart.php',
                    type: 'POST',
                    data: {
                        id: id,
                        quantity: 1
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Thêm giỏ hàng thành công!',
                                text: "",
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });

                        } else {
                            Swal.fire({
                                title: 'Thêm giỏ hàng bị lỗi!',
                                text: "",
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                        updateCartCount();
                    },
                    error: function() {}
                });
            }

            function updateCartCount() {
                $.ajax({
                    url: '/controller/countcart.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.count !== undefined) {
                            $('#count_card').text(response.count);
                        }
                    },
                    error: function() {
                        $('#count_card').text('Error'); // Thay đổi theo nhu cầu của bạn
                    }
                });
            }
            $(document).ready(function() {
                // loadCategory();
                updateCartCount();
                loadCategoryMenu();

            })
        </script>
        <?php
        include('../views/footer.php');
        ?>
    </body>

    </html>