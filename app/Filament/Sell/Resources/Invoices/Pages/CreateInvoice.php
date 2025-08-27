<?php

namespace App\Filament\Sell\Resources\Invoices\Pages;

use App\Filament\Sell\Resources\Invoices\InvoiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;
}
