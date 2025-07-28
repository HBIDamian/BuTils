<?php

declare(strict_types=1);

namespace wex\BuTils\forms\overview;

use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use wex\BuTils\BuTils;
use wex\BuTils\forms\overview\sub\CommandsForm;
use wex\BuTils\forms\overview\sub\GlobalParametersForm;

final class OverviewForm implements Form{

    public function jsonSerialize() : array{
        return [
            "type" => "form",
            "title" => "Overview",
            "content" => TextFormat::GREEN.BuTils::getInstance()->getDescription()->getFullName(),
            "buttons" => [
                [
                    "text" => "» Global Parameters «",
                    "image" => [
                        "type" => "path",
                        "data" => "textures/ui/icon_setting"
                    ]
                ],
                [
                    "text" => "» Commands «",
                    "image" => [
                        "type" => "path",
                        "data" => "textures/ui/creator_glyph_color"
                    ]
                ]
            ]
        ];
    }

    public function handleResponse(Player $player, $data) : void{
        if($data === null) return;

        match($data){
            0 => GlobalParametersForm::openForm($player),
            1 => CommandsForm::openForm($player),
            default => null
        };
    }

    public static function openForm(Player $player) : void{
        $player->sendForm(new self());
    }
}