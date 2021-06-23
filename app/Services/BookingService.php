<?php

namespace App\Services\CarService;

use App\Entities\Booking\MakeBookingDTO;
use App\Entities\Notification\Booking\BookingCancelledNotification;
use App\Events\BookingCancelledEvent;
use App\Events\BookingCreatedEvent;
use App\Models\Booking\Booking;
use App\Models\CarService\CarService;
use App\Services\Notification\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Сервис для работы с бронированием
 *
 * Class BookingService
 * @package App\Services\CarService
 */
class BookingService
{
    /**
     * Создание бронирования
     *
     * @param MakeBookingDTO $data
     * @return bool
     */
    public function makeBooking(MakeBookingDTO $data): bool
    {
        $now = Carbon::now();

        $booking = new Booking();
        $booking->setUserId(Auth::id());
        $booking->setCarServiceId($data->getCarServiceID());
        $booking->setStatus(Booking::STATUS_NEW);
        $booking->setStartsAt(Carbon::create($data->getDate())->setTimeFromTimeString($data->getStart()));
        $booking->setEndsAt(Carbon::create($data->getDate())->setTimeFromTimeString($data->getEnd()));
        $booking->setCost(0);
        $booking->setLiftId($data->getLiftID());
        $booking->setNeedMaster($data->getNeedMaster());
        $booking->setNeedEquipments($data->getNeedEquipments());
        $booking->setComment($data->getComment());
        $booking->setCreatedAt($now);
        $booking->setUpdatedAt($now);
        $booking->save();

        BookingCreatedEvent::dispatch($booking);

        return true;
    }
}
