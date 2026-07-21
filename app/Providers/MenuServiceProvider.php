<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    // Share menuData dynamically based on the logged-in user's role using a View Composer
    View::composer('*', function ($view) {
      $verticalMenuPath = base_path('resources/menu/verticalMenu.json');
      $verticalMenuJson = file_get_contents($verticalMenuPath);
      $verticalMenuData = json_decode($verticalMenuJson);

      if (auth()->check()) {
          $user = auth()->user();
          $permissionMap = [
              'admin.pos' => 'pos',
              'admin.repairs' => 'repairs',
              'admin.inventory.parts' => 'inventory',
              'admin.inventory.accessories' => 'inventory',
              'admin.purchases' => 'purchases',
              'admin.expenses' => 'expenses',
              'admin.reports' => 'reports',
              'admin.cash.index' => 'cash',
              'admin.settings.index' => 'settings',
              'admin.social.index' => 'social_media',
              'admin.categories.index' => 'inventory',
          ];

          $filteredMenu = [];
          foreach ($verticalMenuData->menu as $item) {
              $slug = $item->slug ?? '';
              
              // Only super admins can manage staff accounts, view activity logs, or view partner ledger
              if (($slug === 'admin.users.index' || $slug === 'admin.activity-logs.index' || $slug === 'admin.partner-ledger.index') && !$user->isSuperAdmin()) {
                  continue;
              }

              // Check feature permissions
              if (isset($permissionMap[$slug])) {
                  $perm = $permissionMap[$slug];
                  if (!$user->hasPermissionTo($perm)) {
                      continue;
                  }
              }

              $filteredMenu[] = $item;
          }
          $verticalMenuData->menu = $filteredMenu;
      }

      $horizontalMenuJson = file_get_contents(base_path('resources/menu/horizontalMenu.json'));
      $horizontalMenuData = json_decode($horizontalMenuJson);

      $view->with('menuData', [$verticalMenuData, $horizontalMenuData]);
    });
  }
}
