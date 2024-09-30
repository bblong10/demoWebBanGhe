<?php
header('Content-Type: application/json');

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hàm để lấy dữ liệu
function getCategories($conn)
{
    $sql = "SELECT category_id, category_name,category_img,price, category_description FROM categories";
    $result = $conn->query($sql);
    $categories = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    return $categories;
}

function getProducts($conn, $category_id = 0)
{
    // Prepare the base query
    $query = "SELECT p.*, c.category_name FROM products p
              JOIN categories c ON p.categoryid = c.category_id";

    // Add a WHERE clause if category_id is provided
    if ($category_id > 0) {
        $query .= " WHERE p.categoryid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $category_id);
    } else {
        $stmt = $conn->prepare($query);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $products = array();
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}
// function getProducts($conn)
// {

//     $query = "SELECT p.*, c.category_name FROM products p
//               JOIN categories c ON p.categoryid = c.category_id";
//     $result = $conn->query($query);
//     $products = array();
//     while ($row = $result->fetch_assoc()) {
//         $products[] = $row;
//     }
//     return $products;
// }
function getProductsCategory($conn, $category_id)
{
    // Prepare the SQL query with a placeholder for category_id
    $sql = "SELECT * FROM products WHERE categoryid = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        // Handle error if the statement could not be prepared
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the category_id parameter to the prepared statement
    $stmt->bind_param("i", $category_id);

    // Execute the statement
    $stmt->execute();

    // Get the result set from the executed statement
    $result = $stmt->get_result();

    // Fetch the products as an associative array
    $products = array();
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    // Return the fetched products
    return $products;
}

// Hàm để thêm dữ liệu
function createCategory($conn, $name, $image, $description)
{
    $stmt = $conn->prepare("INSERT INTO categories (category_name, category_img, category_description) VALUES (?,?,?)");
    $stmt->bind_param("sss", $name, $image, $description);
    $stmt->execute();
    return $stmt->affected_rows;
}
function createproduct($conn, $name, $image, $price, $description, $category_id)
{
    $stmt = $conn->prepare("INSERT INTO products (name, image, price, description,categoryid) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $name, $image, $price, $description, $category_id);
    $stmt->execute();
    return $stmt->affected_rows;
}

// Hàm để xóa dữ liệu
function deleteCategory($conn, $id)
{
    $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->affected_rows;
}
function deleteProduct($conn, $id)
{
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->affected_rows;
}

function getDetailCategory($conn, $id)
{
    // Prepare and execute SQL statement
    $sql = "SELECT * FROM categories WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Fetch result
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();

    // Close connection
    $stmt->close();

    return $category;
}
function getDetailProduct($conn, $id)
{
    // Prepare and execute SQL statement
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Fetch result
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();

    // Close connection
    $stmt->close();

    return $category;
}

function updateCategory($conn, $id, $name, $image, $description)
{
    // Nếu có ảnh mới, thêm phần cập nhật ảnh vào câu lệnh SQL
    $imageSql = "";
    if ($image) {
        $imageSql = ", category_img = ?";
    }

    // Câu lệnh SQL để cập nhật dữ liệu
    $sql = "UPDATE categories SET category_name = ?, category_description = ?" . $imageSql . " WHERE category_id = ?";

    // Chuẩn bị câu lệnh SQL
    $stmt = $conn->prepare($sql);

    // Gắn các tham số
    if ($image) {
        $stmt->bind_param("ssss", $name, $description, $image, $id);
    } else {
        $stmt->bind_param("sss", $name, $description, $id);
    }

    // Thực thi câu lệnh
    $stmt->execute();

    // Trả về số lượng hàng bị ảnh hưởng
    return $stmt->affected_rows;
}
function updateProduct($conn, $id, $name, $image, $price, $description)
{
    // Nếu có ảnh mới, thêm phần cập nhật ảnh vào câu lệnh SQL
    $imageSql = "";
    if ($image) {
        $imageSql = ", category_img = ?";
    }

    // Câu lệnh SQL để cập nhật dữ liệu
    $sql = "UPDATE products SET name = ?, price = ?, description = ?" . $imageSql . " WHERE id = ?";

    // Chuẩn bị câu lệnh SQL
    $stmt = $conn->prepare($sql);

    // Gắn các tham số
    if ($image) {
        $stmt->bind_param("sdsss", $name, $price, $description, $image, $id);
    } else {
        $stmt->bind_param("sdss", $name, $price, $description, $id);
    }

    // Thực thi câu lệnh
    $stmt->execute();

    // Trả về số lượng hàng bị ảnh hưởng
    return $stmt->affected_rows;
}


// Xử lý yêu cầu AJAX
$action = isset($_POST['action']) ? $_POST['action'] : '';

switch ($action) {
    case 'get':
        // echo json_encode(getProducts($conn));
        $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
        echo json_encode(getProducts($conn, $category_id));
        
        break;
    case 'getproductwithcategory':
        // $category_id = $_POST['categoryid'];
        // echo json_encode(getProductsCategory($conn,$category_id));
        $category_id = isset($_POST['categoryid']) ? $_POST['categoryid'] : 0;
        if ($category_id) {
            // Fetch products by category_id
            echo json_encode(getProductsCategory($conn, $category_id));
        } else {
            echo json_encode(['error' => 'Category ID is required']);
        }

        break;
    case 'getcategory':
        echo json_encode(getCategories($conn));
        break;
    case 'create':
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $image = '';
        $price = isset($_POST['price']) ? $_POST['price'] : 0;
        $category_id = $_POST['category_id'];
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = '../../../public/images/'; // Set your target directory
            $timestamp = time(); // You can also use date('YmdHis') for a formatted timestamp

            // Extract the file extension
            $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            // Create a new filename: original filename without extension + timestamp + extension
            $newFileName = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME) . '_' . $timestamp . '.' . $imageFileType;
            $targetFile = $targetDir . $newFileName;
            $uploadOk = 1;

            // Check if the file is a valid image type (optional)
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($imageFileType, $validExtensions)) {
                $uploadOk = 0;
                $response = ['success' => false, 'message' => 'Invalid file type.'];
            }

            // Attempt to upload the file
            if ($uploadOk) {
                move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
                $image =  $newFileName;
            }
        }

        // Validate input data (e.g., ensure name and description are not empty)
        if (empty($name) || empty($description)) {
            echo json_encode(['success' => false, 'message' => 'Invalid input data']);
            break;
        }

        $result = createproduct($conn, $name, $image, $price, $description, $category_id);
        if ($result > 0) {
            // Category created successfully
            echo json_encode(['success' => true, 'message' => 'Category created successfully']);
        } else {
            // Error creating category
            echo json_encode(['success' => false, 'message' => 'Error creating category']);
        }
        break;
    case 'createcategory':
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $image = '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = '../../../public/imagescategory/'; // Set your target directory
            $timestamp = time(); // You can also use date('YmdHis') for a formatted timestamp

            // Extract the file extension
            $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            // Create a new filename: original filename without extension + timestamp + extension
            $newFileName = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME) . '_' . $timestamp . '.' . $imageFileType;
            $targetFile = $targetDir . $newFileName;
            $uploadOk = 1;

            // Check if the file is a valid image type (optional)
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($imageFileType, $validExtensions)) {
                $uploadOk = 0;
                $response = ['success' => false, 'message' => 'Invalid file type.'];
            }

            // Attempt to upload the file
            if ($uploadOk) {
                move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
                $image =  $newFileName;
            }
        }

        // Validate input data (e.g., ensure name and description are not empty)
        if (empty($name) || empty($description)) {
            echo json_encode(['success' => false, 'message' => 'Invalid input data']);
            break;
        }

        $result = createCategory($conn, $name, $image, $description);
        if ($result > 0) {
            // Category created successfully
            echo json_encode(['success' => true, 'message' => 'Category created successfully']);
        } else {
            // Error creating category
            echo json_encode(['success' => false, 'message' => 'Error creating category']);
        }
        break;
    case 'edit':
        $id = 0;
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        } else {
            echo json_encode(array('success' => false, 'message' => 'Không tìm thấy dữ liệu'));
        }
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $image = '';
        $price = isset($_POST['price']) ? $_POST['price'] : 0;
        $category_id = $_POST['category_id'];
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = '../../../public/images/'; // Set your target directory
            $timestamp = time(); // You can also use date('YmdHis') for a formatted timestamp

            // Extract the file extension
            $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            // Create a new filename: original filename without extension + timestamp + extension
            $newFileName = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME) . '_' . $timestamp . '.' . $imageFileType;
            $targetFile = $targetDir . $newFileName;
            $uploadOk = 1;

            // Check if the file is a valid image type (optional)
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($imageFileType, $validExtensions)) {
                $uploadOk = 0;
                $response = ['success' => false, 'message' => 'Invalid file type.'];
            }

            // Attempt to upload the file
            if ($uploadOk) {
                move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
                $image =  $newFileName;
            }
        }

        // Validate input data (e.g., ensure name and description are not empty)
        if (empty($name) || empty($description)) {
            echo json_encode(['success' => false, 'message' => 'Invalid input data']);
            break;
        }

        $result = updateProduct($conn, $id, $name, $image, $price, $description);
        if ($result > 0) {
            // Category created successfully
            echo json_encode(['success' => true, 'message' => 'Category created successfully']);
        } else {
            // Error creating category
            echo json_encode(['success' => false, 'message' => 'Error creating category']);
        }
        break;
    case 'editcategory':
        $id = 0;
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        } else {
            echo json_encode(array('success' => false, 'message' => 'Không tìm thấy dữ liệu'));
        }
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $image = '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = '../../../public/imagescategory/'; // Set your target directory
            $timestamp = time(); // You can also use date('YmdHis') for a formatted timestamp

            // Extract the file extension
            $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            // Create a new filename: original filename without extension + timestamp + extension
            $newFileName = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME) . '_' . $timestamp . '.' . $imageFileType;
            $targetFile = $targetDir . $newFileName;
            $uploadOk = 1;

            // Check if the file is a valid image type (optional)
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($imageFileType, $validExtensions)) {
                $uploadOk = 0;
                $response = ['success' => false, 'message' => 'Invalid file type.'];
            }

            // Attempt to upload the file
            if ($uploadOk) {
                move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
                $image =  $newFileName;
            }
        }

        // Validate input data (e.g., ensure name and description are not empty)
        if (empty($name) || empty($description)) {
            echo json_encode(['success' => false, 'message' => 'Invalid input data']);
            break;
        }

        $result = updateCategory($conn, $id, $name, $image, $description);
        if ($result > 0) {
            // Category created successfully
            echo json_encode(['success' => true, 'message' => 'Category created successfully']);
        } else {
            // Error creating category
            echo json_encode(['success' => false, 'message' => 'Error creating category']);
        }
        break;
    case 'delete':
        $id = 0;
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        } else {
            echo json_encode(array('success' => false, 'message' => 'Không tìm thấy dữ liệu'));
        }

        $result = deleteProduct($conn, $id);
        echo json_encode(array('success' => $result > 0));
        break;
    case 'deleteCategory':
        $id = 0;
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        } else {
            echo json_encode(array('success' => false, 'message' => 'Không tìm thấy dữ liệu'));
        }

        $result = deleteCategory($conn, $id);
        echo json_encode(array('success' => $result > 0));
        break;
    case 'getdata':
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $result = getDetailProduct($conn, $id);
        echo json_encode($result);
        break;
    case 'getdatacategory':
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $result = getDetailCategory($conn, $id);
        echo json_encode($result);
        break;

    default:
        echo json_encode(array('error' => 'Invalid action'));
        break;
}

// Đóng kết nối
$conn->close();
