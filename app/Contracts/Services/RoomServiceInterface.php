<?php

namespace App\Contracts\Services;

interface RoomServiceInterface
{
    public function getAllRoom();
    public function getFirstAvailableRoom();
    public function changeRoomStatus($roomId);
    public function store($request);
    public function destory($id);
    public function updateRooms($request, $id);
    public function searchRooms(string $keyword);
}
