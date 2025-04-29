<?php

   namespace App\Models;

   use Illuminate\Database\Eloquent\Model;

   class SupportMessage extends Model
   {
       protected $fillable = ['thread_id', 'user_id', 'message'];

       public function thread()
       {
           return $this->belongsTo(SupportThread::class);
       }

       public function user()
       {
           return $this->belongsTo(User::class);
       }
   }