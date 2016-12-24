<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Connection;

class FCMTokenRepository 
{
    protected $db;

    protected $table = 'fcm_tokens';

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function getByUser($user)
    {
        return $this->db->table($this->table)->where('user_id', $user->id)->get();
    }

    public function getByToken($token)
    {
        return $this->db->table($this->table)->where('token', $token)->first();
    }

    public function storeIndependentToken($token)
    {
        return $this->db->table($this->table)->insert([
            'token' => $token,
            'created_at' => new Carbon(),
            'updated_at' => new Carbon()
        ]);
    }

    public function storeDependentToken($token, $user) 
    {
        return $this->db->table($this->table)->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => new Carbon(),
            'updated_at' => new Carbon()
        ]);
    }

    public function updateByToken($token, $user)
    {
        return $this->db->table($this->table)->where('token', $token)->update([
            'user_id' => $user->id,
            'updated_at' => new Carbon()
        ]);
    }

    public function deleteToken($token) {
        return $this->db->table($this->table)->where('token', $token)->delete();
    }
}