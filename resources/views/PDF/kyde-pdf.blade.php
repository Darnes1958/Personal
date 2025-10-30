@extends('PDF.PrnMasterSpatie')

@section('mainrep')

    <div class="flex mt-10 justify-center items-center text-center gap-2">
        <label class="text-xl" > قيد يومية رقم  </label>
        <label class="box-content h-6 w-20 border-0 bg-gray-300  p-1 text-lg text-center bg-gray-300">{{$res->id}}</label>
    </div>

    <br><br>

    <div>
        <label class="text-xl mt-10" >    بتاريخ : </label>
        <label class="text-sm font-bold ">{{$res->kyde_date}}</label>
    </div>

    <div >
        <label class="text-xl" >    البيان :  </label>
        <label class="text-sm font-bold ">{{$res->notes}}</label>
    </div>

    <br>

    <table    >
            <thead style="  margin-top: 8px;">
            <tr style="background:lightgray">
                <th style="width: 5%;">ت</th>
                <th style="width: 12%;">رقم الحساب</th>
                <th >البيان</th>
                <th style="width: 12%;">مدين</th>
                <th style="width: 12%;">دائن</th>
            </tr>
            </thead>
            <tbody >
            @php ;$summden=0;$sumdaen=0;

            @endphp
            @foreach($res->KydeData as $key=>$item)
                <tr class="font-size-14">
                    <td class="text-center" > {{$key=1}}</td>
                    <td>{{$item->account_id}}</td>
                    <td> {{$item->Account->name}}  </td>
                    @if($item->mden>0)
                        <td>{{number_format($item->mden,2,'.',',')}}</td>
                    @else
                     <td></td>
                    @endif
                    @if($item->daen>0)
                        <td>{{number_format($item->daen,2,'.',',')}}</td>
                    @else
                        <td></td>
                    @endif

                </tr>

                @php $summden+=$item->mden;$sumdaen+=$item->daen; @endphp
            @endforeach

            <tr class="font-size-14 " style="font-weight: bold">

                <td></td>
                <td></td>
                <td class="text-center">الإجمــــــــالي  </td>
                <td> {{number_format($summden, 2, '.', ',')}} </td>
                <td> {{number_format($sumdaen, 2, '.', ',')}} </td>

            </tr>
            <td style="border-bottom: none;border-left: none;border-right: none;"> </td>
            <td style="border-bottom: none;border-left: none;border-right: none;"> </td>
            <td style="border-bottom: none;border-left: none;border-right: none;"> </td>
            <td style="border-bottom: none;border-left: none;border-right: none;"> </td>
            <td style="border-bottom: none;border-left: none;border-right: none;"> </td>

            </tbody>
        </table>

    <br>
    <br>
    <br>

    <div class="text-left">
        <label class="ml-24 pl-10">يعتمد</label>
    </div>
    <div class="text-left">
        <label class="ml-10 pl-5">.................................</label>
    </div>



@endsection
