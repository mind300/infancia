<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\ClassRoom;
use App\Models\Kid;
use App\Models\ParentKid;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function nursery(Request $request)
    {
        // Employees Teachers Counts
        $users_counts = User::where('branch_id', $request->branch_id)->whereHasRole(['admin', 'teacher'])->count();
        // Employees Counts
        $kids_counts = Kid::branchScope($request)->count();
        // Kids Counts
        $parents_counts = ParentKid::branchScope($request)->count();
        // Classes Counts
        $classRooms_counts = ClassRoom::branchScope($request)->count();

        $data = [
            'users_counts' => $users_counts,
            'kids_counts' => $kids_counts,
            'parent_counts' => $parents_counts,
            'classRooms_counts' => $classRooms_counts,
        ];

        if ($request->has('nursery_id')) {
            $branches_counts = Branch::nurseryScope($request)->count();
            $data['branches_count'] = $branches_counts;
        }

        return contentResponse($data);
    }
}
