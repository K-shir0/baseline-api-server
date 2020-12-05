<?php

namespace App\Http\Controllers\Entry;

use App\Http\Controllers\Controller;
use App\Models\CompanyInformation;

class ShowEntryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {
        $status = 200;
        $entry = CompanyInformation::with('entries')->findOrFail($id);

        if($entry->entries->count() == 0){
            abort(404);
        }

        return response()->json(
            $entry, $status
        );
    }
}
