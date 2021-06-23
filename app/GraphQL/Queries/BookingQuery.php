<?php

namespace App\GraphQL\Queries;

use App\GraphQL\Queries\QueryWithAuthAbstract;
use App\Models\User;
use Closure;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;

class BookingQuery extends QueryWithAuthAbstract
{
    /**
     * @var string[]
     */
    protected $attributes = [
        'name' => 'booking',
        'description' => 'Получение истории бронирований СТСО',
    ];

    /**
     * Возвращаемый тип
     *
     * @return Type
     */
    public function type(): Type
    {
        return GraphQL::type('Booking');
    }

    /**
     * Аргументы запроса
     *
     * @return array[]
     */
    public function args(): array
    {
        return [
            'bookingID' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'ID бронирования',
            ],
        ];
    }

    /**
     * Резолвер для запроса
     *
     * @param $args
     * @return Booking
     */
    public function resolve($args): Booking
    {
        return Auth::user()->findBookingById($args['bookingID']);
    }
}
