<?php

namespace App\Http\Interfaces;

/**
 * This interface will be defining the method that will be use by
 * the repositories that will implement this interface
 */
interface RecordInterface
{
    public function save($record);
    public function update($record, $pid);
    public function delete($pid);
    public function get($code = "");
}