<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Mutations\MutationWithAuthAbstract;
use App\Helpers\Sanitizer;
use App\Services\CarService\BookingService;
use App\Entities\Booking\MakeBookingDTO;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class MakeBookingMutation extends MutationWithAuthAbstract
{
    /**
     * @var string[]
     */
    protected $attributes = [
        'name' => 'makeBooking',
        'description' => 'Мутация создания бронирования',
    ];

    /**
     * Возвращаемый тип мутации
     *
     * @return Type
     */
    public function type(): Type
    {
        return Type::boolean();
    }

    /**
     * Аргументы мутации
     *
     * @return array[]
     */
    public function args(): array
    {
        return [
            'input' => [
                'type' => GraphQL::type('MakeBookingInput'),
            ],
        ];
    }

    /**
     * Резолвер для мутации
     *
     * @param $args
     * @return bool
     */
    public function resolve($args):bool
    {
        $data = new MakeBookingDTO(
            $args['input']['date'],
            $args['input']['period']['start'],
            $args['input']['period']['end'],
            $args['input']['carServiceID'],
            $args['input']['liftID'] ?? 0,
            !empty($args['input']['needMaster']),
            !empty($args['input']['needEquipments']),
            !empty($args['input']['comment']) ? Sanitizer::stringSpecialChars($args['input']['comment']) : '',
        );

        return (new BookingService())->makeBooking($data);
    }
}
