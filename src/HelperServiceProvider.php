<?php

namespace EnesCakir\Helper;

use Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class HelperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blueprint::macro('baseActions', function ($tableName = 'users', $softDelete = true, $morphable = false) {
            if ($morphable) {
                $this->nullableMorphs('created_by');
                $this->nullableMorphs('updated_by');
            } else {
                $this->integer('created_by')->unsigned()->nullable();
                $this->foreign('created_by')->references('id')->on($tableName);

                $this->integer('updated_by')->unsigned()->nullable();
                $this->foreign('updated_by')->references('id')->on($tableName);
            }

            if ($softDelete) {
                if ($morphable) {
                    $this->nullableMorphs('deleted_by');
                } else {
                    $this->integer('deleted_by')->unsigned()->nullable();
                    $this->foreign('deleted_by')->references('id')->on($tableName);
                }
                $this->softDeletes();
            }
            $this->timestamps();
        });

        Blueprint::macro('approval', function ($tableName = 'users', $morphable = false) {
            $this->timestamp('approved_at')->nullable();
            if ($morphable) {
                $this->nullableMorphs('approved_by');
            } else {
                $this->integer('approved_by')->unsigned()->nullable();
                $this->foreign('approved_by')->references('id')->on($tableName);
            }
        });

        Route::macro('approve', function ($name, $controller) {
            Route::as("{$name}.approve")->put("{$name}/{{$name}}/approve", "{$controller}@approve");
        });
    }

    public function register()
    {
        # code...
    }
}
