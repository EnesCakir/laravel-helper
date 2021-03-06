<?php

namespace EnesCakir\Helper\Base;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * The Eloquent builder.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Create a new ThreadFilters instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->getFilters() as $filter => $value) {
            $methodName = camel_case($filter);
            if (method_exists($this, $methodName)) {
                $this->$methodName($value);
            } elseif (method_exists($this->builder->getModel(), 'scope' . ucfirst($methodName))) {
                $this->builder->$methodName($value);
            } else {
                $this->builder->where($filter, $value);
            }
        }
        return $this->builder;
    }

    /**
     * Fetch all relevant filters from the request.
     *
     * @return array
     */
    public function getFilters()
    {
        return array_filter($this->request->only($this->filters), 'strlen');
    }

    public static function getAppends()
    {
        $appends = (new static(request()))->getFilters();
        $appends['per_page'] = request()->per_page;
        return $appends;
    }
}
