<?php

namespace App\Traits;

use App\Repositories\UserExpenseRepository;

/**
 * Trait UserExpenseTrait
 *
 * This trait is responsible for handling all validation and conditions
 * that will be used as parameter to retrieve data in a repository
 */
trait UserExpenseTrait
{
    /**
     * Get Expense Chart total expense
     *
     * @param  UserExpenseRepository  $model - User Expense Repository Class instance
     * @return Array
     */
    public function getExpenseChart(UserExpenseRepository $model)
    {
        if (is_null($model)) {
            return ['status' => false, 'message' => 'Model is empty', 'data' => null];
        }

        $result = $model->getChart();
        return $result;
    }

    /**
     * Get all User Expense record by user p_id
     *
     * @param  UserExpenseRepository  $model - User Expense Repository Class instance
     * @param  string  $pid - User p_id
     * @return Array
     */
    public function getAll(UserExpenseRepository $model, $pid) 
    {
        if (is_null($model)) {
            return ['status' => false, 'message' => 'Model is empty', 'data' => null];
        }

        if (!$pid) {
            return ['status' => false, 'message' => 'PID is invalid', 'data' => null];
        }

        $result = $model->get($pid);
        return $result;
    }

    /**
     * Get all User Expense
     *
     * @param  UserExpenseRepository  $model - User Expense Repository Class instance
     * @return Collection
     */
    public function getAllExpense(UserExpenseRepository $model)
    {
        return $model->get();
    }

    /**
     * Get Expense
     *
     * @param  UserExpenseRepository  $model - User Expense Repository Class instance
     * @param  string  $expense_pid - Expense p_id
     * @return Array
     */
    public function getExpense(UserExpenseRepository $model, $expense_pid)
    {
        return $model->getExpense($expense_pid);
    }

    /**
     * Get User record
     *
     * @param  UserExpenseRepository  $model - User Expense Repository Class instance
     * @param  string  $id - User p_id
     * @return Array
     */
    public function getUser(UserExpenseRepository $model, $id) 
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
     * Delete User Expense record
     *
     * @param  UserExpenseRepository  $model - User Expense Repository Class instance
     * @param  string   $user_id - Auth user p_id
     * @param  string  $pid - User p_id
     * @return Array
     */
    public function deleteRecord(UserExpenseRepository $model, $user_id, $pid)
    {
        if (is_null($model)) {
            return ['status' => false, 'message' => 'Model is empty', 'data' => null];
        }

        if (!$user_id) {
            return ['status' => false, 'message' => 'Invalid user id. Please provide a valid id', 'data' => null];
        }

        if (!$pid) {
            return ['status' => false, 'message' => 'Invalid PID. Please provide a valid PID', 'data' => null];
        }

        $result = $model->deleteRecord($user_id, $pid);

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
     * Update User Expense record
     *
     * @param  UserExpenseRepository  $model - User Expense Repository Class instance
     * @param  Array   $record - Filtered form params submitted
     * @param  string  $user_id - Auth User p_id
     * @param  string  $pid - User p_id
     * @return Array
     */
    public function updateRecord(UserExpenseRepository $model, $record, $user_id, $pid)
    {
     
        if (is_null($model)) {
            return ['status' => false, 'message' => 'Model is empty', 'data' => null];
        }

        if (!$record || is_null($record)) {
            return ['status' => true, 'message' => 'No data to save.', 'data' => null];
        }

        if (!$user_id) {
            return ['status' => false, 'message' => 'Invalid user id. Please provide a valid user id', 'data' => null];
        }

        if (!$pid) {
            return ['status' => false, 'message' => 'Invalid PID. Please provide a valid PID', 'data' => null];
        }

        $update_record = [];

        if (isset($record->amount)) {
            $record->amount = trim(strip_tags($record->amount));
            if ($record->amount <= 0) {
                return ['status' => false, 'message' => 'Amount is required', 'data' => null];
            }
            $update_record['amount'] = $record->amount;
        }

        if (isset($record->expense_type)) {
            $record->expense_type = trim(strip_tags($record->expense_type));
            if ($record->expense_type == "") {
                return ['status' => false, 'message' => 'Expense type is required', 'data' => null];
            }
            $update_record['expense_type'] = $record->expense_type;
        }

        $result = $model->updateRecord($update_record, $user_id, $pid);

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
     * Save User Expense
     *
     * @param  UserExpenseRepository  $model - User Expense Repository Class instance
     * @param  Array   $record - Filtered form params submitted
     * @param  string  $user_pid - User p_id
     * @return Array
     */
    public function save(UserExpenseRepository $model, $record, $user_pid)
    {
        
        if (is_null($model)) {
            return ['status' => false, 'message' => 'Model is empty', 'data' => null];
        }

        if (!$record || is_null($record)) {
            return ['status' => true, 'message' => 'No data to save.', 'data' => null];
        }

        if (!$user_pid || is_null($user_pid)) {
            return ['status' => true, 'message' => 'PID is required', 'data' => null];
        }

        if (!isset($record->expense_type) || is_null($record->expense_type)) {
            return ['status' => false, 'message' => 'Expense type is required', 'data' => null];
        }

        if (!isset($record->amount) || is_null($record->amount) || $record->amount <= 0) {
            return ['status' => false, 'message' => 'Amount is required', 'data' => null];
        }
        
        $user_record = [
            'expense_type' => $record->expense_type,
            'amount' => $record->amount,
            'pid' => $user_pid,
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
