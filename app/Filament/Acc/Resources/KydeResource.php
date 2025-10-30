<?php

namespace App\Filament\Acc\Resources;

use App\Filament\PublicTrait;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Acc\Resources\KydeResource\Pages\ListKydes;
use App\Filament\Acc\Resources\KydeResource\Pages\CreateKyde;
use App\Filament\Acc\Resources\KydeResource\Pages\EditKyde;
use App\Filament\Acc\Resources\KydeResource\Pages;
use App\Filament\Acc\Resources\KydeResource\RelationManagers;

use App\Models\Kyde;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\HtmlString;

class KydeResource extends Resource
{
    use PublicTrait;
    protected static ?string $model = Kyde::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel='قيود يومية';

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                Section::make()
                 ->schema([
                     DatePicker::make('kyde_date')
                         ->label('التاريح')
                         ->default(now())
                         ->columnSpan(2)
                         ->required(),
                     Textarea::make('notes')
                         ->rows(4)
                         ->maxLength(255)
                         ->required()
                         ->columnSpan(2)
                         ->label('البيان'),
                     TextInput::make('totMden')
                      ->disabled()
                      ->default(0)
                      ->label('اجمالي المدين'),
                     TextInput::make('totDaen')
                         ->disabled()
                         ->default(0)
                         ->label('اجمالي الدائن'),
                 ])
                 ->columnSpan(4)
                 ->columns(2),
                Section::make()
                 ->schema([
                     Forms\Components\Repeater::make('KydeData')
                         ->hiddenLabel()
                         ->required()
                         ->relationship()
                         ->table([
                             TableColumn::make('رقم الحساب')
                                 ->width('50%'),
                             TableColumn::make('مدين')
                                 ->width('25%'),
                             TableColumn::make('دائن')
                                 ->width('25%'),
                         ])
                         ->schema([
                            Select::make('account_id')
                                ->required()
                                ->preload()
                                ->live()
                                ->disableOptionWhen(function ($value, $state, Get $get) {
                                    return collect($get('../*.account_id'))
                                        ->reject(fn($id) => $id == $state)
                                        ->filter()
                                        ->contains($value);
                                })
                                ->searchable()
                                ->relationship('Account','name',
                                    modifyQueryUsing: fn (Builder $query) => $query->where('is_active',1),),
                            TextInput::make('mden')
                             ->numeric()

                             ->afterStateUpdated(function (Set $set,$state,Get $get){
                                 if ($state==null) {$set('mden',0);return;}
                                 if (filled($state)) $set('daen',0);
                                 $set('../../totMden',collect($get('../../KydeData'))->sum('mden'));
                                 $set('../../totDaen',collect($get('../../KydeData'))->sum('daen'));

                             })
                                ->required()
                             ->live(onBlur: true)
                             ,
                            TextInput::make('daen')
                                ->numeric()
                                ->afterStateUpdated(function (Set $set,$state,Get $get){
                                    if ($state==null) {$set('daen',0);return;}
                                    if (filled($state)) $set('mden',0);
                                    $set('../../totMden',collect($get('../../KydeData'))->sum('mden'));
                                    $set('../../totDaen',collect($get('../../KydeData'))->sum('daen'));

                                })

                                ->required()
                                ->live(onBlur: true)
                                ,
                        ])
                         ->live(onBlur: true)
                         ->grid(2)
                         ->addActionLabel('اضافة')
                         ->addable(function ($state){
                             $flag=true;
                             foreach ($state as $item) {
                                 if (!$item['account_id'] || (!$item['mden'] && !$item['daen']) )
                                 {$flag=false; break;}
                             }
                             return $flag;
                         })
                 ])
                 ->columnSpan(8)

            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at','desc')
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable()
                    ->label('الرقم الالي'),
                TextColumn::make('kyde_date')
                    ->searchable()
                    ->sortable()
                    ->label('التاريخ'),
                TextColumn::make('notes')
                    ->searchable()
                    ->sortable()
                    ->label('البيان'),
                TextColumn::make('tot_mden')
                    ->label('مدين'),
                TextColumn::make('tot_daen')
                    ->label('دائن'),

            ])
            ->filters([
                Filter::make('anyfilter')
                    ->schema([
                        DatePicker::make('date1')
                            ->prefix('من تاريخ')
                            ->hiddenLabel(),
                        DatePicker::make('date2')
                            ->prefix('إلي تاريخ')
                            ->hiddenLabel(),

                    ])
                    ->query(function ( $query, array $data) {
                        return $query
                            ->when($data['date1'],
                                fn ( $query, $date) => $query->where('kyde_date','>=',$data['date1']))
                            ->when($data['date2'],
                                fn ( $query, $date) => $query->where('kyde_date','<=',$data['date2']),

                            );
                    })
                    ,
            ])
            ->recordActions([
                EditAction::make()->hidden(fn($record): bool => $record->kydeable_id!=null),
                DeleteAction::make()->hidden(fn($record): bool => $record->kydeable_id!=null),
                Action::make('kydeview')
                    ->iconButton()
                    ->iconSize(IconSize::Small)
                    ->icon('heroicon-o-list-bullet')
                    ->color('success')
                    ->modalHeading(false)
                    ->modalSubmitAction(false)
                    ->modalCancelAction(fn (Action $action) => $action->label('عودة'))
                    ->modalContent(fn (Kyde $record): View => view(
                        'view-kyde-data-widget',
                        ['kyde_id' => $record->id],
                    )),
                Action::make('print')
                 ->iconButton()
                 ->icon(Heroicon::Printer)
                 ->action(function ($record) {

                     return Response::download(self::ret_spatie($record,
                         'PDF.kyde-pdf'
                     ), 'filename.pdf', self::ret_spatie_header());

                 })
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => ListKydes::route('/'),
            'create' => CreateKyde::route('/create'),
            'edit' => EditKyde::route('/{record}/edit'),
        ];
    }
}
