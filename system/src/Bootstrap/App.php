<?php

namespace Phplite\Bootstrap;

use Phplite\Config\Config;
use Phplite\DB\DB;
use Phplite\Exceptions\Whoops;
use Phplite\File\File;
use Phplite\Http\Request;
use Phplite\Http\Response;
use Phplite\Router\Route;
use Phplite\Session\Session;

class App {
    /**
     * App constructor
     *
     * @return void
     */
    private function __construct() {}

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
        $db = new DB();

        $db->addConnection(Config::get('database'));
        $db->setAsGlobal();
        $db->bootEloquent();
    }
}