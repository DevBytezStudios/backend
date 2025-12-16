<?php

namespace App\Broadcasting;

use App\Models\Confeitaria;
use App\Models\Pedido;

class PedidoChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(Confeitaria $confeitaria,$confeitariaId): array|bool
    {
        return $confeitaria->id == $confeitariaId;
    }
}
