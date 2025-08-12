<?php

namespace App\Contracts\Dao;

interface RoomDaoInterface
{
    public function getAllRoom();
    public function getFirstAvailableRoom();
    public function changeRoomStatus($roomId);
    public function store($request);
    public function destory($id);
    public function updateRooms($request, $id);
    public function searchRooms(string $keyword);
}
