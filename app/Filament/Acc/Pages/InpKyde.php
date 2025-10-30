<?php

namespace App\Filament\Acc\Pages;



use App\Filament\Traits\AccountTrait;
use App\Livewire\Traits\PublicTrait;
use App\Models\Acc;
use App\Models\Account;
use App\Models\Kyde;
use App\Models\KydeData;

use DefStudio\SearchableInput\DTO\SearchResult;
use DefStudio\SearchableInput\Forms\Components\SearchableInput;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
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
    protected ?string $heading='';
    protected static bool $shouldRegisterNavigation=false;

    public $kydedata=[];

    public $account_id,$name,$acc_level,$mden,$daen,$totMden=0,$totDaen=0;
    public $kyde_date,$notes;
    public function cleanAcc(){
        $this->mden=0;
        $this->daen=0;
        $this->name=null;
        $this->account_id=null;
        $this->dispatch('gotoitem',test: 'account_id');
    }
    public function sumArr()
    {
        $this->totMden=array_sum(array_column($this->kydedata, 'mden'));
        $this->totDaen=array_sum(array_column($this->kydedata, 'daen'));
    }
    public function chkAcc()
    {
        if ($this->account_id)
        {
            $acc=Account::find($this->account_id);
            if ($acc) {
                if ($acc->is_active) {
                    $this->name=$acc->name;
                    $this->acc_level=$acc->acc_level;
                    $this->dispatch('gotoitem', test: 'mden');
                } else Notification::make()->title('هذا الحساب غير فعال ')->danger()->send();

            } else Notification::make()->title('هذا الحساب غير محزون')->danger()->send();
        }
    }

    public function putRecToArr()
    {
        if (!$this->account_id || !Account::find($this->account_id || !Account::find($this->account_id)->is_active))
        {
           Notification::make()->title('يجب ادخال حساب صحيح')->danger()->send();
           $this->dispatch('gotoitem', test: 'account_id');
           return ;
       }
        $One= array_column($this->kydedata, 'account_id');
        $index = array_search( $this->account_id, $One);


        if  ($index!='') {
            $this->kydedata[$index]['account_id']=$this->account_id;
            $this->kydedata[$index]['mden']=$this->mden;
            $this->kydedata[$index]['daen']=$this->daen;
            $this->kydedata[$index]['name']=$this->name;
        }
        else {
            $this->kydedata[] =['account_id'=>$this->account_id,'mden'=>$this->mden,'daen'=>$this->daen,'name'=>$this->name,];
        }
      $this->sumArr();
    }
    public function chkMden()
    {
        if (!$this->mden)  {
            $this->mden=0;
            $this->dispatch('gotoitem',test: 'daen');
            return ;
        }
        $this->daen=0;
        $this->putRecToArr();
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
        $this->putRecToArr();
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
                        ->columnSpan(2)
                        ->default(now())
                        ->afterStateUpdated(fn($state)=>$this->kyde_date=$state)
                        ->required(),
                    Textarea::make('notes')
                        ->rows(3)
                        ->afterStateUpdated(fn($state)=>$this->notes=$state)
                        ->maxLength(255)
                        ->required()
                        ->columnSpan(4)
                        ->label('البيان'),
                    TextInput::make('totMden')
                        ->disabled()
                        ->columnSpan(3)
                        ->default(0)
                        ->label('اجمالي المدين'),
                    TextInput::make('totDaen')
                        ->disabled()
                        ->default(0)
                        ->columnSpan(3)
                        ->label('اجمالي الدائن'),
                    Actions::make([
                        Action::make('store')
                            ->color('success')
                            ->label('تخزين')
                            ->action(function (){
                                if (!$this->kyde_date){Notification::make()->title('يجب ادخال التاريخ')->danger()->send();return;}
                                if (!$this->notes){Notification::make()->title('يجب ادخال بيان القيد')->danger()->send();return;}
                                if ($this->totMden+$this->totDaen==0) {Notification::make()->title('لم يتم ادخال قيود')->danger()->send();return;}
                                if ($this->totMden!=$this->totDaen) {Notification::make()->title('القيد غير متزن')->danger()->send();return;}

                                $kyde=Kyde::create(['kyde_date'=>$this->kyde_date,'notes'=>$this->notes]);
                                foreach ($this->kydedata as $rec){
                                    KydeData::create(['account_id'=>$rec['account_id'],
                                        'mden'=>$rec['mden'],
                                        'daen'=>$rec['daen'],
                                        'kyde_id'=>$kyde->id,
                                    ]);
                                }
                                Notification::make()->title('تم تحزين القيد بنجاح')->success()->send();
                                $this->kydedata=[];
                                $this->kyde_date='';
                                $this->notes='';
                                $this->totMden=0;
                                $this->totDaen=0;
                            }),
                        Action::make('cancel')
                            ->color('warning')
                            ->label('إلغاء')
                    ])->columnSpanFull()
                ])->columns(6),
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
                         ->belowContent(function ($state){
                             if ($this->account_id==$state)
                                 return Schema::start([
                                     Text::make($this->name)->color('success')->weight(FontWeight::ExtraBold),
                                 ]);
                             else return null;
                         })
                         ->live()
                         ->autofocus()
                         ->columnSpan(4)
                         ->afterStateUpdated(fn($state)=>$this->account_id=$state)
                         ->extraAttributes(['wire:keydown.enter' => "chkAcc",])
                         ->required(),
                     TextInput::make('mden')->id('mden')
                         ->numeric()
                         ->columnSpan(2)
                         ->extraAttributes(['wire:keydown.enter' => "chkMden",])
                         ->afterStateUpdated(fn($state)=>$this->mden=$state)
                         ->label('مدين'),
                     TextInput::make('daen')->id('daen')
                         ->extraAttributes(['wire:keydown.enter' => "chkDaen",])
                         ->afterStateUpdated(fn($state)=>$this->daen=$state)
                         ->numeric()
                         ->columnSpan(2)
                         ->label('دائن'),
                 ])->columns(8)
            ]);
    }

   public function table(Table $table): Table
   {
       return $table

           ->records(fn(): Collection=> collect($this->kydedata))
           ->columns([
               TextColumn::make('account_id'),
               TextColumn::make('name'),
               TextColumn::make('mden'),
               TextColumn::make('daen'),
           ])
           ->recordActions([
                   Action::make('del')
                       ->iconButton()
                   ->icon(Heroicon::XMark)
                   ->color('danger')
                       ->requiresConfirmation()
                   ->action(function (array $record) {
                       unset($this->kydedata[$record['__key']]);
                       array_values($this->kydedata);
                       $this->sumArr();
                       $this->resetTable();
                   }
                   )

           ]
           );
   }

}
