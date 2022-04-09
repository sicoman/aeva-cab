<?php

namespace App\Repository\Eloquent\Queries;

use App\CabRequestTransaction;
use App\Repository\Eloquent\BaseRepository;
use App\Traits\Filterable;


class CabRequestTransactionRepository extends BaseRepository
{
    use Filterable;
    
    public function __construct(CabRequestTransaction $model)
    {
        parent::__construct($model);
    }

    public function stats(array $args)
    {
        $transactions = $this->model->query();

        $transactionGroup = $this->model->selectRaw('
            DATE_FORMAT(created_at, "%d %b %Y") as x,
            ROUND(SUM(amount), 2) as y
        ');

        if (array_key_exists('period', $args) && $args['period']) {
            $transactions = $this->dateFilter($args['period'], $transactions, 'created_at');
            $transactionGroup = $this->dateFilter($args['period'], $transactionGroup, 'created_at');
        }

        $transactionCount = $transactions->count();
        $transactionSum = $transactions->sum('amount');
        $transactionGroup = $transactionGroup->groupBy('x')->get();

        $response = [
            'count' => $transactionCount,
            'sum' => round($transactionSum, 2),
            'transactions' => $transactionGroup
        ];

        return $response;
    }
}