<?php

namespace App\Traits;

use App\Repositories\UserRepository;
use App\Repositories\UserAccountRepository;

/**
 * Trait UserTrait
 *
 * This trait is responsible for handling all validation and conditions
 * that will be used as parameter to retrieve data in a repository
 */
trait UserTrait
{
    /**
     * Get all User record
     *
     * @param  UserRepository  $model - User Repository Class instance
     * @return Collection/Array
     */
    public function getAllUser(UserRepository $model) 
    {
        if (is_null($model)) {
            return ['status' => false, 'message' => 'Model is empty', 'data' => null];
        }

        $result = $model->get();
        return $result;
    }

    /**
     * Get User record
     *
     * @param  UserRepository  $model - User Repository Class instance
     * @param  string  $id - User p_id
     * @return Array
     */
    public function getUser(UserRepository $model, $id) 
    {
        if (is_null($model)) {
            return ['status' => false, 'message' => 'Model is empty', 'data' => null];
        }

        if (!$id) {
            return ['status' => false, 'message' => 'PID is invalid', 'data' => null];
        }

        $result = $model->get($id);
        
        if ($result) {
            return [
                'status' => true,
                'message' => "Record found!",
                'data' => $result
            ];
        }

        return [
            'status' => false,
            'message' => "Record not found!",
            'data' => $result
        ];
    }
    
    /**
     * Delete User record
     *
     * @param  UserRepository  $model - User Repository Class instance
     * @param  string  $pid - User p_id
     * @return Array
     */
    public function deleteRecord(UserRepository $model, $pid)
    {
        if (is_null($model)) {
            return ['status' => false, 'message' => 'Model is empty', 'data' => null];
        }

        if (!$pid) {
            return ['status' => false, 'message' => 'Invalid PID. Please provide a valid PID', 'data' => null];
        }

        $result = $model->delete($pid);

        if ($result['status']) {
            return [
                'status' => true,
                'message' => "Record deleted successfully",
                'data' => $result['data']
            ];
        }

        return $result;
    }

    /**
     * Update User record
     *
     * @param  UserRepository  $model - User Repository Class instance
     * @param  Array   $record - Filtered form params submitted
     * @param  string  $pid - User p_id
     * @return Array
     */
    public function updateRecord(UserRepository $model, $record, $pid)
    {
     
        if (is_null($model)) {
            return ['status' => false, 'message' => 'Model is empty', 'data' => null];
        }

        if (!$record || is_null($record)) {
            return ['status' => true, 'message' => 'No data to save.', 'data' => null];
        }

        if (!$pid) {
            return ['status' => false, 'message' => 'Invalid PID. Please provide a valid PID', 'data' => null];
        }

        $update_record = [];
        
        if (isset($record->name)) {
            $record->name = trim(strip_tags($record->name));
            if ($record->name == "") {
                return ['status' => false, 'message' => 'Firstname is required', 'data' => null];
            }
            $update_record['name'] = $record->name;
        }

        if (isset($record->last_name)) {
            $record->last_name = trim(strip_tags($record->last_name));
            if ($record->last_name == "") {
                return ['status' => false, 'message' => 'Lastname is required', 'data' => null];
            }
            $update_record['last_name'] = $record->last_name;
        }

        if (isset($record->work)) {
            $record->work = trim(strip_tags($record->work));
            if ($record->work == "") {
                return ['status' => false, 'message' => 'Work is required', 'data' => null];
            }
            $update_record['work'] = $record->work;
        }

        if (isset($record->type)) {
            $record->type = trim(strip_tags($record->type));
            if ($record->type == "") {
                return ['status' => false, 'message' => 'Role type is required', 'data' => null];
            }
            $update_record['type'] = $record->type;
        }

        if (isset($record->email)) {
            $record->email = trim(strip_tags($record->email));
            if ($record->email == "") {
                return ['status' => false, 'message' => 'Email is required', 'data' => null];
            }
            $update_record['email'] = $record->email;
        }

        if (isset($record->password)) {
            $record->password = trim(strip_tags($record->password));
            if ($record->password == "") {
                return ['status' => false, 'message' => 'Password is required', 'data' => null];
            }

            if ($record->password != $record->password_confirmation) {
                return ['status' => false, 'message' => 'Confirm password does not match', 'data' => null];
            }
            $update_record['password'] = $record->password;
        }

        $result = $model->update($update_record, $pid);

        if ($result['status']) {
            return [
                'status' => true,
                'message' => "Record updated successfully",
                'data' => $result['data']
            ];
        }

        return $result;
    }
    
    /**
     * Save a User record
     *
     * @param  UserRepository  $model - User Repository Class instance
     * @param  Array   $record - Filtered form params submitted
     * @return Array
     */
    public function save(UserRepository $model, $record)
    {
        
        if (is_null($model)) {
            return ['status' => false, 'message' => 'Model is empty', 'data' => null];
        }

        if (!$record || is_null($record)) {
            return ['status' => true, 'message' => 'No data to save.', 'data' => null];
        }

        if (!isset($record->name) || is_null($record->name)) {
            return ['status' => false, 'message' => 'Firstname is required', 'data' => null];
        }

        if (!isset($record->last_name) || is_null($record->last_name)) {
            return ['status' => false, 'message' => 'Lastname is required', 'data' => null];
        }

        if (!isset($record->work) || is_null($record->work)) {
            return ['status' => false, 'message' => 'Work is required', 'data' => null];
        }

        if (!isset($record->email) || is_null($record->email)) {
            return ['status' => false, 'message' => 'Email is required', 'data' => null];
        }

        if (!isset($record->password) || is_null($record->password)) {
            return ['status' => false, 'message' => 'Password is required', 'data' => null];
        }

        $type = (!isset($record->type) || !$record->type) ? "User" : $record->type;
        
        $user_record = [
            'name' => $record->name,
            'last_name' => $record->last_name,
            'work' => $record->work,
            'email' => $record->email,
            'password' => $record->password,
            'account_type' => $type
        ];
        
        $result = $model->save($user_record);

        if ($result['status']) {
            
            return [
                'status' => true,
                'message' => "Record saved successfully",
                'data' => $result['data']
            ];
        }

        return $result;
    }
}
