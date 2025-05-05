<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rate $rate)
    {
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:rates'],
            'exchange_rate' => ['required', 'decimal:0,2', 'max:999']

        ]);
        // dd($validated);
        $rate = Rate::findOrFail($validated['id']);
        $rate->exchange_rate = $validated['exchange_rate'];
        $rate->save();

        $rates = Rate::select('id', 'currency', 'exchange_rate')->where('currency', '!=', 'uah')->get()->toArray();
        session()->put('rates', $rates);

        return back();        
    }

}
