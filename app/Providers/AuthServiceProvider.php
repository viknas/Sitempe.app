<?php

namespace App\Providers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Product;
use App\Models\Request;
use App\Models\Sale;
use App\Models\User;
use App\Policies\ExpensePolicy;
use App\Policies\IncomePolicy;
use App\Policies\ProductPolicy;
use App\Policies\RequestPolicy;
use App\Policies\SalePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Income::class => IncomePolicy::class,
        Request::class => RequestPolicy::class,
        Sale::class => SalePolicy::class,
        Expense::class => ExpensePolicy::class,
        User::class => UserPolicy::class,
        Product::class => ProductPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
