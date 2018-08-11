<?php
/**
 * Created by PhpStorm.
 * User: haitham
 * Date: 11/08/18
 * Time: 08:40 م
 */

namespace App\Interfaces;


interface Accountable
{
    public function dueTo();

    public function dueFor();
}