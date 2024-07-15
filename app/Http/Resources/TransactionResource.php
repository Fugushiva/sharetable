<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class TransactionResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'reservation_id' => $this->reservation_id,
            'host_id' => $this->host_id,
            'quantity' => $this->quantity,
            'currency' => $this->currency,
            'payment_status' => $this->payment_status,
            'stripe_transaction_id' => $this->stripe_transaction_id,
            'commission' => $this->commission,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
