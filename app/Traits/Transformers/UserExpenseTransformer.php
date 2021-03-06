<?php

namespace App\Traits\Transformers;

/**
 * Trait UserExpenseTransformer
 *
 * This Trait will be responsible for transforming collection record
 * into a Prettier format to be presented as response
 */
trait UserExpenseTransformer
{
    /**
     * Transform the Collection into a readable Array
     *
     * @param  Collection  $total_expense - Total User Expense
     * @param  Collection  $expenses - User Expenses
     * @param  Collection  $categories - Expense Categories
     * @return Array
     */
    public function toDetailRecord($total_expense, $expenses, $categories)
    {
        $output = [];

        foreach($categories as $category) {
            $output[$category->id] = [
                'p_id' => $category->p_id,
                'name' => $category->name,
                'description' => $category->description,
                'total_expense' => 0,
                'data' => []
            ];
        }


        foreach($total_expense as $expense) {
            $output[$expense->expense_category_id]['total_expense'] = $expense->total_expense;
        }

        foreach($expenses as $expense) {
            $output[$expense->expense_category_id]['data'][] = [
                'amount' => $expense->amount,
                'date' => date('m-d-Y H:m:s', strtotime($expense->created_at)),
                'p_id' => $expense->p_id
            ];
        }
        
        return array_values($output);
    }

    /**
     * Transform the Collection into a readable Array
     *
     * @param  Collection  $total_expense - Total User Expense computed
     * @param  Collection  $categories - Expense Categories
     * @return Array
     */
    public function toChartRecord($total_expense, $categories)
    {
        $output = [];

        foreach($categories as $category) {
            $output[$category->id] = [
                'p_id' => $category->p_id,
                'name' => $category->name,
                'description' => $category->description,
                'total_expense' => 0,
                'data' => []
            ];
        }


        foreach($total_expense as $expense) {
            $output[$expense->expense_category_id]['total_expense'] = $expense->total_expense;
        }
        
        $chart = [];

        foreach($output as $data) {
            $chart[] = [
                "label"=> $data["name"],
                "y"=> $data["total_expense"]
            ];
        }
   
        return array_values($chart);
    }
}

