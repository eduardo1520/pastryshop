<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'date_birth',
        'address',
        'complement',
        'neighborhood',
        'cep',
        'date_entry'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
