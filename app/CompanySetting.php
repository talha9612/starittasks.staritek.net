<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $table = 'company_setting';
    public function ContactPerson(){
        return $this->belongsTo('App\User','contact_person', 'id');
    }
}
