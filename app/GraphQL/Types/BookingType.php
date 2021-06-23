<?php

namespace App\GraphQL\Types;

use App\Models\Booking\Booking;
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BookingType extends GraphQLType
{
    /**
     * @var string[]
     */
    protected $attributes = [
        'name'          => 'Booking',
        'description'   => 'Информация о бронировании СТСО',
        'model'         => Booking::class,
    ];

    /**
     * Доступные поля для типа
     *
     * @return array[]
     */
    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'ID бронирования',
            ],
            'carService' => [
                'type' => Type::nonNull(GraphQL::type('CarService')),
                'description' => 'СТСО',
            ],
            'cost' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'Итоговая стоимость',
            ],
            'date' => [
                'type' => GraphQL::type('Date'),
                'description' => 'Дата бронирования',
                'selectable' => false,
            ],
            'times' => [
                'type' => GraphQL::type('Period'),
                'description' => 'Время начала и окончания',
                'is_relation' => false,
                'type_fields_aliases' => [
                    'start' => 'starts_at',
                    'end' => 'ends_at',
                ],
            ],
            'lift' => [
                'type' => GraphQL::type('CarServiceLift'),
                'description' => 'Подъемник',
            ],
            'needMaster' => [
                'alias' => 'need_master',
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Требуется ли мастер',
            ],
            'needEquipments' => [
                'alias' => 'need_equipments',
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Требуется ли оборудование',
            ],
            'comment' => [
                'type' => Type::string(),
                'description' => 'Комментарий',
            ],
            'equipments' => [
                'type' => Type::listOf(GraphQL::type('BookingEquipment')),
                'description' => 'Список оборудования',
            ],
            'status' => [
                'type' => GraphQL::type('BookingStatusEnum'),
            ]
        ];
    }

    /**
     * Кастомный резолвер даты
     *
     * @param $root
     * @return mixed
     */
    public function resolveDateField($root): string
    {
        /** @var Booking $root */
        $date = Carbon::create($root->getStartsAt());

        return $date->toDateString();
    }

    /**
     * Кастомный резолвер времени
     *
     * @param $root
     * @param $resolveInfo
     * @return object
     */
    public function resolveTimesField($root, $resolveInfo): object
    {
        $fieldSelection = $resolveInfo->getFieldSelection(1);

        if (!empty($fieldSelection['start'])) {
            $fieldSelection['start'] = Carbon::create($root->getStartsAt())->format('H:i');
        }
        if (!empty($fieldSelection['end'])) {
            $fieldSelection['end'] = Carbon::create($root->getEndsAt())->format('H:i');
        }

        return (object) $fieldSelection;
    }
}
