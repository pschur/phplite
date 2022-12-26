<?php

namespace Phplite\Resources;

use Phplite\Bootstrap\App;
use Phplite\Database\Database;
use Illuminate\Database\Schema\Blueprint;
use Phplite\Resources\Builder\ValidationBuilder;
use Illuminate\Database\Schema\Grammars\MySqlGrammar;

class Resource {
    /**
     * make the validation
     * 
     * @param \Phplite\Resources\ResourceController $resource
     * @param array $data
     * @return mixed
     */
    public static function validation(ResourceController $resource, array $data = []){
        return $resource->rule;
    }

    /**
     * make the schema ready
     * 
     * @param \Phplite\Resources\ResourceController $resource
     * @return \Illuminate\Database\Schema\Blueprint
     */
    public static function schema(ResourceController $resource){
        $table = new Blueprint($resource->get('table'));
        $resource->schema($table);

        return $table;
    }

    public static function migrate(ResourceController $resource){
        if (count(Database::query("SHOW TABLES LIKE '{$resource->get('table')}'")->get()) >= 1) {
            echo "Table {$resource->get('table')} already exists! \n";
            return;
        }

        $blueprint = new Blueprint($resource->get('table'));
        $blueprint->create();
        $resource->schema($blueprint);
        $blueprint->build(App::$db->getConnection(), new MySqlGrammar);
        echo "Table {$resource->get('table')} migrated ✔ \n";
    }
}
