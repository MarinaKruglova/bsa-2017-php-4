<?php

namespace BinaryStudioAcademy\Game\Items;

abstract class Item
{
    public $itemName;

    public function getName(): sting
    {
        return $this->itemName;
    }

}