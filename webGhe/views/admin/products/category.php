   
   <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>List Categories</title>
        <style>
            .btn-link {
                text-decoration: none !important;
            }

            .btn-link:hover {
                text-decoration: underline !important;
            }

            .float-right {
                float: right !important;
            }
        </style>
    </head>

    <body>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Danh sách danh mục sản phẩm</h1>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="float-left">
                                Danh mục
                            </h2>
                            <div class="float-right">

                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createProductModal">
                                    Thêm danh mục sản phẩm
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive card-body">
                            <table class="table table-info table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>Hình ảnh</th>
                                        <th>Mô tả</th>
                                        <th>Xóa/ Sửa</th>
                                    </tr>
                                </thead>
                                <tbody id="categories">
                                    <tr>
                                        <td colspan="5">Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Modal create -->
        <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProductModalLabel">Tạo danh mục sản phẩm</h5>
                        <button type="button" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formtaomoi">
                            <div class="form-group input-group mb-3">
                                <input class="form-control border rounded" type="text" id="category_name" required placeholder="Tên danh mục sản phẩm">
                            </div>
                            <div class="form-group input-group mb-3">
                                <input class="form-control" type="file" name="image" id="category_img">
                            </div>
                            <div class="form-group input-group mb-3">
                                <textarea class="form-control" type="text" id="category_description" required placeholder="Mô tả danh mục sản phẩm" rows="3"></textarea>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button id="create_button" class="btn btn-success" data-bs-dismiss="modal">Thêm danh mục sản phẩm</button>
                        
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal edit -->
        <div class="modal fade" id="exampleModal" tabindex="-2" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="titleEdit"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="" id="category_id_edit">
                        <div class="form-group input-group mb-3">
                            <input class="form-control border rounded" type="text" id="category_name_edit" required placeholder="Tên danh mục sản phẩm">
                        </div>
                        <div class="form-group input-group mb-3">
                            <input class="form-control" type="file" name="image" id="category_img_edit">
                        </div>
                        <div class="form-group input-group mb-3">
                            <textarea class="form-control" type="text" id="category_description_edit" required placeholder="Mô tả danh mục sản phẩm" style="min-height:200px;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" id="edit_button">Lưu dữ liệu</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function editForm(id) {
                $.ajax({
                    url: '/views/admin/controller/products.php',
                    type: 'POST',
                    data: {
                        action: 'getdatacategory',
                        id: id
                    },
                    success: function(response) {
                        console.log(response);
                        if (response != null) {
                            $("#titleEdit").html("Chỉnh sửa danh mục sản phẩm: " + response.category_name);
                            document.getElementById("category_name_edit").value = response.category_name;
                            document.getElementById("category_description_edit").value = response.category_description;
                            document.getElementById("category_id_edit").value = response.category_id;
                            $("#exampleModal").modal("show");
                        } else {
                            alert('Error deleting category');
                        }
                    }
                });
            }
            $('#edit_button').click(function() {
                // Create a FormData object
                var formData = new FormData();

                // Get form values
                var id = $('#category_id_edit').val();
                var name = $('#category_name_edit').val(); // Assuming you have an input with id 'name_input' for name
                var description = $('#category_description_edit').val(); // Assuming you have an input with id 'description_input' for description
                var image = $('#category_img_edit')[0].files[0]; // Get the selected file
                // Append values to the FormData object
                formData.append('action', 'editcategory');
                formData.append('id', id);
                formData.append('name', name);
                formData.append('description', description);
                formData.append('image', image); // Append the file

                // Send AJAX request
                $.ajax({
                    url: '/views/admin/controller/products.php',
                    type: 'POST',
                    data: formData,

                    processData: false, // Important: Do not process the data
                    contentType: false, // Important: Do not set content type
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Chỉnh sửa thành công",
                                text: "",
                                icon: "success"
                            });
                            $("#exampleModal").modal("hide");
                            loadCategories();
                        } else {
                            alert('Error editing category');
                        }
                    },
                    error: function() {
                        alert('An error occurred while processing the request.');
                    }
                });
            });
            $('#create_button').click(function() {
                // Create a FormData object
                var formData = new FormData();

                // Get form values
                var name = $('#category_name').val(); // Assuming you have an input with id 'name_input' for name
                var description = $('#category_description').val(); // Assuming you have an input with id 'description_input' for description
                var image = $('#category_img')[0].files[0]; // Get the selected file
                // Append values to the FormData object
                formData.append('action', 'createcategory');
                formData.append('name', name);
                formData.append('description', description);
                formData.append('image', image); // Append the file

                // Send AJAX request
                $.ajax({
                    url: '/views/admin/controller/products.php',
                    type: 'POST',
                    data: formData,
                    processData: false, // Important: Do not process the data
                    contentType: false, // Important: Do not set content type
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            Swal.fire({
                                title: "Thêm danh mục sản phẩm thành công",
                                text: "",
                                icon: "success"
                            });
                            $("#createProductModal").modal("hide");
                            document.getElementById("formtaomoi").reset();
                            loadCategories();
                        } else {
                            alert('Error creating category');
                        }
                    },
                    error: function() {
                        alert('An error occurred while processing the request.');
                    }
                });
            });
            
            function loadCategories() {
                $.ajax({
                    url: '/views/admin/controller/products.php',
                    type: 'POST',
                    data: {
                        action: 'getcategory'
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        var html = '';

                        $.each(data, function(index, category) {
                            var price = Number(category.price).toLocaleString('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                            html += '<tr>' +
                                '<td>' + category.category_id + '</td>' +
                                '<td>' + category.category_name + '</td>' +
                                '<td><img width="100px " src="/public/imagescategory/' + category.category_img + '" alt="Hình ảnh danh mục sản phẩm"></td>' +
                                '<td>' + category.category_description + '</td>' +
                                '<td><button class="delete-button btn btn-danger mx-1" data-id="' + category.category_id + '">Xóa</button><button class="btn btn-warning" onclick="editForm(`' + category.category_id + '`)">Sửa</button></td>' +
                                '</tr>';
                        });
                        html = '<table>' + html + '</table>';
                        $('#categories').html(html);

                        // Add click event listener to delete buttons
                        $('.delete-button').click(function() {
                            var categoryId = $(this).data('id');
                            confirmDelete(categoryId);
                        });
                    },
                    error: function() {
                        $('#categories').html('Error loading data.');
                    }
                });
            }
            function confirmDelete(id){
                Swal.fire({
                title: "Bạn có chắc chắn muốn xóa không?",
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: "Đồng ý",
                cancelButtonText: "Hủy",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        deleteCategory(id); 
                    } else if (result.isDenied) {
                        Swal.fire("Changes are not saved", "", "info");
                    }
                });
            }
            function deleteCategory(id) {
                    $.ajax({
                        url: '/views/admin/controller/products.php',
                        type: 'POST',
                        data: {
                            action: 'deleteCategory',
                            id: id
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                Swal.fire("Xóa dữ liệu thành công!", "", "success");
                                loadCategories();
                            } else {
                                Swal.fire("Xóa dữ liêu thất bại!", "", "error");
                            }
                        }
                    });
                }
            $(document).ready(function() {
                loadCategories();
            });
        </script>
    </body>
    </html>