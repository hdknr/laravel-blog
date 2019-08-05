<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Todo extends Model
{
    // Meta
    protected $fillable = [
        'title', 'start_at',
        'every_monday', 'every_tuesday', 'every_wednesday', 
        'every_thursday', 'every_friday', 'every_saturday', 'every_sunday',
    ];
    protected $dates = ['start_at', 'closed_at'];

    protected static function boot()
    {
        // Eloquent Events
        // https://laravel.com/docs/5.8/eloquent#events

        parent::boot();

        self::creating(function($instance)
        {
            $now = Carbon::now();
            if ($instance->start_at == null){
                $instance->start_at = $now; 
            }
            $instance->updateStartAt(false);
            return true;
        });

        /*
        self::updating(function($instance){
            return $instance->onUpdating();
        });
        */

        /*
        self::saving(function($instance)
        {
            return $instance->onSaving();
        });
        */

    }

    function shouldUpdateStartAt() {
        return $this->is_closed == false && $this->is_executed;
    }

    function updateStartAt($processed) {
        // 実行したときは $processed == true
        $dow = $this->next_day_of_week;
        $date = Carbon::parse("this ${dow}")->setTime($this->start_at->hour, $this->start_at->minute, $this->start_at->second);
        $date = ($date->lt($this->start_at) || $processed) ? Carbon::parse("next ${dow}"): $date;
        $this->start_at = $date->setTime($this->start_at->hour, $this->start_at->minute, $this->start_at->second);
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

    public function getIsPeriodicAttribute() {
        $days_of_week = $this->days_of_week;
        return $days_of_week && count($days_of_week) > 0;
    }

    public function getIsClosedAttribute() {
        return $this->closed_at != null;
    }

    public function getIsExecutedAttribute() {
        $now = Carbon::now();
        return $this->start_at != null && $now->gte($this->start_at);
    }

    public function getNextDayOfWeekAttribute() {
        if (!$this->is_periodic) {
            return null;
        }
        $dow = strtolower($this->start_at->englishDayOfWeek);
        $days_of_week = array_merge($this->days_of_week, $this->days_of_week);

        $i = array_search('every_'.$dow, $days_of_week);
        $i = ($i === false) ? 0 : ($i + 1);
       
        return str_replace('every_', '', $days_of_week[$i]);
    }
}
