<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return $this->adminReports();
        } elseif ($user->isEditeur()) {
            return $this->editeurReports();
        } else {
            return $this->lecteurReports();
        }
    }

    private function adminReports()
    {
        // Statistiques globales
        $totalUsers = User::count();
        $activeUsers = User::whereNotNull('email_verified_at')->count();
        
        // Utilisateurs par rôle
        $usersByRole = User::selectRaw('role, count(*) as count')
            ->groupBy('role')
            ->get();
        
        // Utilisateurs récents
        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('reports.admin', compact(
            'totalUsers',
            'activeUsers',
            'usersByRole',
            'recentUsers'
        ));
    }

    private function editeurReports()
    {
        $user = Auth::user();
        
        // Informations de base
        $userInfo = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'created_at' => $user->created_at
        ];
        
        return view('reports.editeur', compact('userInfo'));
    }

    private function lecteurReports()
    {
        $user = Auth::user();
        
        // Informations de base
        $userInfo = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'created_at' => $user->created_at
        ];
        
        return view('reports.lecteur', compact('userInfo'));
    }
}
