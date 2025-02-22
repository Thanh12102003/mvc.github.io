<?php

require_once ROOT . '/app/core/Controller.php';
require_once ROOT . '/app/models/Auth.php';
class AuthController extends Controller
{

    private $authModel;

    public function __construct()
    {
        $this->authModel = new Auth();
        $this->base_url = BASE_URL;

        try {
            $this->db = new PDO('mysql:host=localhost;dbname=webbanhang', 'root', '');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
        }
    }

    public function index()
    {
        $users = $this->authModel->getAllUsers();
        $data = [
            'title' => 'List Users',
            'users' => $users
        ];
        $content = $this->view('backend/user/index', $data, true); // Capture the content


        $this->view('layouts/backend_layout', [
            'content' => $content,
            'base_url' => BASE_URL,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }
    public function create()
    {

        $data = [
            'title' => 'Create User',
        ];
        $content = $this->view('backend/user/add', $data, true); // Capture the content


        $this->view('layouts/backend_layout', [
            'content' => $content,
            'base_url' => BASE_URL,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }
    public function edit($id)
    {

        // Get user details from the database
        $user = $this->authModel->getUserById($id);

        if (!$user) {
            // Redirect to user list if user not found
            header("Location: " . BASE_URL . "backend/auth/index?error=User not found.");
            exit();
        }
        $data = [
            'title' => 'Edit User',
            'user' => $user,
        ];
        $content = $this->view('backend/user/edit', $data, true); // Capture the content


        $this->view('layouts/backend_layout', [
            'content' => $content,
            'base_url' => BASE_URL,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }
    // Store the new user in the database
    public function store()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get user data from the form
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Perform basic validation
            if (empty($username) || empty($password)) {
                header("Location: " . BASE_URL . "backend/user/create?error=All fields are required.");
                exit();
            }

            // Hash the password for security
            $hashedPassword = md5($password);
            // Insert the user data into the database using the model
            $result = $this->authModel->addUser($username, $hashedPassword);

            if ($result) {
                header("Location: " . BASE_URL . "backend/auth/index?success=User created successfully.");
            } else {
                header("Location: " . BASE_URL . "backend/auth/create?error=Failed to create user.");
            }
            exit();
        }
    }
    // Update the user in the database
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get user data from the form
            $username = $_POST['username'];

            $password = $_POST['password'];

            // Perform basic validation
            if (empty($username)) {
                header("Location: " . BASE_URL . "backend/auth/edit/$id?error=All fields are required.");
                exit();
            }

            // If password is provided, hash it, else keep the old password
            $hashedPassword = !empty($password) ? md5($password) : null;

            // Update the user data in the database using the model
            $result = $this->authModel->updateUserById($id, $username, $hashedPassword);

            if ($result) {
                header("Location: " . BASE_URL . "backend/auth/index?success=User updated successfully.");
            } else {
                header("Location: " . BASE_URL . "backend/auth/edit/$id?error=Failed to update user.");
            }
            exit();
        }
    }
    public function login()
    {

        $data = [

            'title' => 'Login Admin',
        ];


        $content = $this->view('backend/auth/login', $data, true); // Capture the content


        $this->view('layouts/backend_layout', [
            'content' => $content,
            'base_url' => BASE_URL,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }
    public function dashboard()
    {

        $data = [

            'title' => 'Trang Dashboard',
        ];


        $content = $this->view('backend/dashboard', $data, true); // Capture the content


        $this->view('layouts/backend_layout', [
            'content' => $content,
            'base_url' => BASE_URL,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }
    public function access()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Assuming you've got the input values for $username and $password
            $user = $this->authModel->queryLogin($username, $password);

            if ($user) {
                // Login successful
                // Set session variables for username and user ID
                session_start();
                $_SESSION['user_access_id'] = $user['id'];
                $_SESSION['username'] = $user['username']; // Store the username in session


                // Redirect to the category/index page after login
                header('Location: ' . BASE_URL . '/backend/auth/adminindex?success=Login successfully.');
                exit();
            } else {
                // Login failed, redirect back to the login page
                header('Location: ' . BASE_URL . '/backend/auth/login?error=Login failed.');
                exit();
            }
        }
    }

    public function adminindex()
{
    $data = [
        'title' => 'Admin Index',
    ];

    $content = $this->view('backend/auth/adminindex', $data, true); // Đảm bảo file view tồn tại.

    $this->view('layouts/backend_layout', [
        'content' => $content,
        'base_url' => BASE_URL,
        'title' => $data['title'],
    ]);
}


    public function logout()
    {
        // Start the session if it's not already active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Unset specific session variables
        unset($_SESSION['user_access_id']);
        unset($_SESSION['username']);

        header('Location: ' . BASE_URL . '/backend/category/index?success=Logout successfully.');
        exit();
    }

    public function delete($id)
{
    session_start();

    // Kiểm tra người dùng có quyền không
    if (!isset($_SESSION['user_access_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
        $_SESSION['error'] = "Bạn không có quyền xóa người dùng!";
        header("Location: " . BASE_URL . "backend/auth/index");
        exit();
    }

    try {
        // Thực hiện xóa người dùng
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Xóa người dùng thành công!";
        } else {
            $_SESSION['error'] = "Xóa người dùng thất bại!";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Lỗi khi xóa người dùng: " . $e->getMessage();
    }

    // Chuyển hướng về danh sách người dùng
    header("Location: " . BASE_URL . "backend/auth/index");
    exit();
}

public function deleteUserById($id)
{
    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
}

}


