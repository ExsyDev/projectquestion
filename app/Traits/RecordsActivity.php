<?php

namespace App\Traits;

use App\Activity;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (self::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
          'user_id' => auth()->user()->id,
          'type' => $this->getActivityType($event),
        ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }
}
