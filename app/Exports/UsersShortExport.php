<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class UsersShortExport implements FromCollection, WithHeadings , WithEvents 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('users.id','first_name','last_name','s1_amount','s1_date','s2_amount','s2_date','s3_amount','s3_date','s4_amount','s4_date')
                    ->join('students', 'users.id', '=', 'students.id_user')
                    ->join('payment','payment.id_S','students.id_S')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_id',3)
                    ->get();
            
        }
    public function headings(): array

    {

        return [

            'id','first_name','last_name','S1_Amount','S1_Date','S2_Amount','S2_Date','S3_Amount','S3_Date','S4_Amount','S4_Date',
                  
        ];

    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                $event->sheet->getDelegate()->getStyle('A1:M1')
                                ->getFont()
                                ->setBold(true);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(25);
               

            
   
            },
        ];
    }
}
