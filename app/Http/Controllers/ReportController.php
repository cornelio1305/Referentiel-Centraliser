<?php

namespace App\Http\Controllers;

use App\Models\Script;
use App\Models\User;
use App\Models\ScriptView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Afficher la page des rapports
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Rapport des scripts par base de données
     */
    public function scriptsByDatabase()
    {
        $stats = Script::select('db_target', DB::raw('count(*) as total'))
            ->groupBy('db_target')
            ->get();

        return view('reports.scripts-by-database', compact('stats'));
    }

    /**
     * Rapport d'utilisation des scripts
     */
    public function scriptUsage()
    {
        $usage = Script::withCount('views')
            ->with('creator')
            ->orderBy('views_count', 'desc')
            ->limit(20)
            ->get();

        return view('reports.script-usage', compact('usage'));
    }

    /**
     * Rapport d'activité des utilisateurs
     */
    public function userActivity()
    {
        $activity = User::withCount(['scripts', 'scriptViews'])
            ->orderBy('scripts_count', 'desc')
            ->get();

        return view('reports.user-activity', compact('activity'));
    }

    /**
     * Rapport des scripts par statut
     */
    public function scriptsByStatus()
    {
        $stats = Script::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('reports.scripts-by-status', compact('stats'));
    }

    /**
     * Exporter un rapport
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'scripts-by-database');

        switch ($type) {
            case 'scripts-by-database':
                $data = Script::select('db_target', DB::raw('count(*) as total'))
                    ->groupBy('db_target')
                    ->get();
                $filename = 'rapport_scripts_par_base_' . date('Y-m-d') . '.csv';
                break;

            case 'script-usage':
                $data = Script::withCount('views')
                    ->with('creator')
                    ->orderBy('views_count', 'desc')
                    ->get();
                $filename = 'rapport_utilisation_scripts_' . date('Y-m-d') . '.csv';
                break;

            case 'user-activity':
                $data = User::withCount(['scripts', 'scriptViews'])
                    ->orderBy('scripts_count', 'desc')
                    ->get();
                $filename = 'rapport_activite_utilisateurs_' . date('Y-m-d') . '.csv';
                break;

            default:
                return back()->with('error', 'Type de rapport non reconnu');
        }

        return $this->exportToCsv($data, $filename);
    }

    /**
     * Exporter les données en CSV
     */
    private function exportToCsv($data, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');

            // En-têtes
            if ($data->isNotEmpty()) {
                fputcsv($file, array_keys($data->first()->toArray()));
            }

            // Données
            foreach ($data as $row) {
                fputcsv($file, $row->toArray());
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
