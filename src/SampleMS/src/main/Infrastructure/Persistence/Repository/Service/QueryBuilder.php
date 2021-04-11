<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\Service;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class QueryBuilder
{
    public $builder;

    public function filter($query, $builder): ?LengthAwarePaginator
    {
        $this->builder = $builder;
        $perPage = $this->builder->paginate()->perPage();
        $page = $this->builder->paginate()->currentPage();

        if (!empty($query->params)) {
            foreach ($query->params as $attributes => $value) {
                if (strpos($attributes, '_') !== false) {
                    $query = explode('_', $attributes);
                    $attribute = $query[0];
                    $operation = $query[1];
                    $schema = $this->builder->getConnection()->getSchemaBuilder();

                    if ($schema->hasColumn($this->builder->getModel()->getTable(), $attribute) == false) {
                        continue;
                    }

                    if (method_exists($this, $operation)) {
                        if ($value != "") {
                            $this->builder = $this->$operation($attribute, $value);
                        } else {
                            $this->builder = $this->$operation($attribute);
                        }
                    }
                } else {
                    if ($attributes == 'size') {
                        $perPage = $value;
                    } elseif ($attributes == 'page') {
                        $page = $value;
                    } else {
                        if (!method_exists($this, $attributes)) {
                            continue;
                        }
                        $this->builder = $this->$attributes($value);
                    }
                }
            }
            return $this->builder->paginate($perPage, ['*'], null, $page);
        }

        return $this->builder->paginate();
    }

    public function in($attribute, $value)
    {
        return $this->builder->whereIn($attribute, json_decode($value));
    }

    public function equals($attribute, $value)
    {
        return $this->builder->where($attribute, '=', $value);
    }

    public function greaterThan($attribute, $value)
    {
        return $this->builder->where($attribute, '>', $value);
    }

    public function lessThan($attribute, $value)
    {
        return $this->builder->where($attribute, '<', $value);
    }

    public function greaterOrEqualThan($attribute, $value)
    {
        return $this->builder->where($attribute, '>=', $value);
    }

    public function lessOrEqualThan($attribute, $value)
    {
        return $this->builder->where($attribute, '<=', $value);
    }

    public function year($attribute, $value)
    {
        return $this->builder->whereYear($attribute, '=', $value);
    }

    public function month($attribute, $value)
    {
        return $this->builder->whereMonth($attribute, '=', $value);
    }

    public function sort($attributes)
    {
        foreach ($attributes as $attribute) {
            if (empty($attribute)) {
                continue;
            }
            $attribute = explode(":", $attribute);
            $field = $attribute[0];
            $order = !empty($attribute[1])? $attribute[1] : "asc";
            $this->builder->orderBy($field, $order);
        }
        return $this->builder;
    }

    public function contains($attribute, $value)
    {
        return $this->builder->where($attribute, 'LIKE', "%".$value."%");
    }
}
