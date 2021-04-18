<?php
/**
 * Class UserExpenseRepository
 */

namespace App\Repositories;

use App\User;
use App\Expense;
use App\ExpenseCategory;
use App\Traits\Transformers\UserExpenseTransformer;
use App\Http\Interfaces\RecordInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class UserExpenseRepository
 */
class UserExpenseRepository implements RecordInterface
{
    use UserExpenseTransformer;

    public function __construct(Expense $model)
    {
        // $this->setModel($model);
    }

    public function deleteRecord($user_id, $pid) 
    {
        try {
            $user = User::where('p_id', $user_id)->first();
            $expense = Expense::where('p_id', $pid)->where('user_id', $user->id)->first();

            if (!$expense) 
            {
                return [
                    'message' => 'Failed to delete record. PID is invalid',
                    'data' => null,
                    'status' => false
                ];
            }
            
            $result = $expense->delete();

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

    public function delete($pid)
    {
        
    }

    public function updateRecord($record, $user_id, $pid)
    {
        try {
            
            $user = User::where('p_id', $user_id)->first();
            $expense = Expense::where('p_id', $pid)->where('user_id', $user->id)->first();
            $category = ExpenseCategory::where('p_id', $record['expense_type'])->first();

            if (isset($record['amount'])) {
                $expense->amount = $record['amount'];
            }

            if (isset($record['expense_type'])) {                
                $expense->expense_category_id = $category->id;
            }
            
            $result = $expense->push();

            if ($result) {
                return [
                    'message' => 'Saving successful',
                    'data' => $expense,
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

    public function update($record, $pid) 
    {
       
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
            
            $user = User::where('p_id', $record['pid'])->first();

            if (!$user) {
                return [
                    'message' => 'PID is invalid user does not exist.',
                    'data' => null,
                    'status' => false
                ];
            }

            $category = ExpenseCategory::where('p_id', $record["expense_type"])->first();

            if (!$category) {
                return [
                    'message' => 'Expense category does not exist',
                    'data' => null,
                    'status' => false
                ];
            }

            $expense = new Expense;            
            $expense->p_id = Str::uuid(); // This should be in the mutator setter but somehow it's not working
            $expense->user_id = $user->id;
            $expense->expense_category_id = $category->id;
            $expense->amount = $record["amount"];
            $result = $expense->save();

            if ($result) {
                return [
                    'message' => 'Saving successful',
                    'data' => $expense,
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
     * Get player record by code
     *
     * @param String $code
     * @return Collection
     */
    public function getAll()
    {
        return Expense::all();
    }

    public function getExpense($expense_pid)
    {
        if (!$expense_pid) {
            return [];
        }
        
        $result = Expense::where('p_id', $expense_pid)->first();

        return $result;
    }
    /**
     * Get player record by code
     *
     * @param String $code
     * @return Collection
     */
    public function get($code = '')
    {
        if (!$code) {
            return Expense::all();
        }

        $user = User::where('p_id', $code)->first();

        if (!$user) {
            return [];
        }

        $total_expense = Expense::where('user_id', $user->id)
            ->selectRaw("SUM(amount) as total_expense, expense_category_id")
            ->groupBy('expense_category_id')
            ->get();

        $expense_category = ExpenseCategory::all();
        $expense = Expense::where('user_id', $user->id)->get();
        
        return $this->toDetailRecord($total_expense, $expense, $expense_category);
    }

    public function getChart()
    {

        $total_expense = Expense::selectRaw("SUM(amount) as total_expense, expense_category_id")
            ->groupBy('expense_category_id')
            ->get();

        $expense_category = ExpenseCategory::all();
        
        return $this->toChartRecord($total_expense, $expense_category);
    }
}