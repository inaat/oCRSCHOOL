<?php

namespace App\Http\Middleware;

use Closure;
use Menu;

class AdminSidebarMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->ajax()) {
            return $next($request);
        }

        Menu::create('admin-sidebar-menu', function ($menu) {
            // active mm-active $enabled_modules = !empty(session('business.enabled_modules')) ? session('business.enabled_modules') : [];
          
            $is_admin = auth()->user()->hasRole('Admin#' . session('system_details.id')) ? true : false;
            //Home
           
            $menu->header('MAIN MENU');
            $menu->url(action('HomeController@index'), __('Dashboard'), ['icon' => 'bx bx-home', 'active' => request()->segment(1) == 'home'])->order(5);
           $menu->url(action('CampusController@index'), __('campus.campuses'), ['icon' => 'bx bx-buildings', 'active' => request()->segment(1) == 'campuses'])->order(5);

         

             //Accounts dropdown
            //if (auth()->user()->can('account.access')) {
                $menu->dropdown(
                    __('Globle'),
                    function ($sub) {
                        $sub->url(
                            action('SystemSettingController@index'),
                            __('settings.settings'),
                            ['icon' => 'bx bx-cog ', 'active' => request()->segment(1) == 'setting']
                        );
                     
                        $sub->url(
                            action('SessionController@index'),
                            __('session.sessions'),
                            ['icon' => 'bx bx-calendar ', 'active' => request()->segment(1) == 'session']
                        );

                        $sub->url(
                            action('DesignationController@index'),
                            __('designation.designations'),
                            ['icon' => 'bx bx-shape-circle ', 'active' => request()->segment(1) == 'designation']
                        );
                        $sub->url(
                            action('DiscountController@index'),
                            __('discount.discounts'),
                            ['icon' => 'bx bx-disc ', 'active' => request()->segment(1) == 'discounts']
                        );
                        $sub->url(
                            action('AwardController@index'),
                            __('award.awards'),
                            ['icon' => 'bx bx-award ', 'active' => request()->segment(1) == 'awards']
                        );
                        $sub->url(
                            action('ClassLevelController@index'),
                            __('class_level.class_level'),
                            ['icon' => 'bx bx-menu ', 'active' => request()->segment(1) == 'class_levels']
                        );
                     
                    },
                    ['icon' => 'bx bx-globe']
                )->order(10);
            //}
            
            $menu->dropdown(
                __('Academic'),
                function ($sub) {
                    $sub->url(
                        action('ClassController@index'),
                        __('class.classes'),
                        ['icon' => 'bx bx-cog ', 'active' => request()->segment(1) == 'classes']
                    );
                    $sub->url(
                        action('ClassSectionController@index'),
                        __('class_section.sections'),
                        ['icon' => 'bx bx-cog ', 'active' => request()->segment(1) == 'sections']
                    );
                 
                 
                },
                ['icon' => 'bx bx-globe']
            )->order(15);
            //Accounts dropdown
            if (auth()->user()->can('account.access')) {
                $menu->dropdown(
                    __('lang_v1.payment_accounts'),
                    function ($sub) {
                        $sub->url(
                            action('AccountController@index'),
                            __('account.list_accounts'),
                            ['icon' => 'bx bx-list-ul', 'active' => request()->segment(1) == 'account' && request()->segment(2) == 'account']
                        );
                        // $sub->url(
                        //     action('AccountReportsController@balanceSheet'),
                        //     __('account.balance_sheet'),
                        //     ['icon' => 'fa fas fa-book', 'active' => request()->segment(1) == 'account' && request()->segment(2) == 'balance-sheet']
                        // );
                        // $sub->url(
                        //     action('AccountReportsController@trialBalance'),
                        //     __('account.trial_balance'),
                        //     ['icon' => 'fa fas fa-balance-scale', 'active' => request()->segment(1) == 'account' && request()->segment(2) == 'trial-balance']
                        // );
                        // $sub->url(
                        //     action('AccountController@cashFlow'),
                        //     __('lang_v1.cash_flow'),
                        //     ['icon' => 'fa fas fa-exchange-alt', 'active' => request()->segment(1) == 'account' && request()->segment(2) == 'cash-flow']
                        // );
                        // $sub->url(
                        //     action('AccountReportsController@paymentAccountReport'),
                        //     __('account.payment_account_report'),
                        //     ['icon' => 'fa fas fa-file-alt', 'active' => request()->segment(1) == 'account' && request()->segment(2) == 'payment-account-report']
                        //);
                    },
                    ['icon' => 'bx bx-money']
                )->order(20);
            }

      
        });
        
    

        return $next($request);
    }
}
