<?php

namespace App\View\Composers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class BasicPageDataComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return View
     */
    public function compose(View $view): View
    {
        $controller = new Controller();

        return $view->with($controller->getBasicPageData());
    }
}
