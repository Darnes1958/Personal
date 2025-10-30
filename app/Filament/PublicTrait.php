<?php
namespace App\Filament;





use App\Models\OurCompany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Spatie\LaravelPdf\Facades\Pdf;

trait PublicTrait {


  public static function ret_spatie_header(){
      return       $headers = [
          'Content-Type' => 'application/pdf',
      ];

  }
    public static function ret_spatie($res,$blade,$arr=[])
    {
        if(!File::exists(Auth::user()->company)) {
            File::makeDirectory(Auth::user()->company);
        }
        $cus=OurCompany::where('Company',Auth::user()->company)->first();
        Pdf::view($blade,
            ['res'=>$res,'arr'=>$arr,'cus'=>$cus])
            ->save(Auth::user()->company.'/invoice-2023-04-10.pdf');
        return public_path().'/'.Auth::user()->company.'/invoice-2023-04-10.pdf';

    }
    public static function ret_spatie_land($res,$blade,$arr=[])
    {
        \Spatie\LaravelPdf\Facades\Pdf::view($blade,
            ['res'=>$res,'arr'=>$arr])
            ->landscape()
            ->save(public_path().'/invoice-2023-04-10.pdf');
        return public_path().'/invoice-2023-04-10.pdf';

    }




}
