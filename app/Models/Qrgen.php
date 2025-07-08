<?php

namespace App\Models;

use App\Models\Admin\Visitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qrgen extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cardname',
        'firstname',
        'lastname',
        'status',
        'maincolor',
        'gradientcolor',
        'buttoncolor',
        'slug',
        'summary',

        'email1',
        'phone1',
        'mobile1',
        'address1',
        'webaddress1',
        'companyname',
        'jobtitle',
        'cardtype',
        'email2',
        'phone2',
        'mobile2',
        'mobile3',
        'mobile4',
        'fax',
        'fax2',
        'address2',
        'webaddress2',
        'checkgradient',
        'appointment',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'github',

        'behance',
        'linkedin',
        'spotify',
        'tumblr',
        'telegram',
        'pinterest',
        'snapchat',
        'reddit',
        'google',
        'apple',
        'figma',
        'discord',
        'tiktok',
        'whatsapp',
        'skype',
        'google_scholar',
        'medium',

    ];
    public function visitors()
    {
        return $this->hasMany(Visitor::class, 'visiting_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cardOrders()
    {
        return $this->hasMany(CardOrder::class, 'qrgen_id');
    }
}
