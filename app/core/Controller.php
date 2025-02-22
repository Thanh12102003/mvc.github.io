<?php
// Core Controller class
class Controller
{
    // This will store the base URL
    protected $base_url;

    // Constructor to initialize common properties
    public function __construct()
    {
        // Set the base URL dynamically based on the current request
        $this->base_url = $this->base_url();
    }

    // Method to load a view and pass data to it
    public function view($view, $data = [], $return = false)
    {
        $viewPath = APP . '/views/' . $view . '.php';

        if (file_exists($viewPath)) {
            extract($data);
            if ($return) {
                ob_start();
                require_once $viewPath;
                return ob_get_clean();
            } else {
                require_once $viewPath;
            }
        } else {
            die("View '$view' not found.");
        }
    }

    // Method to get the base URL
    public function base_url()
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    }
}
