<?php

namespace App\Models\Newsletter;

use App\Events\Newsletter\Signining;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Lead extends Model
{
    use Notifiable;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'newsletter_leads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'active',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'creating' => Signining::class,
    ];

    public function disable()
    {
        return $this->update([
            'active' => false
        ]);
    }
}
