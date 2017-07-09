<?php

namespace BinaryStudioAcademy\Game\Referees;

use BinaryStudioAcademy\Game\Game;

class Referee
{
    public $gameInProgress;
    public $statusMessage;
    private $game;

    public function __construct(Game $game)
    {
        $this->gameInProgress = true;
        $this->game = $game;
        $this->statusMessage = $this->help();
    }

    public function where()
    {
        $currentRoom = $this->game->player->getCurrentPosition();
        $nextRoute = implode(', ', $this->game->player->room->getRoomsNearby());
        $this->statusMessage = "You're at {$currentRoom}. You can go to: {$nextRoute}.";
    }

    public function status()
    {
        $currentRoom = $this->game->player->getCurrentPosition();
        $itemCount = $this->game->player->countItems();
        $itemName = $this->game->item->itemName;
        // $itemName = ($items > 1 || $items == 0) ? $itemName . "s" : $itemName;
        $this->statusMessage = "You're at {$currentRoom}. You have {$itemCount} {$itemName}s.";
    }

    public function help(): string
    {
        $this->statusMessage = PHP_EOL .
            "usage:" . PHP_EOL .
            "\twhere - show info about current room and rooms nearby" . PHP_EOL .
            "\tstatus - show status info about grabbed coins and current room" . PHP_EOL .
            "\thelp - show this list of commands" . PHP_EOL .
            "\tgo <room> - send player to the room" . PHP_EOL .
            "\tobserve - show if any item is present in room" . PHP_EOL .
            "\tgrab - pick up one item at a time to the player" . PHP_EOL .
            "\texit - finish game immediately" . PHP_EOL;

        return $this->statusMessage;
    }

    public function go(string $room)
    {
        if (in_array($room, $this->game->player->room->getRoomsNearby())) {
            $this->game->player->room = $this->game->{$room};
            $nextRoute = implode(', ', $this->game->player->room->getRoomsNearby());
            $this->statusMessage = "You're at {$room}. You can go to: {$nextRoute}.";
        } else {
            $this->statusMessage = "Can not go to {$room}.";
        }
    }

    public function observe()
    {
        $itemCount = $this->game->player->room->itemCount;
        $itemName = $this->game->item->itemName;
        $this->statusMessage = "There {$itemCount} {$itemName}(s) here.";
    }

    public function grab()
    {
        $itemName = $this->game->item->itemName;
        if ($this->game->player->room->getItemsCount() > 0) {
            $this->game->player->room->pickItem();
            $this->game->player->addItemInPocket();
            $itemName = ucfirst($itemName);

            if ($this->game->player->countItems() !== $this->game::COINS_TO_WIN) {
                $this->statusMessage = "Congrats! {$itemName} has been added to inventory.";
            } else {
                $this->statusMessage = "Good job. You've completed this quest. Bye!";
            }

        } else {
            $this->statusMessage = "There is no {$itemName}s left here. Type 'where' to go to another location.";
        }
    }

    public function exit()
    {
        $this->gameInProgress = false;
        $this->statusMessage = "See you next time!" . PHP_EOL;
    }
}