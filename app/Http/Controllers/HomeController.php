<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reunion;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Resolve slug to Reunion
     */
    public function resolveSlug($slug)
    {
        $reunion = Reunion::where('slug', $slug)->first();
        if ($reunion) {
            return app(ReunionController::class)->show($reunion, request());
        }
        
        abort(404);
    }
}
