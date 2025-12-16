<?php

use App\Broadcasting\PedidoChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('confeitaria.{confeitariaId}', PedidoChannel::class);

