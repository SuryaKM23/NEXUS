<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function getCrowdfundingVC(Request $request)
    {
        $search = $request->input('search');
        $query = Startup::where('investment', 'vc');
    
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%$search%")
                  ->orWhere('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }
    
        $startups = $query->get();
    
        if ($request->ajax()) {
            return response()->json($startups);
        } else {
            return view('user.Crowdfund', ['startups' => $startups]);
        }
    }
}
