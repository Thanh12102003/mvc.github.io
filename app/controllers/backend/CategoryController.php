<?php

// Optionally include the Controller.php file (if not autoloaded)
require_once ROOT . '/app/core/Controller.php';
require_once ROOT . '/app/models/Category.php';

// CategoryController extends the base Controller class
class CategoryController extends Controller
{ // Create a new Category instance
    private $categoryModel;
    public function __construct()
    {
        // Check if the user is logged in
        session_start();
        if (!isset($_SESSION['user_access_id'])) {
            // Redirect to login page if not logged in
            header("Location: " . BASE_URL . "backend/auth/login");
            exit();
        }
        $this->categoryModel = new Category();

        // Set the base_url here, or you could use a dynamic approach
        $this->base_url = BASE_URL;
    }

    // Display the category list (index page)
    public function index()
    {
        // Fetch all categories from the model
        $categories = $this->categoryModel->getAllCategories();

        // Prepare data for the view
        $data = [
            'categories' => $categories,
            'title' => 'Category List',
        ];

        // Render the index view
        $content = $this->view('backend/category/index', $data, true); // Capture the content

        // Pass base_url to the layout
        $this->view('layouts/backend_layout', [
            'content' => $content,
            'base_url' => $this->base_url,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }

    // Method for the 'create' action
    public function create()
    {
        $data = [
            'title' => 'Category Add',
        ];
        // Render the index view
        $content = $this->view('backend/category/add', $data, true); // Capture the content
        // Load the view for listing categories
        // Pass base_url to the layout
        $this->view('layouts/backend_layout', [
            'content' => $content,
            'base_url' => $this->base_url,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }
    // Handle the form submission and insert a new category into the database
    public function store()
    {
        // Get the form data
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        // Validate data
        if ($name && $description) {
            // Create a new category instance from the Category model
            $isCreated = $this->categoryModel->createCategory($name, $description);

            if ($isCreated) {
                // Redirect to the category index page or show a success message
                header('Location: ' .  $this->base_url . '/backend/category/index');
                exit();
            } else {
                echo 'Error: Category could not be created.';
            }
        } else {
            echo 'Please fill in all fields.';
        }
    }
    // Show the form to edit an existing category
    public function edit($id)
    {
        // Assuming $id is the category ID being passed for editing
        $category = $this->categoryModel->getCategoryById($id);

        if ($category) {
            // Capture the content of the 'edit' view
            $content = $this->view('backend/category/edit', ['category' => $category], true);

            // Prepare the title and base URL
            $data = [
                'title' => 'Edit Category',  // You can dynamically set this title as needed
                'base_url' => $this->base_url,  // Make sure $this->base_url is properly initialized
            ];

            // Pass the content and other variables to the main layout
            $this->view('layouts/backend_layout', [
                'content' => $content,
                'base_url' => $data['base_url'],
                'title' => $data['title'],  // Title for the page
            ]);
        } else {
            echo 'Category not found.';
        }
    }
    // Update the category in the database
    public function update($id)
    {
        // Get the updated data from the form
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        // Validate the data
        if ($name && $description) {

            $isUpdated = $this->categoryModel->updateCategory($id, $name, $description);

            if ($isUpdated) {
                // Redirect to the category listing page
                header('Location: ' .  $this->base_url . '/backend/category/index');
                exit();
            } else {
                echo 'Error: Category could not be updated.';
            }
        } else {
            echo 'Please fill in all fields.';
        }
    }

    // Delete a category from the database
    public function delete($id)
    {

        $isDeleted = $this->categoryModel->deleteCategory($id);

        if ($isDeleted) {
            // Redirect to the category listing page
            header('Location: ' .  $this->base_url  . '/backend/category/index');
            exit();
        } else {
            echo 'Error: Category could not be deleted.';
        }
    }
}
