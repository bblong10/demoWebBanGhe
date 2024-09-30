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
       <div
           class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
           <h1 class="h2">Danh sách sản phẩm</h1>
       </div>
       <div class="row">
           <div class="col-md-12">
               <div class="card">
                   <div class="card-header">
                       <h2 class="float-left">
                           Sản phẩm
                       </h2>
                       <div class="float-right">

                           <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                               data-bs-target="#createProductModal">
                               Thêm sản phẩm
                           </button>
                       </div>
                   </div>
                   <div class="table-responsive card-body">
                       <table class="table table-info table-striped table-bordered">
                           <thead>
                               <tr>
                                   <th>ID</th>
                                   <th>Tên</th>
                                   <th>Tên danh mục</th>
                                   <th>Hình ảnh</th>
                                   <th>Đơn Giá</th>
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
       <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
           aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered">

               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="createProductModalLabel">Tạo sản phẩm</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-body">
                       <form id="formtaomoi">
                           <div class="form-group input-group mb-3">
                               <input class="form-control border rounded" type="text" id="product_name" required
                                   placeholder="Tên sản phẩm">
                           </div>
                           <div class="form-group input-group mb-3">
                               <input class="form-control" type="file" name="image" id="product_img">
                           </div>
                           <div class="form-group input-group mb-3">
                               <textarea class="form-control" type="text" id="product_description" required
                                   placeholder="Mô tả sản phẩm" rows="3"></textarea>
                           </div>
                           <div class="form-group input-group mb-3">
                               <label for="product_category">Danh mục:</label>
                               <select class="form-control" id="product_category" required>
                                   <!-- Options sẽ được thêm bằng JavaScript -->
                               </select>
                           </div>
                           <div class="form-group input-group mb-3">
                               <input type="number" class="form-control border rounded" id="price" required
                                   placeholder="Đơn giá">
                           </div>
                       </form>

                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                       <button id="create_button" class="btn btn-success" data-bs-dismiss="modal">Thêm sản phẩm</button>

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
                       <input type="hidden" name="" id="product_id_edit">
                       <div class="form-group input-group mb-3">
                           <input class="form-control border rounded" type="text" id="product_name_edit" required
                               placeholder="Tên sản phẩm">
                       </div>
                       <div class="form-group input-group mb-3">
                           <input class="form-control" type="file" name="image" id="product_img_edit">
                       </div>
                       <div class="form-group input-group mb-3">
                           <textarea class="form-control" type="text" id="product_description_edit" required
                               placeholder="Mô tả sản phẩm" style="min-height:200px;"></textarea>
                       </div>
                       <div class="form-group input-group mb-3">
                           <label for="product_category_edit">Danh mục:</label>
                           <select class="form-control" id="product_category_edit" required>
                               <!-- Options sẽ được thêm bằng JavaScript -->
                           </select>
                       </div>
                       <div class="form-group input-group mb-3">
                           <input class="form-control border rounded" type="number" id="price_edit" required
                               placeholder="Đơn giá">
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
                   action: 'getdata',
                   id: id
               },
               success: function(response) {
                   console.log(response);
                   if (response != null) {
                       $("#titleEdit").html("Chỉnh sửa sản phẩm: " + response.name);
                       document.getElementById("product_name_edit").value = response.name;
                       document.getElementById("product_description_edit").value = response.description;
                       document.getElementById("price_edit").value = response.price;
                       document.getElementById("product_id_edit").value = response.id;
                       $("#product_category_edit").val(response.categoryid);
                       $("#exampleModal").modal("show");
                   } else {
                       alert('Error deleting product');
                   }
               }
           });
       }
       $('#edit_button').click(function() {
           // Create a FormData object
           var formData = new FormData();

           // Get form values
           var id = $('#product_id_edit').val();
           var name = $('#product_name_edit').val(); // Assuming you have an input with id 'name_input' for name
           var description = $('#product_description_edit')
               .val(); // Assuming you have an input with id 'description_input' for description
           var image = $('#product_img_edit')[0].files[0]; // Get the selected file
           var price = $('#price_edit').val();
           var category_id = $('#product_category_edit').val();
           // Append values to the FormData object
           formData.append('action', 'edit');
           formData.append('id', id);

           formData.append('name', name);
           formData.append('price', price);

           formData.append('description', description);
           formData.append('image', image); // Append the file
           formData.append('category_id', category_id); // Append the file

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
                       loadproducts();
                   } else {
                       alert('Error editing product');
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
           var name = $('#product_name').val(); // Assuming you have an input with id 'name_input' for name
           var description = $('#product_description')
               .val(); // Assuming you have an input with id 'description_input' for description
           var image = $('#product_img')[0].files[0]; // Get the selected file
           var price = $('#price').val();
           var category_id = $('#product_category').val();
           // Append values to the FormData object
           formData.append('action', 'create');
           formData.append('name', name);
           formData.append('price', price);

           formData.append('description', description);
           formData.append('image', image); // Append the file
           formData.append('category_id', category_id); // Append the file

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
                           title: "Thêm sản phẩm thành công",
                           text: "",
                           icon: "success"
                       });
                       $("#createProductModal").modal("hide");
                       document.getElementById("formtaomoi").reset();
                       loadproducts();
                   } else {
                       alert('Error creating product');
                   }
               },
               error: function() {
                   alert('An error occurred while processing the request.');
               }
           });
       });

       function loadCategories() {
           $.ajax({
               url: '/views/admin/controller/products.php', // Tạo endpoint này trong PHP để lấy danh mục
               type: 'POST',
               data: {
                   action: 'getcategory'
               },
               dataType: 'json',
               success: function(data) {
                   var options = '<option value="">Chọn danh mục</option>';
                   $.each(data, function(index, category) {
                       options += '<option value="' + category.category_id + '">' + category
                           .category_name + '</option>';
                   });
                   $('#product_category').html(options);
                   $('#product_category_edit').html(options);
               },
               error: function() {
                   alert('Error loading categories.');
               }
           });
       }

       function loadproducts() {
           $.ajax({
               url: '/views/admin/controller/products.php',
               type: 'POST',
               data: {
                   action: 'get'
               },
               dataType: 'json',
               success: function(data) {
                   console.log(data);
                   var html = '';

                   $.each(data, function(index, product) {
                       var price = Number(product.price).toLocaleString('en-US', {
                           minimumFractionDigits: 0,
                           maximumFractionDigits: 0
                       });
                       html += '<tr>' +
                           '<td>' + product.id + '</td>' +
                           '<td>' + product.name + '</td>' +
                           '<td>' + product.category_name + '</td>' +
                           '<td><img width="100px " src="/public/images/' + product.image +
                           '" alt="Hình ảnh sản phẩm"></td>' +
                           '<td>' + price + ' VND </td>' +
                           '<td>' + product.description + '</td>' +
                           '<td><button class="delete-button btn btn-danger mx-1" data-id="' +
                           product.id +
                           '">Xóa</button><button class="btn btn-warning" onclick="editForm(' +
                           product.id + ')">Sửa</button></td>' +

                           '</tr>';
                   });
                   html = '<table>' + html + '</table>';
                   $('#categories').html(html);

                   // Add click event listener to delete buttons
                   $('.delete-button').click(function() {
                       var productId = $(this).data('id');
                       confirmDelete(productId);
                   });
               },
               error: function() {
                   $('#categories').html('Error loading data.');
               }
           });
       }

       function confirmDelete(id) {
           Swal.fire({
               title: "Bạn có chắc chắn muốn xóa không?",
               showDenyButton: false,
               showCancelButton: true,
               confirmButtonText: "Đồng ý",
               cancelButtonText: "Hủy",
           }).then((result) => {
               /* Read more about isConfirmed, isDenied below */
               if (result.isConfirmed) {
                   deleteproduct(id);
               } else if (result.isDenied) {
                   Swal.fire("Changes are not saved", "", "info");
               }
           });
       }

       function deleteproduct(id) {
           $.ajax({
               url: '/views/admin/controller/products.php',
               type: 'POST',
               data: {
                   action: 'delete',
                   id: id
               },
               success: function(response) {
                   console.log(response);
                   if (response.success) {
                       Swal.fire("Xóa dữ liệu thành công!", "", "success");
                       loadproducts();
                   } else {
                       Swal.fire("Xóa dữ liêu thất bại!", "", "error");
                   }
               }
           });
       }
       $(document).ready(function() {
           loadCategories();
           loadproducts();
       });
       </script>
   </body>

   </html>