<?php

require __DIR__ . '/../vendor/autoload.php';

use Nubila\Core\Router;
use Nubila\Core\Request;
use Nubila\Database\Connection;

// Helper function to load .env variables
function env($key, $default = null)
{
    $envFile = __DIR__ . '/../.env';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue; // Skip comments
            }
            list($name, $value) = explode('=', $line, 2);
            if (trim($name) === $key) {
                return trim($value);
            }
        }
    }
    return $default;
}

// Load configuration
$config = require __DIR__ . '/../config/app.php';

// Create a request object
$request = new Request();

// Create a router and define routes
$router = new Router();

$router->get('/', function () {
    // Render the homepage with Bootstrap and CoreUI
    return '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nubila PHP Framework</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- CoreUI CSS -->
        <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.3.0/dist/css/coreui.min.css" rel="stylesheet">
    </head>
    <body>
        <!-- Header -->
        <header class="bg-dark text-white text-center py-4">
            <div class="container">
                <h1>Welcome to Nubila PHP Framework</h1>
                <p>A lightweight and powerful PHP framework</p>
            </div>
        </header>

        <!-- Navigation Menu -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/">Nubila</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/blog">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/contact">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero bg-primary text-white text-center py-5">
            <div class="container">
                <h2>Build Amazing Web Applications</h2>
                <p>Nubila PHP Framework is designed to make development fast, easy, and enjoyable.</p>
                <a href="/blog" class="btn btn-light btn-lg">Explore Blog</a>
            </div>
        </section>

        <!-- Main Content -->
        <main class="container my-5">
            <div class="row">
                <div class="col-md-8">
                    <h3>Latest Blog Posts</h3>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Blog Post Title</h5>
                            <p class="card-text">This is a summary of the blog post content.</p>
                            <a href="/blog/post-1" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Another Blog Post</h5>
                            <p class="card-text">This is another summary of the blog post content.</p>
                            <a href="/blog/post-2" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h3>Sidebar</h3>
                    <p>This is the sidebar content. You can add widgets, links, or other information here.</p>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-dark text-white text-center py-3">
            <div class="container">
                <p>&copy; 2023 Nubila PHP Framework. All rights reserved.</p>
            </div>
        </footer>

        <!-- Bootstrap JS and CoreUI JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.3.0/dist/js/coreui.bundle.min.js"></script>
    </body>
    </html>
    ';
});

$router->get('/about', function () {
    return 'About Us Page';
});

$router->get('/blog', function () {
    return 'Blog Page';
});

$router->get('/contact', function () {
    return 'Contact Us Page';
});

// Database connection
$dbConfig = [
    'host' => env('DB_HOST', 'localhost'),
    'database' => env('DB_NAME', 'nubila_db'),
    'username' => env('DB_USER', 'root'),
    'password' => env('DB_PASS', ''),
];

$db = new Connection($dbConfig);

$router->get('/users', function () use ($db) {
    $users = $db->query("SELECT * FROM users");
    return json_encode($users);
});

// Dispatch the request
$response = $router->dispatch($request);

// Send the response
echo $response;