<?php

namespace App\Repositories;
use App\Models\Purchase;

class PurchaseRepository
{
	private $model;
	public function __construct(Purchase $model)
	{
		$this->model = $model;
	}
	public function findAll()
	{
        $purchases = $this->model->select([
            'purchases.id', 'c.name as client', 'p.name as product', 'p.price'
        ])
        ->join('clients as c', 'c.id', '=', 'purchases.client_id')
        ->join('products as p', 'p.id', '=', 'purchases.product_id')
        ->get();

		return $purchases;
	}
    public function find($id)
    {
        $purchase = $this->model->select([
            'purchases.id', 'c.name as client', 'p.name as product', 'p.price'
        ])
        ->join('clients as c', 'c.id', '=', 'purchases.client_id')
        ->join('products as p', 'p.id', '=', 'purchases.product_id')
        ->where('purchases.id', '=', $id)
        ->get();

        return $purchase;
    }
    public function save($data)
    {
        $registerIds = array_map(function($purchase) {
            return Purchase::insertGetId($purchase);
        }, $data['purchases']);

        $purchases = Purchase::select([
            'purchases.id', 'c.name as client', 'p.name as product', 'p.price'
        ])
        ->join('clients as c', 'c.id', '=', 'purchases.client_id')
        ->join('products as p', 'p.id', '=', 'purchases.product_id')
        ->whereIn('purchases.id', $registerIds)->get();

        return $purchases;
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
