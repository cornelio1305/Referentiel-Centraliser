<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Script;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('script.creator')->paginate(10);
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Request $request, Script $script)
    {
        $user = Auth::user();
        $favorite = Favorite::where('user_id', $user->id)
                           ->where('script_id', $script->id)
                           ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Script retiré des favoris';
            $isFavorited = false;
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'script_id' => $script->id,
            ]);
            $message = 'Script ajouté aux favoris';
            $isFavorited = true;
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'isFavorited' => $isFavorited
            ]);
        }

        return back()->with('success', $message);
    }

    public function destroy(Favorite $favorite)
    {
        if ($favorite->user_id !== Auth::id()) {
            abort(403);
        }

        $favorite->delete();
        return back()->with('success', 'Script retiré des favoris');
    }
}
