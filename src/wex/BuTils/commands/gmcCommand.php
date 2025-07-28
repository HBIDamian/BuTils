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

final class gmcCommand extends Command implements PluginOwned{

    public function __construct(){
        parent::__construct(
            "gmc",
            "Change gamemode to creative"
        );
        $this->setPermission("pocketmine.command.gamemode");
        $this->setAliases(["creative"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : void{
        if($this->testPermission($sender)){
            if(!$sender instanceof Player){
                $sender->sendMessage(BuTils::PREFIX.TextFormat::RED."This command may only be run in-game.");
                return;
            }

            $sender->setGamemode(GameMode::CREATIVE());
            $sender->sendMessage(BuTils::PREFIX.TextFormat::GREEN."Set own game mode to Creative Mode.");
        }
    }

    public function getOwningPlugin() : Plugin{
        return BuTils::getInstance();
    }
}