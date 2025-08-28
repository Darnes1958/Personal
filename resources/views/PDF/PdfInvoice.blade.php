@extends('PDF.PrnMaster3')

@section('mainrep')


    <img src=" {{ storage_path('app/public/bosh1.png') }}"  style="width: 900px; " />


    <table style="border-collapse: collapse;
                border: none;" width="100%"   align="right" >
        <thead >
        <tr >
            <th style="width: 20%;"></th>
            <th style="width: 50%;"></th>
            <th style="width: 15%;"></th>
            <th style="width: 15%;"></th>
        </tr>
        </thead>
        <tbody >
            <tr >
                <td style="font-weight: bold;"> إسم الزبون :&nbsp; </td>
                <td > {{$record->name}}  </td>
                <td style="font-weight: bold;">     التاريخ     </td>
                <td style="font-size: 18px">  {{$record->invoice_date}}   </td>
            </tr>
            <tr style="">
                <td style="font-weight: bold;"> المصرف :&nbsp; </td>
                <td > {{$record->Bank->name}}  </td>
            </tr>
            <tr style="">
                <td style="font-weight: bold;"> رقم الفاتورة :&nbsp; </td>
                <td style="font-size: 18px"> {{$record->invoice_number}}  </td>
            </tr>
        </tbody>
    </table>

    <table style="margin-top: 30px; border: 3px solid #1c1c1a ;" width="100% "   align="right" >
        <thead >
        <tr class="bg-gray-300 font-bold " style="border: 3px solid #1c1c1a">
            <th style="width: 35%;border: 3px solid #1c1c1a">المواصفات</th>
            <th style="width: 15%;border: 3px solid #1c1c1a">رقم المحرك</th>
            <th style="width: 10%;border: 3px solid #1c1c1a">اللون</th>
            <th style="width: 10%;border: 3px solid #1c1c1a">الموديل</th>
            <th style="width: 15%;border: 3px solid #1c1c1a">رقم الهيكل</th>
            <th style="width: 15%;border: 3px solid #1c1c1a">السعر</th>
        </tr>
        </thead>
        <tbody >
        <tr  >
            <td style="border: 3px solid #1c1c1a;font-size: 16px;">{{$record->specifications}}&nbsp; </td>
            <td style="border: 3px solid #1c1c1a;font-size: 14px;text-align: center"> {{$record->engine_number}}  </td>
            <td style="border: 3px solid #1c1c1a;font-size: 16px;text-align: center">{{$record->color}}     </td>
            <td style="border: 3px solid #1c1c1a;font-size: 16px;text-align: center">  {{$record->model}}   </td>
            <td style="border: 3px solid #1c1c1a;font-size: 14px;text-align: center">  {{$record->chassis_number}}   </td>
            <td style="border: 3px solid #1c1c1a;font-size: 16px;text-align: center">  {{$record->amount}}   </td>
        </tr>
        </tbody>
    </table>
    <table style="margin-top: 50px; border-collapse: collapse;
                border: none;" width="100%"   align="right" >
        <thead >
        <tr >

            <th style="width: 70%;"></th>
            <th style="width: 30%;"></th>
        </tr>
        </thead>
        <tbody >

        <tr >
            <td> </td>
            <td style="font-size: 18px"> مفوض الشركة .....................  </td>
        </tr>
        </tbody>
    </table>



@endsection







