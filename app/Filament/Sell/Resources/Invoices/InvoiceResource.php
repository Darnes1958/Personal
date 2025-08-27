<?php

namespace App\Filament\Sell\Resources\Invoices;

use App\Filament\Sell\Resources\Invoices\Pages\CreateInvoice;
use App\Filament\Sell\Resources\Invoices\Pages\EditInvoice;
use App\Filament\Sell\Resources\Invoices\Pages\ListInvoices;
use App\Filament\Sell\Resources\Invoices\Pages\ViewInvoice;
use App\Filament\Sell\Resources\Invoices\Schemas\InvoiceForm;
use App\Filament\Sell\Resources\Invoices\Schemas\InvoiceInfolist;
use App\Filament\Sell\Resources\Invoices\Tables\InvoicesTable;
use App\Models\Invoice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    protected static ?string $pluralLabel='فواتير';


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return InvoiceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InvoiceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvoicesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInvoices::route('/'),
            'create' => CreateInvoice::route('/create'),
            'view' => ViewInvoice::route('/{record}'),
            'edit' => EditInvoice::route('/{record}/edit'),
        ];
    }
}
