<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model as EloquentModel;

trait DatabaseRepositoryTrait
{
  /**
   * Get all of the models from the database.
   *
   * @return \Illuminate\Database\Eloquent\Collection
   */
    public function all()
    {
        return $this->query()->get();
    }

    /**
     * Get the paginated models from the database.
     *
     * @param  int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 10)
    {
        return $this->query()->latest()->paginate($perPage);
    }

    /**
     * Get a model by its primary key.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function get($id)
    {
        $model = $this->query()->find($id);

        return $model;
    }


    /**
     * Get a model by matching its column date.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getWhereDate($date)
    {
        //only applied for models that have
        //starts_at and ends_at as columns.

        $model = $this->query()->where('starts_at', '<=', $date)
                            ->where('ends_at', '>=', $date);

        return $model;
    }

    /**
     * Get the model data by adding the given query
     *
     * @param  string $column
     * @param  mixed $value
     * @param  array $moreWhere
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWhereIn($column, $value, array $moreWhere = null)
    {
        $query = $this->query()->whereIn($column, $value);

        if (! is_null($moreWhere)) {
            $query->where($moreWhere);
        }

        $models = $query->get();

        return $models;
    }

    /**
     * Get models by the value.
     *
     * @param int $id
     * @param array $moreWhere
     * @return \Illuminate\Database\Eloquent\Collection
     *
     */
    public function getWhere($column, $value, array $moreWhere = null)
    {
        $query = $this->query()->where($column, $value);

        if (! is_null($moreWhere)) {
            $query->where($moreWhere);
        }

        $models = $query->get();

        return $models;
    }

    /**
     * Save a new model and return the instance.
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes)
    {
        $modelName = $this->model;

        return $modelName::create($attributes);
    }

    /**
     * Update the model by the given attributes.
     *
     * @param  \Illuminate\Database\Eloquent\Model|int $model
     * @return bool|int
     */
    public function update($id, array $attributes)
    {
        $model = $this->model;

        return $this->get($id)->update($attributes);
    }

    /**
     * Begin querying the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return call_user_func("{$this->model}::query");
    }
}
