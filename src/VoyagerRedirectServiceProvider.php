<?php

use Illuminate\Events\Dispatcher;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class VoyagerRedirectServiceProvider extends \Illuminate\Support\ServiceProvider
{

	private $models = [
			'VoyagerRedirect'
		];

	public function boot(\Illuminate\Routing\Router $router, Dispatcher $events)
	{
		$events->listen('voyager.admin.routing', [$this, 'addRedirectRoutes']);
		$events->listen('voyager.menu.display', [$this, 'addRedirectMenuItem']);
		$this->loadViewsFrom(base_path('hooks/voyager-redirects/resources/views'), 'voyager.redirects');
		$this->loadModels();
	}

	public function addRedirectRoutes($router)
    {
        $namespacePrefix = '\\Hooks\\VoyagerRedirects\\Http\\Controllers\\';
        $router->get('redirects', ['uses' => $namespacePrefix.'VoyagerRedirectController@browse', 'as' => 'redirects']);
        $router->get('redirects/add', ['uses' => $namespacePrefix.'VoyagerRedirectController@add', 'as' => 'redirects.add']);
    	$router->post('redirects/add', ['uses' => $namespacePrefix.'VoyagerRedirectController@add_post', 'as' => 'redirects.add.post']);
    	$router->get('redirects/{id}/edit', ['uses' => $namespacePrefix.'VoyagerRedirectController@edit', 'as' => 'redirects.edit']);
    	$router->post('redirects/edit', ['uses' => $namespacePrefix.'VoyagerRedirectController@edit_post', 'as' => 'redirects.edit.post']);
    	$router->delete('redirects/delete', ['uses' => $namespacePrefix.'VoyagerRedirectController@delete', 'as' => 'redirects.delete']);
	
    }

	public function addRedirectMenuItem(Menu $menu)
	{
	    if ($menu->name == 'admin') {
	        $url = route('voyager.redirects', [], false);
	        $menuItem = $menu->items->where('url', $url)->first();
	        if (is_null($menuItem)) {
	            $menu->items->add(MenuItem::create([
	                'menu_id'    => $menu->id,
	                'url'        => $url,
	                'title'      => 'Redirects',
	                'target'     => '_self',
	                'icon_class' => 'voyager-external',
	                'color'      => null,
	                'parent_id'  => null,
	                'order'      => 99,
	            ]));
	            $this->ensurePermissionExist();
	            $this->addRedirectsTable();
	        }
	    }
	}

	private function loadModels(){
		foreach($this->models as $model){
			$namespacePrefix = '\\Hooks\\VoyagerRedirects\\Models\\';
			if(!class_exists($namespacePrefix . $model)){
				@include(__DIR__.'/Models/' . $model . '.php');
			}
		}
	}

	protected function ensurePermissionExist()
    {
        $permissions = [
        	Permission::firstOrNew(['key' => 'browse_redirects', 'table_name' => 'redirects']),
        	Permission::firstOrNew(['key' => 'edit_redirects', 'table_name' => 'redirects']),
        	Permission::firstOrNew(['key' => 'add_redirects', 'table_name' => 'redirects']),
        	Permission::firstOrNew(['key' => 'delete_redirects', 'table_name' => 'redirects'])
        ];

        foreach($permissions as $permission){
	        if (!$permission->exists) {
	            $permission->save();
	            $role = Role::where('name', 'admin')->first();
	            if (!is_null($role)) {
	                $role->permissions()->attach($permission);
	            }
	        }
	    }
    }

    private function addRedirectsTable(){
    	if(!Schema::hasTable('voyager_redirects')){

    		Schema::create('voyager_redirects', function (Blueprint $table) {
	            $table->increments('id');
				$table->string('from')->unique();
				$table->string('to');
				$table->string('type', 3);
				$table->timestamps();
	        });

	    }
    }

}