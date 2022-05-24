<?php

namespace Aeva\Cab\Application\GraphQL\Queries;

use Aeva\Cab\Domain\Repository\Eloquent\Queries\CabRequestRepository;

class CabRequestResolver
{
    private $cabRequestRepository;

    public function __construct(CabRequestRepository $cabRequestRepository)
    {
        $this->cabRequestRepository = $cabRequestRepository;
    }

    public function history($_, array $args)
    {
        return $this->cabRequestRepository->history($args);
    }
}