<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'posicao', 'abreviacao', 'testamento_id'];

    //pega testamento

    public function testamento(){
        return $this->belongsTo(Testamento::class);
    }

    // Pegar todos os  versiculos vinculado ao livro

    public function versiculos(){
        return $this->hasMany(Versiculo::class);
    }
}
