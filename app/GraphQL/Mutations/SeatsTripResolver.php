<?php

namespace App\GraphQL\Mutations;

use App\SeatsTrip;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;

class SeatsTripResolver
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function create($_, array $args)
    {
        DB::beginTransaction();
        try {
            $input = Arr::except($args, ['directive']);
            $trip = $this->createTrip($input);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            throw new CustomException('We could not able to create this trip!');
        }

        return $trip;
    }

    public function update($_, array $args)
    {
        try {
            $tripInput = Arr::except($args, ['directive']);
            $trip = SeatsTrip::findOrFail($args['id']);
            $trip->update($tripInput);
        } catch (ModelNotFoundException $e) {
            throw new CustomException('Trip with the provided ID is not found.');
        }

        return $trip;
    }

    public function copy($_, array $args)
    {
        DB::beginTransaction();
        try {
            $trip = $this->createTripCopy($args);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            throw new CustomException('We could not able to copy this trip!');
        }

        return $trip;
    }

    protected function createTrip($input)
    {
        return SeatsTrip::create($input);
    }

    protected function createTripCopy(array $args)
    {
        $originalTrip = SeatsTrip::select(
            'line_id', 'partner_id', 'driver_id', 'vehicle_id', 'start_date', 'end_date', 
            'days', 'bookable', 'route', 'price'
            )
            ->findOrFail($args['id'])
            ->toArray();

        $originalTrip['name'] = $args['name'];
        
        return $this->createTrip($originalTrip);
    }
}