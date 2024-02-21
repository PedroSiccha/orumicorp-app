<?php

namespace App\Http\Controllers;

use App\Models\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    public function saveTarget(Request $request)
    {
        $resp = 0;

        $target = new Target();
        $target->amount = $request->amount;
        $target->mount = date("m");
        $target->observation = "";
        $target->status = 1;
        if ($target->save()) {
            $resp = 1;
        }

        $target = Target::where('status', true)
                ->where('mount', date("m"))
                ->orderBy("created_at", "asc")
                ->first();

        return response()->json(["view"=>view('bonusAgente.components.tabTarget', compact('target'))->render(), "resp"=>$resp]);
    }
}
