<?php

namespace App\Services;

abstract class BaseService
{
    protected $model;

    //gán con trỏ tới model trong service được kế thừa
    public function __construct()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    //tạo 1 hàm trừu tượng
    abstract public function getModel();


    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data,$id)
    {
        return $this->model->where('id',$id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->where('id',$id)->delete();
    }
}
