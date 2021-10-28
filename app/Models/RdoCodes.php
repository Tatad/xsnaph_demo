<?php 
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    class RdoCodes extends Model
    {
        protected $table = 'rdo_codes';

        protected $fillable = [
	        'code'
	    ];
    }
?>