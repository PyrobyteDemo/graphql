<?php

namespace App\Entities\Booking;

/**
 * DTO для создания бронирования
 *
 * Class MakeBookingDTO
 * @package App\Entities\Booking
 */
class MakeBookingDTO
{
    public function __construct(
        private string $date,
        private string $start,
        private string $end,
        private int $carServiceID,
        private int $liftID,
        private bool $needMaster,
        private bool $needEquipments,
        private string $comment,
    ) {}

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start): void
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end): void
    {
        $this->end = $end;
    }

    /**
     * @return mixed
     */
    public function getCarServiceID()
    {
        return $this->carServiceID;
    }

    /**
     * @param mixed $carServiceID
     */
    public function setCarServiceID($carServiceID): void
    {
        $this->carServiceID = $carServiceID;
    }

    /**
     * @return mixed
     */
    public function getLiftID()
    {
        return $this->liftID;
    }

    /**
     * @param mixed $liftID
     */
    public function setLiftID($liftID): void
    {
        $this->liftID = $liftID;
    }

    /**
     * @return mixed
     */
    public function getNeedMaster()
    {
        return $this->needMaster;
    }

    /**
     * @param mixed $needMaster
     */
    public function setNeedMaster($needMaster): void
    {
        $this->needMaster = $needMaster;
    }

    /**
     * @return mixed
     */
    public function getNeedEquipments()
    {
        return $this->needEquipments;
    }

    /**
     * @param mixed $needEquipments
     */
    public function setNeedEquipments($needEquipments): void
    {
        $this->needEquipments = $needEquipments;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

}
