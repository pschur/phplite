<?php

namespace Phplite\Bootstrap;

use Phplite\DB\DB;
use Phplite\File\File;
use Phplite\Http\Request;
use Phplite\Router\Route;
use Phplite\Config\Config;
use Phplite\Http\Response;
use Phplite\Session\Session;
use Phplite\Exceptions\Whoops;

class App {
    /**
     * App constructor
     *
     * @return void
     */
    private function __construct() {}

    public static $db;

    /**
     * Run the application
     *
     * @return void
     */
    public static function run() {
        // Register whoops
        Whoops::handle();

        Config::init();
        self::db_setup();

        // Start session
        Session::start();

        // Handle the request
        Request::handle();

        // Require all routes directory
        File::require_directory('routes');

        // Handle the route
        $data = Route::handle();

        // Output the response
        Response::output($data);
    }

    private static function db_setup(){
        self::$db = new DB();

        self::$db->addConnection(Config::get('database'));
        self::$db->setAsGlobal();
        self::$db->bootEloquent();
    }
}