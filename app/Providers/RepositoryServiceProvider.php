<?php

namespace App\Providers;

use App\Contracts\AttributeSet\AttributeSetContract;
use App\Contracts\AttributeSet\AttributeSetTranslationContract;
use App\Contracts\Brand\BrandContract;
use App\Contracts\Brand\BrandTranslationContract;
use App\Contracts\Category\CategoryContract;
use App\Contracts\Category\CategoryTranslationContract;
use App\Contracts\Country\CountryContract;
use App\Contracts\Currency\CurrencyContract;
use App\Repositories\AttributeSet\AttributeSetRepository;
use App\Repositories\AttributeSet\AttributeSetTranslationRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Brand\BrandTranslationRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryTranslationRepository;
use App\Repositories\Country\CountryRepository;
use App\Repositories\Currency\CurrencyRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // $this->app->bind(
        //     \App\Interfaces\CategoryInterface::class,
        //     \App\Repositories\CategoryRepository::class
        // );

        //Category
        $this->app->bind(CategoryContract::class, CategoryRepository::class);
        $this->app->bind(CategoryTranslationContract::class, CategoryTranslationRepository::class);

        //Brand
        $this->app->bind(BrandContract::class, BrandRepository::class);
        $this->app->bind(BrandTranslationContract::class, BrandTranslationRepository::class);

        //Attribute Set
        $this->app->bind(AttributeSetContract::class, AttributeSetRepository::class);
        $this->app->bind(AttributeSetTranslationContract::class, AttributeSetTranslationRepository::class);

        //Currency
        $this->app->bind(CurrencyContract::class, CurrencyRepository::class);

        //County
        $this->app->bind(CountryContract::class, CountryRepository::class);
    }
}

?>
