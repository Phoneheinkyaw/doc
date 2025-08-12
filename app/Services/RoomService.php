<?php

namespace App\Services;

use App\Contracts\Dao\RoomDaoInterface;
use App\Contracts\Services\RoomServiceInterface;
use App\Models\Room;
use Illuminate\Pagination\LengthAwarePaginator;

class RoomService implements RoomServiceInterface
{
    protected RoomDaoInterface $roomDao;

    /**
     * @param RoomDaoInterface $roomDao
     */
    public function __construct(RoomDaoInterface $roomDao)
    {
        $this->roomDao = $roomDao;
    }

    /**
     * get room list
     * @return LengthAwarePaginator
     */
    public function getAllRoom(): LengthAwarePaginator
    {
        return $this->roomDao->getAllRoom();
    }

    /**
     * get first available room
     * @return Room
     */
    public function getFirstAvailableRoom(): Room
    {
        return $this->roomDao->getFirstAvailableRoom();
    }

    /**
     * change room status
     * @param $roomId
     * @return void
     */
    public function changeRoomStatus($roomId): void
    {
        $this->roomDao->changeRoomStatus($roomId);
    }

    /**
     * create new room
     * @param $request
     * @return void
     */
    public function store($request): void
    {
        $this->roomDao->store($request);
    }

    /**
     * delete room
     * @param $id
     * @return void
     */
    public function destory($id): void
    {
        $this->roomDao->destory($id);
    }

    /**
     * update room
     * @param $request
     * @param $id
     * @return void
     */
    public function updateRooms($request, $id): void
    {
        $this->roomDao->updateRooms($request, $id);
    }

    /**
     * search rooms
     * @param string $keyword
     * @return LengthAwarePaginator
     */
    public function searchRooms(string $keyword): LengthAwarePaginator
    {
        return $this->roomDao->searchRooms($keyword);
    }
}
