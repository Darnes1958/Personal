<?php

namespace App\Filament\Acc\Pages;

use Filament\Schemas\Schema;
use App\Enums\AccLevel;
use App\Livewire\Traits\PublicTrait;
use App\Models\Account;
use App\Models\Kyde;
use App\Models\KydeData;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Support\Enums\IconSize;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class Khashf extends Page implements HasForms,HasTable
{
    use InteractsWithForms,InteractsWithTable;
    use PublicTrait;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'filament.acc.pages.khashf';
    protected ?string $heading='';
    protected static ?string $model = KydeData::class;


    protected static ?string $navigationLabel='كشف حساب';

    public $account_id;
    public $acc_level=4;
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
               Select::make('account_id')
                ->label('الحساب')
                ->searchable()
                ->preload()
                ->options(function (){
                    return Account::where('acc_level','<=',$this->acc_level)->pluck('name', 'id') ;
                })
                ->live()
                ->columnSpan(2),
               $this->getAcc_levelFromComponent()
                   ->afterStateUpdated(function ($state){
                       $this->acc_level=$state->value;
                   })
                   ->columnSpan(2),
            ])
            ->columns(6);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                info($this->account_id);
                if (!$this->account_id) $kydeData=KydeData::where('account_id', $this->account_id);
                else
                $kydeData=KydeData::where('account_id', $this->account_id)
                    ->orwhereIn('account_id', Account::where('grand_id',$this->account_id)->select('id'))
                    ->orwhereIn('account_id', Account::where('father_id',$this->account_id)->select('id'))
                    ->orwhereIn('account_id', Account::where('son_id',$this->account_id)->select('id'));
                return $kydeData;

            }
            )
            ->emptyStateHeading('لا توجد بيانات')

            ->columns([
                $this->getKydedataFormComponent('kyde_id'),
                $this->getKydedataFormComponent('kyde_date'),
                $this->getKydedataFormComponent('notes'),
                $this->getKydedataFormComponent('account_id'),
                $this->getKydedataFormComponent('full_name'),
                $this->getMdenFormComponent(),
                $this->getDaenFormComponent(),
            ]);

    }
}
