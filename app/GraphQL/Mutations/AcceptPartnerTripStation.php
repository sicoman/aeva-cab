<?php

namespace App\GraphQL\Mutations;

use App\PartnerTripStation;
use App\PartnerTripStationUser;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class AcceptPartnerTripStation
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $station = PartnerTripStation::where('id', $args['station_id'])->first();

        $station->update(['accepted_at' => now()]);

        PartnerTripStationUser::where('trip_id', $args['trip_id'])
            ->where('user_id', $station['created_by'])->update(['station_id' => $args['station_id']]);
            
        return $station;
    }
}