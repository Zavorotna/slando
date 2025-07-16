<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subsubcategory extends Model
{
    use HasFactory;

    protected $table = 'sub_subcategories';
    protected $primaryKey = 'id';
    public $fillable = [
        'title',
        'slug',
        'subcategory_id'
    ];

    public static function selectAll() 
    {
        return DB::table('sub_subcategories as s')
            ->join('subcategories as sc', 's.subcategory_id', '=', 'sc.id')
            ->select('s.*', 'sc.title as subcategory_title')
            ->orderBy('s.id')
            ->paginate(10);
    }

    public static function addSubsubcategory($data)
    {
        DB::table('sub_subcategories')->insert($data);
        
    }

    public static function selectSubsubcategory($id)
    {
        return DB::table('sub_subcategories')->find($id);
    }

    public static function updateSubsubcategory($data, $id)
    {
        return DB::table('sub_subcategories')
            ->where('id', $id)
            ->update([
                'title' => $data['title'],
                'slug' => str($data['title'])->slug(),
                'subcategory_id' => $data['subcategory_id'],
                'updated_at' => now(),
            ]);
    }

    public static function deleteSubsubcategory($id)
    {
        DB::table('sub_subcategories')->where('id', $id)->delete();
    }

}
