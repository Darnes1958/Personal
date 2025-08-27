@extends('PDF.PrnMaster3')

@section('mainrep')

    <table style="border-collapse: collapse;
                border: none;" width="100%"   align="right" >
        <thead >
        <tr >
            <th style="width: 20%;"></th>
            <th style="width: 40%;"></th>
            <th style="width: 20%;"></th>
            <th style="width: 20%;"></th>
        </tr>
        </thead>
        <tbody >


            <tr style="">
                <td style="font-weight: bold"> إسم الزبون :&nbsp; </td>
                <td > {{$record->name}}  </td>

                 <td style="font-weight: bold">     التاريخ     </td>

                <td>  {{$record->invoice_date}}   </td>

            </tr>



        </tbody>
    </table>


@endsection







