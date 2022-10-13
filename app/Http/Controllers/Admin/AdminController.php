<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class AdminController extends Controller
{

    /**
     * Admin panel page
     *
     * @return Application|Factory|View|string
     */
    public function index():Application|Factory|View|string
    {
        $this->hasAnyAdminRole();

        return view('admin.index');
    }

    /**
     * Set active field to related entries for selected model
     *
     * @param Model $model
     * @param bool $active
     * @param string|array $relations
     * @return bool
     */
    public function setActiveFieldToModelRelations(Model $model, bool $active, string|array $relations): bool
    {
        if(is_array($relations)) {
            foreach ($relations as $relation) {

                if(!isset($model->{$relation})) {
                    return false;
                }

                foreach ($model->{$relation} as $item) {
                    $item->update(['active' => $active]);
                }
            }
        }else{
            if(!isset($model->{$relations})) {
                return false;
            }

            foreach ($model->{$relations} as $item) {
                $item->update(['active' => $active]);
            }
        }

        return true;
    }

    /**
     * Check permissions to see something
     *
     * @param string $subject
     * @return void
     */
    protected function canSee(string $subject): void
    {
        if(!auth()->user()->canAny(["see $subject", 'everything'])){
            abort(403);
        }
    }

    /**
     * Check permissions to create something
     *
     * @param string $subject
     * @return void
     */
    protected function canCreate(string $subject): void
    {
        if(!auth()->user()->canAny(["create $subject", 'everything'])){
            abort(403);
        }
    }

    /**
     * Check permissions to edit something
     *
     * @param string $subject
     * @return void
     */
    protected function canEdit(string $subject): void
    {
        if(!auth()->user()->canAny(["edit $subject", 'everything'])){
            abort(403);
        }
    }

    /**
     * Check permissions to delete something
     *
     * @param string $subject
     * @return void
     */
    protected function canDelete(string $subject): void
    {
        if(!auth()->user()->canAny(["delete $subject", 'everything'])){
            abort(403);
        }
    }

    /**
     * Check permissions to do everything (super-admin)
     *
     * @return void
     */
    protected function canEverything(): void
    {
        if(!auth()->user()->can( 'everything')){
            abort(403);
        }
    }

    /**
     * Check user has any admin role
     *
     * @return void
     */
    protected function hasAnyAdminRole(): void
    {
        if(!auth()->user()->hasAnyRole(User::getAdminRoles())){
            abort(403);
        }
    }
}
