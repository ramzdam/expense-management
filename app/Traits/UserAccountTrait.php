<?php

namespace App\Traits;

use App\Repositories\UserRepository;
// use App\Player;

/**
 * Trait PlayerTrait
 *
 * This trait is responsible for handling all validation and conditions
 * that will be used as parameter to retrieve data in a repository
 */
trait UserTrait
{
    public function getAllUser(UserRepository $model) 
    {
        if (is_null($model)) {
            return ['result' => false, 'message' => 'Model is empty', 'data' => null];
        }

        $result = $model->get();
        return $result;
    }
    
    public function deleteRecord(UserRepository $model, $pid)
    {
        if (is_null($model)) {
            return ['result' => false, 'message' => 'Model is empty', 'data' => null];
        }

        if (!$pid) {
            return ['result' => false, 'message' => 'Invalid PID. Please provide a valid PID', 'data' => null];
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

    public function updateRecord(UserRepository $model, $record, $pid)
    {
     
        if (is_null($model)) {
            return ['result' => false, 'message' => 'Model is empty', 'data' => null];
        }

        if (!$record || is_null($record)) {
            return ['result' => true, 'message' => 'No data to save.', 'data' => null];
        }

        if (!$pid) {
            return ['result' => false, 'message' => 'Invalid PID. Please provide a valid PID', 'data' => null];
        }

        $update_record = [];
        
        if (isset($record->firstname)) {
            $record->firstname = trim(strip_tags($record->firstname));
            if ($record->firstname == "") {
                return ['result' => false, 'message' => 'Firstname is required', 'data' => null];
            }
            $update_record['first_name'] = $record->firstname;
        }

        if (isset($record->lastname)) {
            $record->lastname = trim(strip_tags($record->lastname));
            if ($record->lastname == "") {
                return ['result' => false, 'message' => 'Lastname is required', 'data' => null];
            }
            $update_record['last_name'] = $record->lastname;
        }

        if (isset($record->work)) {
            $record->work = trim(strip_tags($record->work));
            if ($record->work == "") {
                return ['result' => false, 'message' => 'Work is required', 'data' => null];
            }
            $update_record['work'] = $record->work;
        }

        if (isset($record->email)) {
            $record->email = trim(strip_tags($record->email));
            if ($record->email == "") {
                return ['result' => false, 'message' => 'Email is required', 'data' => null];
            }
            $update_record['email'] = $record->email;
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
    
    public function save(UserRepository $model, $record)
    {
        if (is_null($model)) {
            return ['result' => false, 'message' => 'Model is empty', 'data' => null];
        }

        if (!$record || is_null($record)) {
            return ['result' => true, 'message' => 'No data to save.', 'data' => null];
        }

        if (!isset($record->firstname) || is_null($record->firstname)) {
            return ['result' => false, 'message' => 'Firstname is required', 'data' => null];
        }

        if (!isset($record->lastname) || is_null($record->lastname)) {
            return ['result' => false, 'message' => 'Lastname is required', 'data' => null];
        }

        if (!isset($record->work) || is_null($record->work)) {
            return ['result' => false, 'message' => 'Work is required', 'data' => null];
        }

        if (!isset($record->email) || is_null($record->email)) {
            return ['result' => false, 'message' => 'Email is required', 'data' => null];
        }

        $user_record = [
            'first_name' => $record->firstname,
            'last_name' => $record->lastname,
            'work' => $record->work,
            'email' => $record->email,
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
