<?php
/**
 * Created by PhpStorm.
 * User: haitham
 * Date: 01/09/18
 * Time: 08:05 م
 */

namespace App\Presenters\Address;


use App\Address;

class UrlPresenter
{
    protected $address;

    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function __get($key)
    {
        if(method_exists($this, $key))
        {
            return $this->$key();
        }

        return $this->$key;
    }

    public function delete()
    {
        return route('address.destroy', $this->address);
    }

    public function edit()
    {
        return route('address.edit', $this->address);
    }

    public function show()
    {
        return route('address.show', $this->address);
    }

    public function update()
    {
        return route('address.update', $this->address);
    }
}