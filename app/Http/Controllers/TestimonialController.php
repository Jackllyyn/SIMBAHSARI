<?php
namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Testimonial::create($request->only(['name', 'occupation', 'content', 'rating']));

        return response()->json(['message' => 'Testimoni berhasil disimpan!'], 200);
    }
}