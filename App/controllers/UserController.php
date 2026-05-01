<?php

namespace App\controllers;

use Framework\Database;
use Framework\Validation;

class UserController {
    protected $db;

    public function __construct() {
        $config = require basePath('config/database.php');
        $this->db = new Database($config);
    }

    /**
     * Show the login page
     * 
     * @return void
     */
    public function login() {
        loadView('user/login');
    }

    /**
     * Show the registration page
     * 
     * @return void
     */
    public function create() {
        loadView('user/create');
    }
}