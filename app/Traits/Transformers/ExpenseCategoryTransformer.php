<?php

namespace App\Traits\Transformers;

/**
 * Trait PlayerTransformer
 *
 * This Trait will be responsible for transforming collection record
 * into a Prettier format to be presented as response
 */
trait ExpenseCategoryTransformer
{
    public function toDetailRecord($record)
    {
        $output = [];

        if (!$record) {
            return $output;
        }

        $output["name"] = $record->name;
        $output["description"] = $record->description;
        $output["p_id"] = $record->p_id;
        
        return $output;
    }
}

