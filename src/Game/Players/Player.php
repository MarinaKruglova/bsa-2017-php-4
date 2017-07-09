<?php

namespace BinaryStudioAcademy\Game\Players;

use BinaryStudioAcademy\Game\Rooms\Room;

class Player
{
    public $nickname;
    public $room;
    private $pocket;

    public function __construct(Room $room)
    {
        $this->nickname = "";
        $this->room = $room;
        $this->pocket = [];
    }

    public function setNickname(string $nickname)
    {
        $this->nickname = $nickname;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function addItemInPocket()
    {
        return array_push($this->pocket, 1);
    }

    public function getCurrentPosition(): string
    {
        return $this->room->getRoomName();
    }


    public function countItems(): int
    {
        return count($this->pocket);
    }
}