<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait GeneratesSequentialId
{
    /**
     * Generate a sequential ID with a prefix (e.g., PJ-0001).
     */
    public static function generateId($prefix, $column = null)
    {
        $instance = new static();
        $column = $column ?: $instance->getKeyName();
        $table = $instance->getTable();

        $lastRecord = DB::table($table)
            ->where($column, 'LIKE', $prefix . '-%')
            ->orderBy($column, 'desc')
            ->first();

        if (!$lastRecord) {
            return $prefix . '-0001';
        }

        $lastId = $lastRecord->$column;
        $lastNumber = (int) substr($lastId, strlen($prefix) + 1);
        $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return $prefix . '-' . $nextNumber;
    }
}
