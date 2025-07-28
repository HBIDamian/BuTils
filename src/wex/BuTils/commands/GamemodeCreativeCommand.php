<?php

declare(strict_types=1);

namespace wex\BuTils\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\utils\TextFormat;
use wex\BuTils\BuTils;

final class GamemodeCreativeCommand extends Command implements PluginOwned{

    public function __construct(){
        parent::__construct(
            "gmc",
            "Change gamemode to creative"
        );
        $this->setPermission("butils.command.gamemode.creative");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : void{
        if($this->testPermission($sender)){
            
            // If sender is console, require player argument
            if(!$sender instanceof Player){
                if(!isset($args[0])){
                    $sender->sendMessage(BuTils::PREFIX.TextFormat::RED."Usage: /gmc <player>");
                    return;
                }
                
                $targetPlayer = BuTils::findPlayer($sender, $args[0]);
                if($targetPlayer === null){
                    $sender->sendMessage(BuTils::PREFIX.TextFormat::RED."Player '{$args[0]}' not found.");
                    return;
                }
                
                $targetPlayer->setGamemode(GameMode::CREATIVE());
                $sender->sendMessage(BuTils::PREFIX.TextFormat::GREEN."Set {$targetPlayer->getName()}'s game mode to Creative Mode.");
                $targetPlayer->sendMessage(BuTils::PREFIX.TextFormat::GREEN."Your game mode has been changed to Creative Mode by Console.");
                return;
            }

            $target = $sender;
            
            // Check if a player argument was provided
            if(isset($args[0])){
                $targetPlayer = BuTils::findPlayer($sender, $args[0]);
                if($targetPlayer === null){
                    $sender->sendMessage(BuTils::PREFIX.TextFormat::RED."Player '{$args[0]}' not found.");
                    return;
                }
                $target = $targetPlayer;
            }

            $target->setGamemode(GameMode::CREATIVE());
            
            if($target === $sender){
                $sender->sendMessage(BuTils::PREFIX.TextFormat::GREEN."Set own game mode to Creative Mode.");
            } else {
                $sender->sendMessage(BuTils::PREFIX.TextFormat::GREEN."Set {$target->getName()}'s game mode to Creative Mode.");
                $target->sendMessage(BuTils::PREFIX.TextFormat::GREEN."Your game mode has been changed to Creative Mode by {$sender->getName()}.");
            }
        }
    }

    public function getOwningPlugin() : Plugin{
        return BuTils::getInstance();
    }
}
