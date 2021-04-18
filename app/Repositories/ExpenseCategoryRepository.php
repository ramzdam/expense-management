<?php
/**
 * Class ExpenseCategoryRepository
 */

namespace App\Repositories;

use App\ExpenseCategory;
use App\Http\Interfaces\RecordInterface;
use App\Traits\Transformers\ExpenseCategoryTransformer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class ExpenseCategoryRepository
 */
class ExpenseCategoryRepository implements RecordInterface
{
    use ExpenseCategoryTransformer;
    
    public function __construct(ExpenseCategory $model)
    {
    }

    public function delete($pid)
    {
        try {
            
            $category = ExpenseCategory::where('p_id', $pid)->first();

            if (!$category) 
            {
                return [
                    'message' => 'Failed to delete record. PID is invalid',
                    'data' => null,
                    'status' => false
                ];
            }
            
            $result = $category->delete();

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
            
            $category = ExpenseCategory::where('p_id', $pid)->first();

            if (isset($record['description'])) {
                $category->description = $record['description'];
            }

            $result = $category->push();

            if ($result) {
                return [
                    'message' => 'Saving successful',
                    'data' => $category,
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
            if ($this->isNameExist($record['name'])) {
                return [
                    'message' => 'Expense category name already in use',
                    'data' => null,
                    'status' => false
                ];
            }

            $category = new ExpenseCategory;

            if (isset($record['name'])) {
                $category->name = $record['name'];
            }

            if (isset($record['description'])) {
                $category->description = $record['description'];
            }

            $category->p_id = Str::uuid(); // This should be in the mutator setter but somehow it's not working
            $result = $category->save();

            if ($result) {
                return [
                    'message' => 'Saving successful',
                    'data' => $category,
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

    public function isNameExist($name)
    {
        if (!$name) {
            return false;
        }

        $category = ExpenseCategory::where('name', $name)->first();

        if ($category) {
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
     * Get player record by code
     *
     * @param String $code
     * @return Collection
     */
    public function get($code = "")
    {
        if ($code) {
            return $this->toDetailRecord(ExpenseCategory::where('p_id', $code)->first());
        }
        
        $category = ExpenseCategory::orderBy('name', 'asc')->get();

        return $category;
    }
}