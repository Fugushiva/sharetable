<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Transaction::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            [
                'user_name' => 'Bob',
                'host_name' => 'Jerome',
                'quantity' => 1,
                'currency' => 'EUR',
                'payment_status' => 'completed',
                'stripe_transaction_id' => 'ch_1J2e3s4u5s6t7a8n9c0e',
                'commission' => 5,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
                'reservation_id' => 1,
            ],
            [
                'user_name' => 'Jerome',
                'host_name' => 'Ayu',
                'quantity' => 1,
                'currency' => 'EUR',
                'payment_status' => 'completed',
                'stripe_transaction_id' => 'ch_1J2e3s4u5s6t7a8n9c0e',
                'commission' => 2,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
                'reservation_id' => 2,
            ],
            [
                'user_name' => 'Chen',
                'host_name' => 'Jerome',
                'quantity' => 1,
                'currency' => 'EUR',
                'payment_status' => 'completed',
                'stripe_transaction_id' => 'ch_2Jg61sea8s6t7a8n9c0e',
                'commission' => 5,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
                'reservation_id' => 3,
            ],
            [
                'user_name' => 'Bob',
                'host_name' => 'Ayu',
                'quantity' => 1,
                'currency' => 'EUR',
                'payment_status' => 'completed',
                'stripe_transaction_id' => 'ch_3Jq456e8a1d6n9c0e',
                'commission' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'reservation_id' => 4,
            ],
        ];

        foreach($data as &$transaction){
            $user = User::where([
                ['firstname', '=', $transaction['user_name']]
            ])->first();
            $host = User::where([
                ['firstname', '=', $transaction['host_name']]
            ])->first();

            $transaction['user_id'] = $user->id;
            $transaction['host_id'] = $host->id;

            unset($transaction['user_name']);
            unset($transaction['host_name']);
        }

        DB::table('transactions')->insert($data);
    }
}
