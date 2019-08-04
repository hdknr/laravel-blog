<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'title',
        'every_monday', 'every_tuesday', 'every_wednesday', 
        'every_thursday', 'every_friday', 'every_saturday', 'every_sunday',
    ];

    function startsWith($str, $prefix) {
        return substr($str,  0, strlen($prefix)) === $prefix;
    }

    public function getDaysOfWeekAttribute() {
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable()); 
        return array_values(array_filter($columns, function($i){
            return $this->startsWith($i, 'every_') && $this->getAttribute($i) == true;
        }));
    }
}
