<?php

namespace App\Http\Controllers;

use App\Models\LanguageSetting;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LadderController extends Controller
{
    public function index(Request $request)
    {
        $type = (int)$request->get('type', 5);
        if (!in_array($type, [2, 3, 5])) {
            $type = 5;
        }
        $activeLangs = LanguageSetting::where('is_active', true)->orderBy('sort_order')->get();
        $settings = SiteSetting::first();

        $ladderData = $this->getLadderData($type);

        return view('ladder.index', compact('ladderData', 'type', 'activeLangs', 'settings'));
    }

    private function getLadderData($type = 5)
    {
        try {
            $results = DB::connection('game_char')->select("
                SELECT 
                    arena_team.*, 
                    characters.class, 
                    characters.race, 
                    characters.gender,
                    characters.name as character_name
                FROM arena_team 
                INNER JOIN characters ON (characters.guid = arena_team.captainGuid) 
                WHERE arena_team.type = ? 
                ORDER BY arena_team.rating DESC 
                LIMIT 50
            ", [$type]);

            $ladderData = [];
            $id = 1;

            foreach ($results as $row) {
                $games = $row->seasonGames ?? 0;
                $wins = $row->seasonWins ?? 0;
                $losses = $games - $wins;

                $faction = $this->getFaction($row->race);
                $race = $this->getRaceImage($row->race, $row->gender);
                $class = $this->getClassInfo($row->class);
                $ratingInfo = $this->getRatingInfo($row->rating);

                $ladderData[] = [
                    'id' => $id++,
                    'name' => $row->name ?? $row->character_name ?? 'Unknown',
                    'rating' => $row->rating ?? 0,
                    'seasonWins' => $wins,
                    'seasonLosses' => $losses,
                    'seasonGames' => $games,
                    'class' => $class['name'],
                    'classImg' => $class['img'],
                    'faction' => $faction,
                    'race' => $race,
                    'ratingInfo' => $ratingInfo,
                ];
            }

            return $ladderData;
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getFaction($race)
    {
        $allianceRaces = [1, 3, 4, 7, 11, 12, 14, 15, 18];
        
        if (in_array($race, $allianceRaces)) {
            return 'Альянс';
        }
        
        return 'Орда';
    }

    private function getRaceImage($race, $gender)
    {
        $genderSuffix = $gender == 0 ? 'male' : 'female';
        
        $raceMap = [
            1 => "human_{$genderSuffix}",
            2 => "orc_{$genderSuffix}",
            3 => "dwarf_{$genderSuffix}",
            4 => "nightelf_{$genderSuffix}",
            5 => "undead_{$genderSuffix}",
            6 => "tauren_{$genderSuffix}",
            7 => "gnome_{$genderSuffix}",
            8 => "troll_{$genderSuffix}",
            9 => "goblin_{$genderSuffix}",
            10 => "bloodelf_{$genderSuffix}",
            11 => "draenei_{$genderSuffix}",
            12 => "worgen_{$genderSuffix}",
            14 => "pandaren_{$genderSuffix}",
            15 => "nightelf_dh_{$genderSuffix}",
            16 => "bloodelf_dh_{$genderSuffix}",
            17 => "nightborne_{$genderSuffix}",
            18 => "voidelf_{$genderSuffix}",
            20 => "vulpera_{$genderSuffix}",
        ];

        return $raceMap[$race] ?? "human_{$genderSuffix}";
    }

    private function getClassInfo($classId)
    {
        $classes = [
            1 => ['name' => 'Воин', 'img' => 'WARRIOR'],
            2 => ['name' => 'Паладин', 'img' => 'PALADIN'],
            3 => ['name' => 'Охотник', 'img' => 'HUNTER'],
            4 => ['name' => 'Разбойник', 'img' => 'ROGUE'],
            5 => ['name' => 'Жрец', 'img' => 'PRIEST'],
            6 => ['name' => 'Рыцарь смерти', 'img' => 'DEATHKNIGHT'],
            7 => ['name' => 'Шаман', 'img' => 'SHAMAN'],
            8 => ['name' => 'Маг', 'img' => 'MAGE'],
            9 => ['name' => 'Чернокнижник', 'img' => 'WARLOCK'],
            11 => ['name' => 'Друид', 'img' => 'DRUID'],
        ];

        return $classes[$classId] ?? ['name' => 'Unknown', 'img' => 'WARRIOR'];
    }

    private function getRatingInfo($rating)
    {
        if ($rating >= 2370) return 14;
        if ($rating >= 2070) return 13;
        if ($rating >= 1770) return 12;
        if ($rating >= 1570) return 11;
        if ($rating >= 1370) return 9;
        
        return 8;
    }
}
