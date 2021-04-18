<?php
/**
 * Class UserRepository
 */

namespace App\Repositories;

use App\User;
use App\UserAccount;
use App\UserRole;
// use App\Traits\ModelTrait;
use App\Traits\Transformers\UserTransformer;
use App\Http\Interfaces\RecordInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class UserRepository
 */
class UserRepository implements RecordInterface
{
    use UserTransformer;

    public function __construct(User $model)
    {
        // $this->setModel($model);
    }

    public function delete($pid)
    {
        try {
            
            $user = User::where('p_id', $pid)->first();

            if (!$user) 
            {
                return [
                    'message' => 'Failed to delete record. PID is invalid',
                    'data' => null,
                    'status' => false
                ];
            }
            
            $result = $user->delete();

            if ($result) {
                return [
                    'message' => 'Record deleted succesfully',
                    'data' => null,
                    'status' => true
                ];
            }

            return [
                'message' => 'Failed to delete record',
                'data' => null,
                'status' => false
            ];
        } catch(\Exception $e) {
            Log::error("An error has occured: " . $e->getMessage());
            return [
                'message' => 'Failed to delete record',
                'data' => null,
                'status' => false
            ];
        }
    }

    public function update($record, $pid) 
    {
        try {
            
            if (isset($record['email']) && $this->isEmailExist($record['email'], $pid)) {
                return [
                    'message' => 'Email Address already in use',
                    'data' => null,
                    'status' => false
                ];
            }

            $user = User::where('p_id', $pid)->first();

            if (isset($record['name'])) {
                $user->name = $record['name'];
            }

            if (isset($record['last_name'])) {
                $user->last_name = $record['last_name'];
            }

            if (isset($record['work'])) {
                $user->work = $record['work'];
            }

            if (isset($record['email'])) {
                $user->email = $record['email'];
            }

            if (isset($record['password'])) {                
                $user->password = Hash::make($record['password']);
            }

            if (isset($record['type'])) {
                
                if (strtolower($record['type']) == 'administrator') {
                    $user->userRole->role_id = UserRole::ADMIN;
                    $user->userRole->can_create_user = true;
                    $user->userRole->can_update_user = true;
                    $user->userRole->can_delete_user = true;
                    $user->userRole->can_create_expense = true;
                    $user->userRole->can_update_expense = true;
                    $user->userRole->can_delete_expense = true;
                    $user->userRole->can_create_expense_category = true;
                    $user->userRole->can_update_expense_category = true;
                    $user->userRole->can_delete_expense_category = true;
                    $user->userRole->can_view_user_management = true;
                    $user->userRole->can_change_password = false;
                } else {
                    $user->userRole->role_id = UserRole::USER;
                    $user->userRole->can_create_user = false;
                    $user->userRole->can_update_user = false;
                    $user->userRole->can_delete_user = false;
                    $user->userRole->can_create_expense = true;
                    $user->userRole->can_update_expense = true;
                    $user->userRole->can_delete_expense = true;
                    $user->userRole->can_create_expense_category = false;
                    $user->userRole->can_update_expense_category = false;
                    $user->userRole->can_delete_expense_category = false;
                    $user->userRole->can_view_user_management = false;
                    $user->userRole->can_change_password = true;
                }

                
            }
            
            $result = $user->push();

            if ($result) {
                return [
                    'message' => 'Saving successful',
                    'data' => $user,
                    'status' => true
                ];
            }

            return [
                'message' => 'Failed to save record',
                'data' => null,
                'status' => false
            ];
        } catch(\Exception $e) {
            Log::error("An error has occured: " . $e->getMessage());
            return [
                'message' => 'Failed to update record',
                'data' => null,
                'status' => false
            ];
        }
    }
    /**
     * Save the records based from the detail received from API
     *
     * @param Array $records
     * @return Boolean
     */
    public function save($record)
    {
        try {
            if ($this->isEmailExist($record['email'])) {
                return [
                    'message' => 'Email Address already in use',
                    'data' => null,
                    'status' => false
                ];
            }

            $user = new User;

            if (isset($record['name'])) {
                $user->name = $record['name'];
            }

            if (isset($record['last_name'])) {
                $user->last_name = $record['last_name'];
            }

            if (isset($record['work'])) {
                $user->work = $record['work'];
            }

            if (isset($record['email'])) {
                $user->email = $record['email'];
            }
            
            $user->p_id = Str::uuid(); // This should be in the mutator setter but somehow it's not working
            $user->password = Hash::make($record['password']);
            $user->save();
            $userRole = $this->getUserRoleObject($record);
            $result = $user->userRole()->save($userRole);
            

            if ($result) {
                return [
                    'message' => 'Saving successful',
                    'data' => $user,
                    'status' => true
                ];
            }

            return [
                'message' => 'Failed to save record',
                'data' => null,
                'status' => false
            ];
        } catch(\Exception $e) {
            Log::error("An error has occured: " . $e->getMessage());
            return [
                'message' => 'Failed to save record',
                'data' => null,
                'status' => false
            ];
        }
    }

