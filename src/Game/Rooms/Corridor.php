<?php

namespace BinaryStudioAcademy\Game\Rooms;

class Corridor extends Room
{

    public $roomName = 'corridor';

    public $roomsNearby = ['hall', 'cabinet', 'bedroom'];

    public $itemCount = 0;

}