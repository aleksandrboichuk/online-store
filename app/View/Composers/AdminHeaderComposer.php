<?php

namespace App\View\Composers;

use App\Http\Controllers\Controller;
use App\Models\CategoryGroup;
use Illuminate\View\View;

class AdminHeaderComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return View
     */
    public function compose(View $view): View
    {
        $categoryGroups = CategoryGroup::query()
            ->where('active', 1)
            ->select('name', 'seo_name')
            ->get();

        return $view->with(['categoryGroups' => $categoryGroups]);
    }
}
