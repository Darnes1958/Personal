<?php

namespace App\Filament\Acc\Pages;

use App\Enums\Haf_kst_type;
use App\Livewire\Traits\PublicTrait;
use App\Models\Acc;
use App\Models\Account;
use App\Models\Kyde;
use App\Models\KydeData;
use App\Models\Main;
use DefStudio\SearchableInput\DTO\SearchResult;
use DefStudio\SearchableInput\Forms\Components\SearchableInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use function Livewire\of;


class InpKyde extends Page implements HasSchemas,HasTable
{
    use InteractsWithSchemas,InteractsWithTable;
    use PublicTrait;
    protected string $view = 'filament.acc.pages.inp-kyde';

    public $kydedata=[];

    public $account_id,$name,$acc_level,$mden,$daen;

    public function cleanAcc(){
        $this->mden=0;
        $this->daen=0;
        $this->account_id=null;
        $this->dispatch('gotoitem',test: 'account_id');
    }
    public function chkAcc()
    {
      // $this->dispatch('gotoitem',test: 'mden');
    }
    public function chkMden()
    {
        if (!$this->mden)  {
            $this->mden=0;
            $this->dispatch('gotoitem',test: 'daen');
            return ;
        }
        $this->daen=0;
        $this->kydedata[]=['account_id'=>$this->account_id,'mden'=>$this->mden,'daen'=>$this->daen,];
        $this->cleanAcc();
    }
    public function chkDaen()
    {
        if (!$this->daen)  {
            $this->daen=0;
            $this->dispatch('gotoitem',test: 'mden');
            return ;
        }
        $this->mden=0;
        $this->kydedata[]=['account_id'=>$this->account_id,'mden'=>$this->mden,'daen'=>$this->daen,];
        $this->cleanAcc();

    }
    public function Form(Schema $schema):Schema
    {
        return $schema
            ->model(Kyde::class)
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
                ])->columns(2),
                Section::make()
                 ->schema([
                     SearchableInput::make('account_id')->id('account_id')
                         ->placeholder('بحث برقم الحساب او الاسم')
                         ->autocomplete(false)
                         ->searchUsing(function(string $search){
                             return Account::query()
                                 ->where('is_active', 1)
                                 ->where(function ($q) use ($search) {
                                     $q->Where('id', 'like', "%$search%")
                                         ->orWhere('name', 'like', "%$search%");
                                 }
                                 )

                                 ->limit(10)
                                 ->get()
                                 ->map(fn(Account $account) => SearchResult::make($account->id, "[$account->name]  $account->id")
                                     ->withData('account_id', $account->id)
                                     ->withData('acc_level',$account->acc_level)
                                     ->withData('name',$account->name)
                                 )
                                 ->toArray();})
                         ->onItemSelected(function(SearchResult $item,Set $set){
                             $this->account_id=$item->get('account_id');
                             $this->name=$item->get('name');
                             $this->acc_level=$item->get('acc_level');

                             $this->dispatch('gotoitem', test: 'mden');
                         })
                         ->live()
                         ->autofocus()
                         ->columnSpan(2)
                         ->afterStateUpdated(fn($state)=>$this->account_id=$state)
                         ->extraAttributes(['wire:keydown.enter' => "chkAcc",])
                         ->required(),
                     TextInput::make('mden')->id('mden')
                         ->live()
                         ->extraAttributes(['wire:keydown.enter' => "chkMden",])
                         ->afterStateUpdated(fn($state)=>$this->mden=$state)
                         ->label('مدين'),
                     TextInput::make('daen')->id('daen')
                         ->extraAttributes(['wire:keydown.enter' => "chkDaen",])
                         ->afterStateUpdated(fn($state)=>$this->daen=$state)
                         ->label('دائن'),
                 ])->columns(2)
            ]);
    }

   public function table(Table $table): Table
   {
       return $table

           ->records(fn(): Collection=> collect($this->kydedata))
           ->columns([
               TextColumn::make('account_id'),
               TextColumn::make('mden'),
               TextColumn::make('daen'),
           ]);
   }

}
