<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Todo extends Model
{
    protected $fillable = [
        'title',
        'every_monday', 'every_tuesday', 'every_wednesday', 
        'every_thursday', 'every_friday', 'every_saturday', 'every_sunday',
    ];
     protected static function boot()
    {
        // Eloquent Events
        // https://laravel.com/docs/5.8/eloquent#events

        parent::boot();

        /*
        self::creating(function($instance)
        {
            return $instance->onUpdating();
        });

        self::updating(function($instance){
            return $instance->onUpdating();
        });
        */

        self::saving(function($instance)
        {
            return $instance->onSaving();
        });

    }

    function onSaving() {
        $now = Carbon::now();
        if ($this->start_at == null){
           $this->start_at = $now; 
        }
        return true;            // false -> not save
    }

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
