<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    public function icon()
    {
        if (preg_match('/^#([A-Fa-f0-9]{3}){1,2}$/', $this->icon)) {
            return '<span class="badge"style="display:inline-block;width:18px;height:18px;border-radius:4px;background-color:' . $this->icon . ';border:1px solid #333;"></span>';
        }

        return '<span class="badge badge-primary" style="padding:4px 8px;border-radius:4px;font-size:12px;">' . e($this->icon) . '</span>';
    }
}
