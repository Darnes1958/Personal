<?php
namespace App\Filament;





trait PublicTrait {


  public static function ret_spatie_header(){
      return       $headers = [
          'Content-Type' => 'application/pdf',
      ];

  }
  public static function ret_spatie($res,$blade,$arr=[])
  {
      \Spatie\LaravelPdf\Facades\Pdf::view($blade,
          ['res'=>$res,'arr'=>$arr])
          ->save(public_path().'/invoice-2023-04-10.pdf');
      return public_path().'/invoice-2023-04-10.pdf';

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
