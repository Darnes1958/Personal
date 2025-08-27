<?php

namespace App\Filament\Sell\Resources\Invoices\Tables;

use App\Filament\PublicTrait;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Spatie\LaravelPdf\Facades\Pdf;

class InvoicesTable
{
    use PublicTrait;
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('invoice_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('Bank.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('invoice_number')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('specifications')
                    ->searchable(),
                TextColumn::make('engine_number')
                    ->searchable(),
                TextColumn::make('color')
                    ->searchable(),
                TextColumn::make('model')
                    ->searchable(),
                TextColumn::make('chassis_number')
                    ->searchable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('print')
                    ->icon('heroicon-o-printer')
                    ->iconButton()
                    ->color('primary')
                    ->action(function (Model $record) {
                        Pdf::view('PDF.PdfInvoice',['record'=>$record,])
                            ->footerView('PDF.footer')
                            ->margins(20,10,20,10)
                            ->save(public_path().'/Invoice.pdf');

                        return Response::download(public_path().'/Invoice.pdf',
                            'filename.pdf', self::ret_spatie_header());

                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
