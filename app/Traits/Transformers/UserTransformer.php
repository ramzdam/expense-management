<?php

namespace App\Traits\Transformers;

/**
 * Trait UserTransformer
 *
 * This Trait will be responsible for transforming collection record
 * into a Prettier format to be presented as response
 */
trait UserTransformer
{
    /**
     * Transform the Collection into a readable Array
     *
     * @param  Collection  $record - Retrieve User collection record
     * @return Array
     */
    public function toDetailRecord($record)
    {
        $output = [];

        if (!$record) {
            return $output;
        }

        $output["name"] = $record->name;
        $output["last_name"] = $record->last_name;
        $output["work"] = $record->work;
        $output["email"] = $record->email;
        
        $output["role_access"] = [
            "type" => $record->userRole->role->name,
            "description" => $record->userRole->role->description,
            "can_create_user" => $record->userRole->can_create_user,
            "can_update_user" => $record->userRole->can_update_user,
            "can_delete_user" => $record->userRole->can_delete_user,
            "can_create_expense" => $record->userRole->can_create_expense,
            "can_update_expense" => $record->userRole->can_update_expense,
            "can_delete_expense" => $record->userRole->can_delete_expense,
            "can_create_expense_category" => $record->userRole->can_create_expense_category,
            "can_update_expense_category" => $record->userRole->can_update_expense_category,
            "can_delete_expense_category" => $record->userRole->can_delete_expense_category,
            "can_view_user_management" => $record->userRole->can_view_user_management,
            "can_change_password" => $record->userRole->can_change_password
        ];

        return $output;
    }
}

