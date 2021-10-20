<?php

namespace App\Imports;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Formation;
use App\Models\Branches_Formation;
use App\Models\Bac_Student;
use App\Models\Diploma_Student;
use App\Models\Experience_Student;
use App\Models\Payment;

class UsersImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        //

        foreach ($rows as $row)
        {
            if($rows[0] == $row ){
                continue;
            }

            $user = User::create([
                'first_name'          => $row[1],
                'last_name'           => $row[2],
                'tel'                 => $row[3],
                'email'               => $row[4],
                'password'            => Hash::make('password'),
                'token'               => str_random(64),
                'activated'           => 1,
                
                
            ]);

            $student=Student::create([
                'id_user' => $user->id,
                'CNE'=> $row[5],
                'CIN'=> $row[6],
                'id_branche_formation' => $row[7],
                
            ]);

            $user->attachRole(3);
            
            
            //bac
            Bac_Student::create([
                
                'id_student' => $student->id_S,
                'serie'         => $row[8],
                'academy'       => $row[9],
                'establishment_1' => $row[10],
                'bac_year'              => $row[11],

                
            ]);
            

            Diploma_Student::create([
                
                'id_student' => $student->id_S,
                'diploma'         => $row[12],
                'date_obtained'       => $row[13],
                'establishment_2' => $row[14],
                
            ]);
            
            Experience_Student::create([
                
                'id_student' => $student->id_S,
                'employer_organization'=> $row[15],
                'poste_occupied'       => $row[16],
                
            ]);
            Payment::create([
                'id_S' => $student->id_S,
                's1_amount' => $row[16],
                's1_date'   => $row[17],
                's2_amount' => $row[18],
                's2_date'   => $row[19],
                's3_amount' => $row[20],
                's3_date'   => $row[21],
                's4_amount' => $row[22],
                's4_date'   => $row[23],

            ]);

        }
    }
}
