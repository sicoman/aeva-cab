<?php

namespace App\Repository\Eloquent\Mutations;

use App\StudentSubscription;
use App\BusinessTripSchedule;
use App\BusinessTripAttendance;
use App\Exceptions\CustomException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repository\Eloquent\BaseRepository;

class StudentSubscriptionRepository extends BaseRepository
{
    public function __construct(StudentSubscription $model)
    {
        parent::__construct($model);
    }

    public function create(array $args)
    {
        $input = collect($args)->except(['directive'])->toArray();

        if(array_key_exists('days', $input))
            $input['days'] = json_encode($args['days']);
        else 
        {
            $schedule = BusinessTripSchedule::where('trip_id', $args['trip_id'])
                ->where('user_id', $args['user_id'])->first();

            if($schedule != null)
                $input['days'] = json_encode($schedule->days);
                
            else throw new CustomException(__('lang.trip_schedule_required'));
        } 
        
        return $this->model->create($input);
    }

    public function update(array $args)
    {
        $input = collect($args)->except(['id', 'directive'])->toArray();
        
        if(array_key_exists('days', $input))
            $input['days'] = json_encode($input['days']);

        try {
            $subscription = $this->model->findOrFail($args['id']);
        } catch (ModelNotFoundException $e) {
            throw new \Exception(__('lang.student_subscription_not_found'));
        }

        $subscription->update($input);

        return $subscription;
    }

    public function reschedule(array $args)
    {
        return $this->model->where('student_id', $args['student_id'])
            ->where('trip_id', $args['trip_id'])->where('user_id', $args['user_id'])
            ->update(['days' => json_encode($args['days'])]);        
    }

    public function destroy(array $args)
    {
        return $this->model->where('id', $args['id'])->delete();
    }
}