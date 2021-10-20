<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class UsersExport implements FromCollection, WithHeadings , WithEvents 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('users.id','first_name','last_name','tel','email','cne','cin','branches_formations.name','serie','academy','establishment_1 as bac_establishment','bac_year'
                            ,'diploma','date_obtained','establishment_2 as diploma_establishment','employer_organization','poste_occupied','users.created_at','users.updated_at')
                    ->join('students', 'users.id', '=', 'students.id_user')
                    ->join('branches_formations', 'branches_formations.id_BrF', '=', 'students.id_branche_formation')
                    ->join('bac_student', 'students.id_S', '=', 'bac_student.id_student')
                    ->join('diploma_student', 'students.id_S', '=', 'diploma_student.id_student')
                    ->join('experience_student', 'students.id_S', '=', 'experience_student.id_student')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_id',3)
                    ->get();
            
        }
    public function headings(): array

    {

        return [

            'id','first_name','last_name','tel','email','cne','cin','formation name','serie','academy','Bac establishment','bac_year'
            ,'diploma','date_obtained','diploma_establishment','employer_organization','poste_occupied','created_at','updated_at',
                  
        ];

    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                $event->sheet->getDelegate()->getStyle('A1:S1')
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
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('P')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('R')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('S')->setWidth(25);

            
   
            },
        ];
    }
}
