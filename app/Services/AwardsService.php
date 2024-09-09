<?php
namespace App\Services;

use App\Interfaces\AwardsInterface;
use App\Models\Premio;

class AwardsService implements AwardsInterface {

    public function __construct() {}

    public function chargeAwards() {
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        return [
            'premios1' => $premios1,
            'premios2' => $premios2
        ];
    }

}
