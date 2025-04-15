<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    public $fillable = [
        'title',
        'slug'
    ];

    public static function selectAll()
    {
       return DB::table('categories')->select('id', 'title')->orderBy('id')->get();
    }

    public static function addCategory($title)
    {
        return DB::table('categories')->insert([
            'title' => $title,
            'slug' => str($title)->slug(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public static function selectCategory($id)
    {
        return DB::table('categories')->find($id);
    }

    public static function updateCategory($title, $id)
    {
        return DB::table('categories')
            ->where('id', $id)
            ->update([
                'title' => $title,
                'slug' => str($title)->slug(),
                'updated_at' => now(),
            ]);
    }

    public static function deleteCategory($id)
    {
        DB::table('categories')->where('id', $id)->delete();
    }
}
