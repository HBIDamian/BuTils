<?php

declare(strict_types=1);

namespace wex\BuTils;

use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;
use wex\BuTils\commands\BuTilsCommand;
use wex\BuTils\commands\DayLockCommand;
use wex\BuTils\commands\FlySpeedCommand;
use wex\BuTils\commands\GamemodeAdventureCommand;
use wex\BuTils\commands\GamemodeCreativeCommand;
use wex\BuTils\commands\GamemodeSpectatorCommand;
use wex\BuTils\commands\GamemodeSurvivalCommand;
use wex\BuTils\commands\NightVisionCommand;
use wex\BuTils\commands\NoClipCommand;

final class BuTils extends PluginBase{

    public const PREFIX =
        TF::WHITE."[".TF::GOLD."Bu".TF::GRAY.TF::ITALIC."Tils".TF::RESET.TF::WHITE."] ".TF::GRAY.TF::BOLD."» ".TF::RESET;

    public const DEFAULT_FLY_SPEED = 0.05;

    public const DEFAULT_VERTICAL_FLY_SPEED = 1;

    public const MIN_FLY_SPEED = 0.01;

    // maximum safest value to avoid issues
    public const MAX_FLY_SPEED = 0.70;

    private static self $instance;

    /**
     * @var array<string, BuTilsSession>
     */
    private array $sessions = [];

    public function onEnable() : void{
        self::$instance = $this;
        $this->saveDefaultConfig();
        $this->registerListeners();
        $this->registerCommands();
    }

    private function registerListeners() : void{
        $pluginManager = $this->getServer()->getPluginManager();
        $pluginManager->registerEvents(new BuTilsListener(), $this);
    }

    private function registerCommands() : void{
        $commandMap = $this->getServer()->getCommandMap();
        $commandMap->registerAll($this->getName(), [
            new BuTilsCommand(),
            new DayLockCommand(),
            new FlySpeedCommand(),
            new NoClipCommand(),
            new NightVisionCommand(),
            new GamemodeCreativeCommand(),
            new GamemodeSurvivalCommand(),
            new GamemodeAdventureCommand(),
            new GamemodeSpectatorCommand()
        ]);
    }

    public static function getInstance() : self{
        return self::$instance;
    }

    public function hasExplosions() : bool{
        return (bool)$this->getConfig()->get("explosions", true);
    }

    public function hasLeavesDecay() : bool{
        return (bool)$this->getConfig()->get("leaves_decay", true);
    }

    public function doesDragonEggTeleports() : bool{
        return (bool)$this->getConfig()->get("dragon_egg_teleport", true);
    }

    public function hasFallingBlocks() : bool{
        return (bool)$this->getConfig()->get("falling_blocks", true);
    }

    public function hasCoralDeath() : bool{
        return (bool)$this->getConfig()->get("coral_death", true);
    }

    public function hasLiquidFlow() : bool{
        return (bool)$this->getConfig()->get("liquid_flow", true);
    }

    public function addSession(Player $player) : void{
        $this->sessions[$player->getName()] = new BuTilsSession($player);
    }

    public function removeSession(Player $player) : void{
        unset($this->sessions[$player->getName()]);
    }

    public function getSession(Player $player) : ?BuTilsSession{
        return $this->sessions[$player->getName()] ?? null;
    }

    public static function findPlayer(CommandSender $sender, string $name) : ?Player{
        // First try exact match
        $player = $sender->getServer()->getPlayerExact($name);
        if($player !== null){
            return $player;
        }
        
        // Then try case-insensitive exact match
        foreach($sender->getServer()->getOnlinePlayers() as $onlinePlayer){
            if(strtolower($onlinePlayer->getName()) === strtolower($name)){
                return $onlinePlayer;
            }
        }
        
        // Finally try prefix matching (case-insensitive)
        $matches = [];
        foreach($sender->getServer()->getOnlinePlayers() as $onlinePlayer){
            if(stripos($onlinePlayer->getName(), $name) === 0){
                $matches[] = $onlinePlayer;
            }
        }
        
        // Return the match if exactly one found
        if(count($matches) === 1){
            return $matches[0];
        }
        
        // If multiple matches, send a helpful message
        if(count($matches) > 1){
            $matchNames = array_map(fn($p) => $p->getName(), $matches);
            $sender->sendMessage(self::PREFIX.TF::RED."Multiple players found: " . implode(", ", $matchNames));
        }
        
        return null;
    }
}