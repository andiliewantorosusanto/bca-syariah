<?php
/**
 * Created By DhanPris
 *
 * @Filename     baseRepositoryTrait.php
 * @LastModified 6/11/18 3:54 PM.
 *
 * Copyright (c) 2018. All rights reserved.
 */

namespace App\Traits;

trait baseRepositoryTrait
{
    /**
     * Get number of records
     *
     * @return array
     */
    public function getNumber()
    {
        return $this->model->count();
    }

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function updateColumn($id, $input)
    {
        $this->model = $this->getById($id);

        foreach ($input as $key => $value) {
            $this->model->{$key} = $value;
        }

        return $this->model->save();
    }

    /**
     * Destroy a model.
     *
     * @param $model
     * @return mixed
     * @internal param $id
     */
    public function destroy($model)
    {
        return $model->delete();
    }

    /**
     * Destroy a model.
     *
     * @param $model
     * @return mixed
     * @internal param $id
     */
    public function forceDestroy($model)
    {
        return $model->forceDelete();
    }

    /**
     * Get model by id.
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->where('id', $id)->first();
    }

    public function getByIdWith($id, array $relations)
    {
        return $this->model->where('id', $id)->with($relations)->first();
    }

    /**
     * Get all the records
     *
     * @return array User
     */
    public function all()
    {

        return $this->model->get();
    }

    /**
     * Get number of the records
     *
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return mixed
     */
    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * Store a new record.
     *
     * @param  $input
     * @return mixed
     */
    public function store($input)
    {
        return $this->save($this->model, $input);
    }

    public function create($input,$user_id)
    {
        $input['created_by'] = $input['updated_by'] = $user_id;
        return $this->model->create($input);
    }

    public function firstOrCreate($input)
    {
        return $this->model->firstOrCreate($input);
    }

    /**
     * Insert Multiple Data
     *
     * @param $data
     * @return mixed
     */
    public function insert($data)
    {
        return $this->model->insert($data);
    }

    /**
     * Update a record by id.
     *
     * @param  $id
     * @param  $input
     * @return mixed
     */
    public function update($id, $input, $updated_at = true)
    {
        $this->model = $this->getById($id);

        return $this->save($this->model, $input, $updated_at);
    }

    public function updateOrCreate(array $identifier,array $input)
    {
        return $this->model->updateOrCreate($identifier,$input);
    }

    /*
    ini coming soon fitur nya bro.di laravel masih gak ada
    */
    public function upsert(array $data,array $identifier,array $attribute) {
        return $this->model->upsert($data,$identifier,$attribute);
    }

    /**
     * Save the input's data.
     *
     * @param  $input
     * @return mixed
     * @internal param $model
     */
    public function save($model, $input, $updated_at = true)
    {
        $model->fill($input);
        if ($updated_at === false) {
            $model->timestamps = false;
        }
        $model->save();

        return $model;
    }

    /**
     * @param $input
     * @return mixed
     * @internal param $model
     */
    public function datatableQuery($input)
    {
        return $this->model->select($input);
    }

    /**
     * Get DatatableData With Relation
     *
     * @param $select
     * @param $with
     * @return mixed
     */
    public function datatableQueryWith($select, $with)
    {
        $model = $this->datatableQuery($select);

        return $model->with($with);
    }
}
