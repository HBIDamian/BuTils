<?php

declare(strict_types=1);

namespace wex\BuTils\forms\overview\sub;

use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\utils\TextFormat as TF;
use wex\BuTils\BuTils;

final class CommandsForm implements Form{

    public function jsonSerialize() : array{
        $text = "";
        $plugin = BuTils::getInstance();

        /** @var array<int, string> $commands */
        $commands = [];
        foreach($plugin->getServer()->getCommandMap()->getCommands() as $command){

            if($command instanceof PluginOwned){

                if($command->getOwningPlugin() instanceof BuTils){

                    $commandName = $command->getName();
                    $commandAliases = $command->getAliases();
                    $description = $command->getDescription();

                    if(!in_array($commandName, $commands)){
                        $commands[] = $commandName;
                        $text .= TF::GRAY.TF::BOLD."» ".TF::RESET."/$commandName";

                        if(!empty($commandAliases)){
                            $text .= " (".implode(", ", $commandAliases).")";
                        }

                        if(is_string($description)){
                            $text .= "\n".TF::GRAY.TF::ITALIC.$description."\n\n".TF::RESET;
                        }
                    }
                }
            }
        }

        return [
            "type" => "form",
            "title" => "Commands",
            "content" => $text,
            "buttons" => []
        ];
    }

    public function handleResponse(Player $player, $data) : void{
        // No action needed as this form is just informational
    }

    public static function openForm(Player $player) : void{
        $player->sendForm(new self());
    }
}