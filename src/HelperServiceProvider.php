<?php

namespace EnesCakir\Helper;

use Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class HelperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blueprint::macro('baseActions', function ($tableName = 'users', $softDelete = true, $morphable = false) {
            if ($morphable) {
                $this->nullableMorphs('created_by');
                $this->nullableMorphs('updated_by');
            } else {
                $this->bigInteger('created_by')->unsigned()->nullable();
                $this->foreign('created_by')->references('id')->on($tableName);

                $this->bigInteger('updated_by')->unsigned()->nullable();
                $this->foreign('updated_by')->references('id')->on($tableName);
            }

            if ($softDelete) {
                if ($morphable) {
                    $this->nullableMorphs('deleted_by');
                } else {
                    $this->bigInteger('deleted_by')->unsigned()->nullable();
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
                $this->bigInteger('approved_by')->unsigned()->nullable();
                $this->foreign('approved_by')->references('id')->on($tableName);
            }
        });

        Route::macro('approve', function ($name, $controller) {
            Route::as("{$name}.approve")->put("{$name}/{{$name}}/approve", "{$controller}@approve");
        });

        Blueprint::macro('favorite', function ($tableName = 'users', $morphable = false) {
            $this->timestamp('favorited_at')->nullable();
            if ($morphable) {
                $this->nullableMorphs('favorited_by');
            } else {
                $this->bigInteger('favorited_by')->unsigned()->nullable();
                $this->foreign('favorited_by')->references('id')->on($tableName);
            }
        });

        Route::macro('favorite', function ($name, $controller) {
            Route::as("{$name}.favorite")->put("{$name}/{{$name}}/favorite", "{$controller}@favorite");
        });

        Builder::macro('safePaginate', function ($perPage = 25) {
            $page = request('page');

            $per = request()->filled('per_page')
                ? request('per_page')
                : $perPage;
            $result = $this->paginate($per);

            if ($page && $page != 1 && $page > $result->lastPage()) {
                abort(
                    redirect(
                        request()->fullUrlWithQuery(
                            array_merge(
                                request()->all(),
                                ['page' => $result->lastPage()]
                            )
                        )
                    )
                );
            }

            return $result;
        });

        HasManyThrough::macro('safePaginate', function ($perPage = 25) {
            $page = request('page');

            $per = request()->filled('per_page')
                ? request('per_page')
                : $perPage;
            $result = $this->paginate($per);

            if ($page && $page != 1 && $page > $result->lastPage()) {
                abort(
                    redirect(
                        request()->fullUrlWithQuery(
                            array_merge(
                                request()->all(),
                                ['page' => $result->lastPage()]
                            )
                        )
                    )
                );
            }

            return $result;
        });

        Builder::macro('toSelect', function ($placeholder = null, $key = 'id', $value = 'name') {
            $result = static::orderBy($value)->get()->pluck($value, $key);

            return $placeholder
                ? collect(['' => $placeholder])->union($result)
                : $result;
        });
    }

    public function register()
    {
        # code...
    }
}
