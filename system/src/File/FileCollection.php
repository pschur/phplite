<?php

namespace Phplite\File;

use Phplite\Support\Contracts\CollectionInterface;
use Phplite\Support\Traits\CollectionTrait;

class FileCollection implements CollectionInterface {
    use CollectionTrait;

    public function require(){
        foreach ($this->all() as $file) {
            $file = str_replace(File::path(''), '', $file);

            if (File::is_dir($file)) {
                File::require_directory($file);
            } else {
                File::require_file($file);
            }
        }
    }
}
