<?php

namespace Phplite\Resources\Builder;

use Phplite\Resources\Resource;
use Phplite\Resources\ResourceController;
use Phplite\Validation\Validate;

class ValidationBuilder
{
    public function __construct(private ResourceController $resource){}

    public function make(array $data = []){
        $columns = Resource::schema($this->resource)->getColumns();
        $rules = [];
        foreach ($columns as $column) {
            $column = $column->toArray();
            if ($this->checkColumn($column)) {
                $rules[$column['name']] = $column['rules'] ?? $this->makeRules($column, $data);
            }
        }

        return $rules;
    }

    private function checkColumn(array $column){
        $keyIs = $this->keyIs($column);

        if ($keyIs('autoIncrement', 1) && $keyIs('unsigned', 1) && $keyIs('name', 'id')) {
            return false;
        }
        if ($keyIs('ignoreValidation', true) || $keyIs('relationship', true)) {
            return false;
        }

        if (($keyIs('name', 'created_at') || $keyIs('name', 'updated_at')) && $keyIs('type', 'timestamp')) {
            return false;
        }

        return true;
    }

    public function keyIs($column){
        return function(string $key, mixed $value)use($column){return isset($column[$key]) && $column[$key] == $value;};
    }

    private function makeRules(array $column, array $data = []){
        $keyIs = $this->keyIs($column);
        $rules = [];

        if ($keyIs('unique', 1)) {
            $rules[] = "unique:".$this->resource->get('table').",".$column['name']. (isset($data[$column['name']]) ? ",".$data[$column['name']] : null);
        }
        if ($keyIs('name', 'email')) {
            $rules[] = "email";
        }
        if ($keyIs('name', 'url')) {
            $rules[] = "url";
        }

        if (isset($column['length'])) {
            $rules[] = 'max:'.$column['length'];
        }

        if ($keyIs('nullable', 1)) {
            $rules[] = "nullable";
        } else {
            $rules[] = 'required';
        }

        return $rules;
    }
}
