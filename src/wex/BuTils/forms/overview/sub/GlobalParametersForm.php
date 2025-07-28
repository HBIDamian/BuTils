<?php

declare(strict_types=1);

namespace wex\BuTils\forms\overview\sub;

use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use wex\BuTils\BuTils;

final class GlobalParametersForm implements Form{

    public function jsonSerialize() : array{
        $plugin = BuTils::getInstance();
        
        return [
            "type" => "custom_form",
            "title" => "Global Parameters",
            "content" => [
                [
                    "type" => "label",
                    "text" => TextFormat::GRAY."It allows to completely disable explosions."
                ],
                [
                    "type" => "toggle",
                    "text" => "» Enable explosions ?",
                    "default" => $plugin->hasExplosions()
                ],
                [
                    "type" => "label",
                    "text" => TextFormat::GRAY."It allows leaves to remain without decaying."
                ],
                [
                    "type" => "toggle",
                    "text" => "» Enable leaves decay ?",
                    "default" => $plugin->hasLeavesDecay()
                ],
                [
                    "type" => "label",
                    "text" => TextFormat::GRAY."The dragon egg will teleport upon interacting with it. This toggle disables that behaviour."
                ],
                [
                    "type" => "toggle",
                    "text" => "» Enable dragon egg teleport ?",
                    "default" => $plugin->doesDragonEggTeleports()
                ],
                [
                    "type" => "label",
                    "text" => TextFormat::GRAY."Removes the gravity from any falling blocks (e.g. anvil, sand, etc)."
                ],
                [
                    "type" => "toggle",
                    "text" => "» Enable falling blocks ?",
                    "default" => $plugin->hasFallingBlocks()
                ],
                [
                    "type" => "label",
                    "text" => TextFormat::GRAY."Corals as well as coral blocks die outside of water. This toggle disables that behaviour."
                ],
                [
                    "type" => "toggle",
                    "text" => "» Enable coral death ?",
                    "default" => $plugin->hasCoralDeath()
                ],
                [
                    "type" => "label",
                    "text" => TextFormat::GRAY."It allows liquid such as lava and water not to flow."
                ],
                [
                    "type" => "toggle",
                    "text" => "» Enable liquid flow ?",
                    "default" => $plugin->hasLiquidFlow()
                ]
            ]
        ];
    }

    public function handleResponse(Player $player, $data) : void{
        if($data === null) return;

        $config = BuTils::getInstance()->getConfig();
        
        // Skip labels and get only toggle values (indices 1, 3, 5, 7, 9, 11)
        $config->set("explosions", (bool)$data[1]);
        $config->set("leaves_decay", (bool)$data[3]);
        $config->set("dragon_egg_teleport", (bool)$data[5]);
        $config->set("falling_blocks", (bool)$data[7]);
        $config->set("coral_death", (bool)$data[9]);
        $config->set("liquid_flow", (bool)$data[11]);
        $config->save();

        $player->sendMessage(BuTils::PREFIX.TextFormat::GREEN."Saved global parameters.");
    }

    public static function openForm(Player $player) : void{
        $player->sendForm(new self());
    }
}