    private function getUserAccountObject($record)
    {
        $userAccount = new UserAccount;
        $userAccount->p_id = Str::uuid();
        $userAccount->username = $record['email'];
        $userAccount->password = $record['password'];

        return $userAccount;
    }

    private function getUserRoleObject($record)
    {
        $userRole = new UserRole;

        if (strtolower($record['account_type']) == "administrator") {
            $userRole->p_id = Str::uuid();
            $userRole->role_id = UserRole::ADMIN;
            $userRole->can_create_user = true;
            $userRole->can_update_user = true;
            $userRole->can_delete_user = true;
            $userRole->can_create_expense = true;
            $userRole->can_update_expense = true;
            $userRole->can_delete_expense = true;
            $userRole->can_create_expense_category = true;
            $userRole->can_update_expense_category = true;
            $userRole->can_delete_expense_category = true;
            $userRole->can_view_user_management = true;
            $userRole->can_change_password = false;
        } else {
            $userRole->p_id = Str::uuid();
            $userRole->role_id = UserRole::USER;
            $userRole->can_create_user = false;
            $userRole->can_update_user = false;
            $userRole->can_delete_user = false;
            $userRole->can_create_expense = true;
            $userRole->can_update_expense = true;
            $userRole->can_delete_expense = true;
            $userRole->can_create_expense_category = false;
            $userRole->can_update_expense_category = false;
            $userRole->can_delete_expense_category = false;
            $userRole->can_view_user_management = false;
            $userRole->can_change_password = true;
        }
        
        return $userRole;
    }

    public function isEmailExist($email, $pid = "")
    {
        if (!$email) {
            return false;
        }

        $user = User::where('email', $email);

        if ($pid) {
            $user = $user->where('p_id', '!=', $pid);
        }

        $exist = $user->where('deleted_at', NULL)->first();

        if ($exist) {
            return true;
        }

        return false;
    }

    /**
     * Get record by code
     *
     * @param String $code
     * @return Collection
     */
    public function getDetailByCode($code) 
    {
        // try {
        //     if (!$code) {
        //         return null;
        //     }

        //     $playerModel = $this->getModel();
        //     $player = $playerModel::find($code);
           
        //     return $player;

        // } catch(\Exception $e) {
        //     Log::error("An error has occured: " . $e->getMessage());
        //     return null;
        // }
    }

    /**
     * Retrieve all player records
     *
     * @return Array[Collection]
     */
    public function getAll()
    {
        // try {
        //     $playerModel = $this->getModel();
        //     $players = $playerModel::with(['detail'])->get();
        //     $records = [];
                        
        //     foreach ($players as $player) {
        //         $records[] = $this->transformRecord($player);
        //     }

        //     return $records;
        // } catch (\Exception $e) {
        //     Log::error("An error has occured: " . $e->getMessage());
        //     return null;
        // }
    }

    /**
     * Get player record by code
     *
     * @param String $code
     * @return Collection
     */
    public function get($code = "")
    {
        if ($code) {
            return User::where('p_id', $code)->first();
        }
        
        $users = User::all();

        return $users;
    }
}