<?php

namespace App\Service;

class HappyQuote
{
    public function getHappyMessage(): string
    {
        $messages = [
            "Aujourd’hui est un bon jour pour apprendre !",
            "Tu es capable de grandes choses ",
            "Chaque erreur est une leçon, continue !",
            "Le succès commence par un pas, fais-le maintenant !",
            "Tu progresses à chaque ligne de code écrite !",
        ];

        return $messages[array_rand($messages)];
    }
}
