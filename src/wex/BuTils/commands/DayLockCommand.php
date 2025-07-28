<?php

declare(strict_types=1);

namespace wex\BuTils\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\utils\TextFormat;
use pocketmine\world\World;
use wex\BuTils\BuTils;

final class DayLockCommand extends Command implements PluginOwned{

    /**
     * @var array<string, bool> Array mapping world names to daylock status
     */
    private static array $dayLockedWorlds = [];

    public function __construct(){
        parent::__construct(
            "daylock",
            "Toggle day lock - locks time to day (6000 ticks)",
            null,
            ["dl"]
        );
        $this->setPermission("butils.command.daylock");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : void{
        if($this->testPermission($sender)){

            if(!$sender instanceof Player){
                $sender->sendMessage(BuTils::PREFIX.TextFormat::RED."This command may only be run in-game.");
                return;
            }

            $world = $sender->getWorld();
            $worldName = $world->getFolderName();

            // Check if daylock is currently enabled for this world
            $isDayLocked = self::$dayLockedWorlds[$worldName] ?? false;

            if($isDayLocked){
                // Turn off daylock - resume time
                $world->startTime();
                self::$dayLockedWorlds[$worldName] = false;
                $sender->sendMessage(BuTils::PREFIX.TextFormat::GREEN."Day lock toggled: ".TextFormat::DARK_RED."OFF".TextFormat::GREEN." - Time resumed");
            } else {
                // Turn on daylock - stop time and set to day
				$world->startTime();
				$world->setTime(6000); // 6000 ticks = noon (day time)
                $world->stopTime();
                self::$dayLockedWorlds[$worldName] = true;
                $sender->sendMessage(BuTils::PREFIX.TextFormat::GREEN."Day lock toggled: ".TextFormat::DARK_GREEN."ON".TextFormat::GREEN." - Time locked to day");
            }
        }
    }

    public function getOwningPlugin() : Plugin{
        return BuTils::getInstance();
    }

    /**
     * Check if a world has daylock enabled
     */
    public static function isDayLocked(string $worldName) : bool{
        return self::$dayLockedWorlds[$worldName] ?? false;
    }

    /**
     * Remove daylock data for a world (useful when world is unloaded)
     */
    public static function removeDayLockData(string $worldName) : void{
        unset(self::$dayLockedWorlds[$worldName]);
    }
}
