<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Traits\DatabaseRepositoryTrait;
use App\Interfaces\BookingRepository as BookingRepositoryInterface;

class BookingRepository implements BookingRepositoryInterface
{
    use DatabaseRepositoryTrait;
    /**
     * The model associated with the repository.
     *
     * @var \App\Models\Booking
     */
    private $model = Booking::class;

    public function totalDailyOccupancy($date, $room_ids = null)
    {
        $query = $this->query();

        if($room_ids && count($room_ids))
        {
            $query = $query->whereIn('room_id', $room_ids);
        }

        $occupancy = $query->where('starts_at', '<=', $date)
                            ->where('ends_at', '>=', $date)
                            ->count();

        return $occupancy;
    }
}
