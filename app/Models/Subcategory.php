<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subcategory extends Model
{
    use HasFactory;

    protected $table = 'subcategories';
    protected $primaryKey = 'id';
    public $fillable = [
        'title',
        'slug',
        'category_id'
    ];

    public static function selectAll() 
    {
        return DB::table('subcategories as s')
            ->join('categories as c', 's.category_id', '=', 'c.id')
            ->select('s.*', 'c.title as category_title')
            ->orderBy('s.id')
            ->paginate(10);
    }

    public static function addSubcategory($data)
    {
        DB::table('subcategories')->insert([
            'title' => $data['title'],
            'slug' => str($data['title'])->slug(),
            'category_id' => $data['category_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
    }

    public static function selectSubcategory($id)
    {
        return DB::table('subcategories')->find($id);
    }

    public static function updateSubcategory($data, $id)
    {
        return DB::table('subcategories')
            ->where('id', $id)
            ->update([
                'title' => $data['title'],
                'slug' => str($data['title'])->slug(),
                'category_id' => $data['category_id'],
                'updated_at' => now(),
            ]);
    }

    public static function deleteSubcategory($id)
    {
        DB::table('subcategories')->where('id', $id)->delete();
    }
}
