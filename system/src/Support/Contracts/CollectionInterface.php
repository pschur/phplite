<?php

namespace Phplite\Support\Contracts;

use Iterator;
use Countable;
use Stringable;
use ArrayAccess;
use Serializable;
use Illuminate\Contracts\Support\Arrayable;

interface CollectionInterface extends Iterator, Countable, ArrayAccess, Arrayable, Serializable, Stringable
{

}
