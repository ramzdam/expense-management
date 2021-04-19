<?php

namespace App\Traits;

use App\Repositories\ExpenseCategoryRepository;

/**
 * Trait ExpenseCategoryTrait
 *
 * This trait is responsible for handling all validation and conditions
 * that will be used as parameter to retrieve data in a repository
 */
trait ExpenseCategoryTrait
{
    /**
     * Get all Expense Category list
     *
     * @param  ExpenseCategoryRepository  $model - Expense Category Class instance
     * @return Collection/Array
     */
    public function getAll(ExpenseCategoryRepository $model) 
    {
        if (is_null($model)) {
            return ['status' => false, 'message' => 'Model is empty', 'data' => null];
        }

        $result = $model->get();
        return $result;
    }

    /**
     * Get Expense Category
     *
     * @param  ExpenseCategoryRepository  $model - Expense Category Class instance
     * @param  string  $id - Expense Category p_id
     * @return Array
     */
    public function get(ExpenseCategoryRepository $model, $id) 
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
     * Delete Expense Category
     *
     * @param  ExpenseCategoryRepository  $model - Expense Category Class instance
     * @param  string  $pid - Expense Category p_id
     * @return Array
     */
    public function deleteRecord(ExpenseCategoryRepository $model, $pid)
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
     * Update Expense Category
     *
     * @param  ExpenseCategoryRepository  $model - Expense Category Class instance
     * @param  Array                      $record - Filtered form params submitted
     * @param  string                     $pid - Expense Category p_id
     * @return Array
     */
    public function updateRecord(ExpenseCategoryRepository $model, $record, $pid)
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
        
        if (isset($record->description)) {
            $record->description = trim(strip_tags($record->description));
            if ($record->description == "") {
                return ['status' => false, 'message' => 'Description is required', 'data' => null];
            }
            $update_record['description'] = $record->description;
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
     * Save Expense Category
     *
     * @param  ExpenseCategoryRepository  $model - Expense Category Class instance
     * @param  Array  $record - Filtered form params submitted
     * @return Array
     */
    public function save(ExpenseCategoryRepository $model, $record)
    {
        
        if (is_null($model)) {
            return ['status' => false, 'message' => 'Model is empty', 'data' => null];
        }

        if (!$record || is_null($record)) {
            return ['status' => true, 'message' => 'No data to save.', 'data' => null];
        }

        if (!isset($record->name) || is_null($record->name)) {
            return ['status' => false, 'message' => 'Name is required', 'data' => null];
        }

        $description = (isset($record->description) &&  $record->description != "") ? $record->description : "";

        $category_record = [
            'name' => $record->name,
            'description' => $description
        ];
        
        $result = $model->save($category_record);

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
