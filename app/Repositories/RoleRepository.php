<?php
/**
 * Class UserRepository
 */

namespace App\Repositories;

use App\Role;
// use App\Traits\ModelTrait;
use App\Traits\Transformers\UserTransformer;
use App\Http\Interfaces\RecordInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class UserRepository
 */
class RoleRepository implements RecordInterface
{

    public function __construct(Role $model)
    {
    }
    public function save($record) {}
    public function update($record, $pid){}
    public function delete($pid) {}
    /**
     * Get Role record by code
     *
     * @param String $code - Role p_id
     * @return Collection
     */
    public function get($code = "")
    {
        if ($code) {
            return Role::where('p_id', $code)->first();
        }
        
        $roles = Role::all();

        return $roles;
    }
}