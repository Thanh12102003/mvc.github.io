<?php

// Define paths for app and controllers
define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('CONTROLLER', APP . '/controllers');
define('SYSTEM', ROOT . '/system');
// Automatically detect the base URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$base_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

// Define globally for reuse
define('BASE_URL', $base_url);

// Get the URL from the query string (if available)
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'frontend/home';
$urlParts = explode('/', $url);

// Default to 'frontend' if the module is not provided
$module = $urlParts[0] ?? 'frontend';
$controllerName = ucfirst($urlParts[1] ?? 'home') . 'Controller'; // Convert to controller class name
$actionName = $urlParts[2] ?? 'index';  // Default to index action

// Check if the module is either 'frontend' or 'backend'
if ($module !== 'frontend' && $module !== 'backend') {
    $module = 'frontend';  // Fallback to frontend if invalid module is passed
}

// Construct the full path to the controller
$controllerPath = CONTROLLER . "/$module/$controllerName.php";

// Check if the controller file exists
if (file_exists($controllerPath)) {
    require_once $controllerPath;

    // Create an instance of the controller class
    if (class_exists($controllerName)) {
        $controller = new $controllerName();

        // Check if the action exists within the controller
        if (method_exists($controller, $actionName)) {
            // Call the controller's action method
            call_user_func_array([$controller, $actionName], array_slice($urlParts, 3));
        } else {
            handleError("Action '$actionName' not found.");
        }
    } else {
        handleError("Controller '$controllerName' not found.");
    }
} else {
    handleError("Controller file '$controllerPath' not found.");
}

// Function to handle errors
function handleError($message)
{
    // Log and display the error
    error_log($message);
    echo "<h1>Error</h1><p>$message</p>";
    exit();
}
