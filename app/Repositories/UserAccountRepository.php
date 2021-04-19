<?php
/**
 * Class UserAccountRepository
 */

namespace App\Repositories;
use App\User;
use App\UserAccount;
use App\Http\Interfaces\RecordInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class UserAccountRepository
 */
class UserAccountRepository implements RecordInterface
{

    public function __construct(UserAccount $model)
    {
    }

    /**
     * Delete the specified User Account from storage.
     *
     * @param  string  $pid - User Account p_id
     * @return Array
     */
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

    /**
     * Update the specified user account from storage.
     *
     * @param  array   $record - Filtered form params submitted
     * @param  string  $pid - User Account p_id
     * @return Array
     */
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

            if (isset($record['first_name'])) {
                $user->first_name = $record['first_name'];
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
            
            $result = $user->save();

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
     * Save specified records based from records
     *
     * @param Array $records - Filtered form params submitted
     * @return Array
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

            if (isset($record['first_name'])) {
                $user->first_name = $record['first_name'];
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
            $user->userAccount()->p_id = Str::uuid();
            $user->userAccount()->username = $record['username'];
            $user->userAccount()->password = $record['password'];
            $result = $user->save();

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

    /**
     * Check if email exist
     *
     * @param  string  $email - The email to check
     * @param  string  $pid - User Account p_id
     * @return Boolean
     */
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
     * Get user account record by code
     *
     * @param String $code - User Account p_id
     * @return Collection
     */
    public function get($code = "")
    {

        if ($code) {

        }
        
        $users = User::all();

        return $users;
    }
}