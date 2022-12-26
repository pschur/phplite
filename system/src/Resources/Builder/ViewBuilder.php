<?php

namespace Phplite\Resources\Builder;

use Phplite\Resources\ResourceController;

class ViewBuilder
{
    /**
     * Resource
     * 
     * @var \Phplite\Resources\ResourceController
     */
    private ResourceController $resource;

    /**
     * ViewBuilder Constructor
     * 
     * @param \Phplite\Resources\ResourceController $resource
     * @return void
     */
    public function __construct(ResourceController $resource){
        $this->resource = $resource;
        // $this->resource = Resource::find($resource);
    }

    /**
     * table view
     * 
     * @param array|object $data
     * @return \Phplite\View\View|string
     */
    public function table(array|object $data = []){
        dd($data);
        // return view();
    }

    /**
     * form view
     * 
     * @param array|object $data
     * @return \Phplite\View\View|string
     */
    public function form(array|object $data = []){
        dd($data);
        // return view('crud.edit');
    }

    /**
     * details view
     * 
     * @param array|object $data
     * @return \Phplite\View\View|string
     */
    public function details(array|object $data = []){
        dd($data);
        // return view('crud.edit');
    }
}
