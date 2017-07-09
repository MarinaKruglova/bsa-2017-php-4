<?php

namespace BinaryStudioAcademy\Game\Rooms;

use BinaryStudioAcademy\Game\Items\Item;

abstract class Room
{
    public $roomName;
    public $roomsNearby;
    public $itemCount;

    public function getRoomName(): string
    {
        return $this->roomName;
    }

    public function getRoomsNearby(): array
    {
        return $this->roomsNearby;
    }

    public function getItemsCount(): int
    {
        return $this->itemCount;
    }

    public function pickItem()
    {
        if ($this->itemCount > 0) {
            $this->itemCount--;
        }
    }

}