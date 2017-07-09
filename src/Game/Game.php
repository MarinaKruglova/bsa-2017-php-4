<?php

namespace BinaryStudioAcademy\Game;

use BinaryStudioAcademy\Game\Contracts\Io\Reader;
use BinaryStudioAcademy\Game\Contracts\Io\Writer;
use BinaryStudioAcademy\Game\Rooms;
use BinaryStudioAcademy\Game\Items;
use BinaryStudioAcademy\Game\Players;
use BinaryStudioAcademy\Game\Referees;

class Game
{
    const COINS_TO_WIN = 5;

    public $player;
    public $referee;
    public $item;

    public function __construct()
    {
        $this->item = new Items\Coin;

        $this->hall = new Rooms\Hall;
        $this->basement = new Rooms\Basement;
        $this->corridor = new Rooms\Corridor;
        $this->cabinet = new Rooms\Cabinet;
        $this->bedroom = new Rooms\Bedroom;

        $this->player = new Players\Player($this->hall);
        $this->referee = new Referees\Referee($this);

    }

    public function start(Reader $reader, Writer $writer): void
    {

        $writer->writeln("You can't play yet. Please read input and type commands to play");

        $writer->write("Type your name: ");
        $input = trim($reader->read());
        $this->player->setNickname($input);

        $writer->writeln("Hello, " . $this->player->getNickname());
        $writer->writeln($this->referee->statusMessage);

        while(true) {
            $writer->write("Command: ");
            $this->run($reader, $writer);

            if (!$this->referee->gameInProgress) {
                break;
            }

            $this->referee->statusMessage = "";
        }
    }

    public function run(Reader $reader, Writer $writer)
    {
        $stdin = trim($reader->read());
        $args = explode(" ", $stdin);

        if (method_exists($this->referee, $args[0])) {
            if ($args[0] !== "go") {
                $this->referee->{$args[0]}();
            } else {
                $args[1] = $args[1] ?? "";
                $this->referee->{$args[0]}($args[1]);
            }
            $writer->writeln($this->referee->statusMessage);

        } else {
            $writer->writeln("Unknown command: '{$args[0]}'.");
        }

    }
}
