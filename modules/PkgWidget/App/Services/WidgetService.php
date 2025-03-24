<?php

namespace Modules\PkgWidget\App\Services;

use App\Models\Apprenant;

class WidgetService
{
    /**
     * Returns a widget displaying the total number of apprenants.
     *
     * @return array
     */
    public function getNombreApprenant()
    {
        // Query the database to count apprenants.
        $nombre = Apprenant::count();

        return [
            'title' => 'Nombre d\'Apprenants',
            'value' => $nombre,
        ];
    }

    /**
     * Returns a widget with a list of active apprenants and their total count.
     *
     * @return array
     */
    public function getApprenantsActifs()
    {
        // Query for active learners. You can adjust the query as needed.
        $activeApprenants = Apprenant::where('is_active', true)
            ->limit(5)
            ->pluck('name')
            ->toArray();

        $totalActive = Apprenant::where('is_active', true)->count();

        return [
            'title' => 'Apprenants Actifs',
            'list'  => $activeApprenants,
            'total' => $totalActive,
        ];
    }

    /**
     * Dynamically execute a service method by name with built-in error handling.
     *
     * @param string $methodName
     * @return array Returns an array with either a 'result' or 'error' key.
     */
    public function dynamicCall(string $methodName): array
    {
        try {
            // Verify that the requested method exists in the service.
            if (!method_exists($this, $methodName)) {
                throw new \Exception("The method '{$methodName}' does not exist in WidgetService.");
            }

            // Dynamically call the method and store its result.
            $result = call_user_func([$this, $methodName]);

            // Return the result under the 'result' key.
            return ['result' => $result];
        } catch (\Exception $e) {
            // Return the error message under the 'error' key.
            return ['error' => $e->getMessage()];
        }
    }
}
