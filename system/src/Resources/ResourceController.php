<?php

namespace Phplite\Resources;

use Illuminate\Database\Schema\Blueprint;
use Phplite\Database\Database;
use Phplite\Http\Request;
use Phplite\Resources\Builder\ValidationBuilder;
use Phplite\Resources\Builder\ViewBuilder;
use Phplite\Validation\Validate;
use stdClass;

abstract class ResourceController
{
    /**
     * Resource key
     * 
     * @var string
     */
    protected string $key;

    /**
     * Resource table name
     * 
     * @var string
     */
    protected string $table;

    /**
     * defines the singular name
     * 
     * @var string
     */
    protected string $name_sg;

    /**
     * defines the plural name
     * 
     * @var string
     */
    protected string $name_pl;

    /**
     * set hidden fields
     * 
     * @param array<string>
     */
    protected array $hidden = [];

    /**
     * set up the schema
     * 
     * @param \Illuminate\Database\Schema\Blueprint $builder
     * @return void
     */
    abstract public function schema(Blueprint $builder);

    /**
     * set up the table
     * 
     * @return array
     */
    abstract public function table():array;

    /**
     * get a value
     * 
     * @param string $key
     * @return mixed
     */
    public function get(string $key){
        return $this->{$key};
    }

    /**
     * set a value
     * 
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function set(string $key, mixed $value = null){
        return $this->{$key} = $value;
    }

    /**
     * view
     * 
     * @return \Phplite\Resources\Builder\ViewBuilder
     */
    protected function view(){
        return new ViewBuilder($this);
    }

    /**
     * database
     * 
     * @return \Phplite\Database\Database
     */
    public function database(){
        return Database::table($this->table);
    }

    /**
     * set parents
     * 
     * @return array
     */
    public function parents():array {
        return [];
    }

    /**
     * set children
     * 
     * @return array
     */
    public function children():array {
        return [];
    }

    /**
     * get all data
     * 
     * @return array<string,string|\Illuminate\Database\Schema\Blueprint>
     */
    public function all(){
        $return = new stdClass;
        $return->name = [
            'singular' => $this->name_sg,
            'plural' => $this->name_pl,
        ];
        $return->key = $this->key;
        $return->table = $this->table;

        return $return;
    }

    /**
     * get rules
     * 
     * @param array $data
     * @return array
     */
    public function rules(array $data = []){
        return (new ValidationBuilder($this))->make($data);
    }

    /**
     * index action
     */
    public function index(){
        return $this->view()->table($this->database()->get());
    }

    /**
     * create function
     * 
     * @return \Phplite\View\View|string
     */
    public function create(){
        return $this->view()->form();
    }

    /**
     * store entry
     * 
     */
    public function store(){
        $rules = $this->rules();
        Validate::make($rules);

        $insert = [];
        foreach($rules as $key => $value){
            $insert = Request::post($key);
        }

        $this->database()->insert($insert);
        return redirect('/');
    }

    /**
     * show function
     * 
     * @param int $id
     * @return \Phplite\View\View|string
     */
    public function show($id){
        return $this->view()->details($this->database()->find($id));
    }

    /**
     * edit function
     * 
     * @param int $id
     * @return \Phplite\View\View|string
     */
    public function edit($id){
        return $this->view()->form($this->database()->find($id));
    }
}
