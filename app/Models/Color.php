<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'colors';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 
        'slug',
        'hex',
    ];

    public static function createColor($data)
    {
        $data['slug'] = str($data['name'])->slug();

        return Color::create($data);
    }

    public static function updateColor($data, $color): void
    {
        $data['slug'] = str($data['name'])->slug();
        
        $color->update($data);
    }
}
