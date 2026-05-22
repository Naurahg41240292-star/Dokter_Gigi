<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- TAMBAHIN INI
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pricelist extends Model // <-- Ubah dari Pembayaran jadi Pricelist
{
    use HasFactory;

    // Tambahkan baris ini agar Laravel pakai nama tabel pricelists
    protected $table = 'pricelists'; 

    protected $fillable = [
        'user_id', 'invoice_number', 'amount', 'description', 
        'status', 'payment_method', 'payment_date', 'notes'
    ];
}