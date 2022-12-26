<?php

namespace App\Resources;

use Illuminate\Database\Schema\Blueprint;
use Phplite\Resources\ResourceController;

class UserResource extends ResourceController
{    
    /**
     * Resource key
     * 
     * @var string
     */
    protected string $key = 'user';

    /**
     * Resource table name
     * 
     * @var string
     */
    protected string $table = 'users';

    /**
     * defines the singular name
     * 
     * @var string
     */
    protected string $name_sg = 'User';

    /**
     * defines the plural name
     * 
     * @var string
     */
    protected string $name_pl = 'Users';
    
    /**
     * set hidden fields
     * 
     * @param array<string>
     */
    protected array $hidden = ['password'];

    /**
     * set up the schema
     * 
     * @param \Illuminate\Database\Schema\Blueprint $builder
     * @return void
     */
    public function schema(Blueprint $builder){
        $builder->id();
        $builder->string('name');
        $builder->string('username')->unique();
        $builder->string('password');
        $builder->timestamps();
    }

    public function table():array{
        return ['name'];
    }
}
