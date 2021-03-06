<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    /**
     * save a journal model from user class.
     * (auto indicates id of user to journal record)
     *
     * @param Journal $oJournal
     * @return void
     */
    public function publish(Journal $oJournal)
    {
        return $this->journals()->save($oJournal);
    }
}
