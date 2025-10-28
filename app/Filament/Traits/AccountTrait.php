<?php
namespace App\Filament\Traits;





trait AccountTrait
{
 public function putRecToArr($rec,$arr)
 {
     $One= array_column($arr, 'account_id');
     $index = array_search( $rec['account_id'], $One);
     if  ($index) {
         $arr[$index]['account_id']=$rec['account_id'];
         $arr[$index]['mden']=$rec['mden'];
         $arr[$index]['daen']=$rec['daen'];
     }
     else {
         $arr[] =[$rec];
     }

    return $arr;
 }
}
