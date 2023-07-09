<?php

namespace App\Repositories;
use App\Models\Product;

class ProductRepository
{
	private $model;
	public function __construct(Product $model)
	{
		$this->model = $model;
	}
	public function findAll()
	{
		return $this->model->all();
	}
    public function find($id)
    {
        return $this->model->find($id);
    }
    public function save($data)
    {
        return $this->model->create($data);
    }
    public function update(array $data, $id)
    {
        return tap($this->model->find($id))->update($data);
    }
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }
}
