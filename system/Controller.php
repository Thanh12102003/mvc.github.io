<?php

class Controller
{
    // Method to load the view
    public function view($folder, $view, $data = [])
    {
        // Extract data to variables
        extract($data);

        // Include the view file
        require_once ROOT . "/app/views/$folder/$view.php";
    }
}
