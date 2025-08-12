<?php

namespace App\Dao;

use App\Contracts\Dao\RoomDaoInterface;
use App\Models\Room;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class RoomDao implements RoomDaoInterface
{
    /**
     * get room list
     * @return LengthAwarePaginator
     */
    public function getAllRoom(): LengthAwarePaginator
    {
        return Room::paginate(10);
    }

    /**
     * get first available room
     * @return Room
     */
    public function getFirstAvailableRoom(): Room
    {
        return Room::where('status', true)->first();
    }

    /**
     * change room's status
     * @param $roomId
     * @return void
     */
    public function changeRoomStatus($roomId): void
    {
        $room = Room::findOrFail($roomId);
        if ($room) {
            $room->status = $room->status == 1 ? 0 : 1;
            $room->save();
        }
    }

    /**
     * create new room
     * @param $request
     * @return void
     */
    public function store($request): void
    {
        Room::create([
            'name' => $request->input('name'),
        ]);
    }

    /**
     * update room
     * @param $request
     * @param $id
     * @return void
     */
    public function updateRooms($request, $id): void
    {
        $room = Room::find($id);

        if ($room) {
            $room->name = $request->input('name');
            $room->save();
        }
    }

    /**
     * delete a room
     * @param $id
     * @return void
     * @throws Exception
     */
    public function destory($id): void
    {
        $room = Room::findOrFail($id);
        if ($room->status) {
            $room->delete();
        } else {
            throw new Exception();
        }
    }

    /**
     * search rooms
     * @param string $search
     * @return LengthAwarePaginator
     */
    public function searchRooms(string $search): LengthAwarePaginator
    {
        return Room::where('name', 'like', '%' . strtolower($search) . '%')
            ->orWhere('status', strtolower($search) == 'free' ? 1 : (strtolower($search) == 'occupied' ? 0 : null))
            ->paginate(10)
            ->appends(['search' => $search]);
    }
}
