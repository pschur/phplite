<?php

namespace Phplite\Support\Traits;

use Closure;

trait CollectionTrait
{
    /**
     * array
     * 
     * @var array
     */
    private array $items = [];

    /**
     * position
     * 
     * @var int
     */
    private int $position = 0;

    /**
     * collection constructor
     * 
     * @param array $items
     * @return void
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * get current item
     * 
     * @return mixed
     */
    public function current(): mixed
    {
        return $this->items[$this->position];
    }

    /**
     * set position to the next
     * 
     * @return void
     */
    public function next(): void
    {
        $this->position++;
    }

    /**
     * get key
     * 
     * @return mixed
     */
    public function key(): mixed
    {
        return $this->position;
    }

    /**
     * checks if the item exists
     * 
     * @return bool
     */
    public function valid(): bool
    {
        return $this->offsetExists($this->position);
    }

    /**
     * reset position
     * 
     * @return void
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * count array
     * 
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * checks if the item exists
     * 
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * get
     * 
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    /**
     * set parameter
     * 
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->items[$offset] = $value;
    }

    /**
     * delete an item
     * 
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }
    
    /**
     * serialize items
     * 
     * @return string
     */
    public function serialize(): ?string
    {
        return json_encode($this->items);
    }

    /**
     * get all items
     * 
     * @return array
     */
    public function __serialize(): array
    {
        return $this->all();
    }

    /**
     * unserialize items
     * 
     * @param string $data
     */
    public function unserialize(string $data): void
    {
        $this->items = json_decode($data, true);
    }

    public function __unserialize(array $data): void
    {
        $this->items = $data;
    }

    /**
     * get all items
     * 
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * get array
     * 
     * @return array
     */
    public function toArray()
    {
        return $this->all();
    }

    /**
     * transform items to a string
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->serialize();
    }

    /**
     * foreach
     * 
     * @param Closure $callback
     */
    public function each(Closure $callback){
        $giveBack = [];
        $returnerFunction = function(string $key, mixed $value){
            return compact('key', 'value');
        };

        foreach ($this->items as $key => $value) {
            $return = $callback($key, $value, $returnerFunction);

            if (is_array($return) && isset($return['key'], $return['value'])) {
                if ($return['key'] != $key) {
                    $this->offsetUnset($key);
                }

                $this->offsetSet($return['key'], $return['value']);
            } elseif ($return == false) {
                break;
            } else {
                $giveBack[] = $return;
            }
        }

        return $giveBack;
    }
}
