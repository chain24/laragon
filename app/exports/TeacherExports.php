<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19.5.24
 * Time: 11:31
 */

namespace App\exports;


use App\User;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeacherExports implements FromQuery,ShouldAutoSize,WithHeadings
{
    private $headings = [
            'Name',
            'Email',
            'Gender',
            'Teacher Code',
            'Blood Group',
            'Phone Number',
            'Address',
        ];

    private $year;

    public function __construct(int $year)
    {
        $this->year = $year;
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return User::query()
            ->select('name','email','gender','student_code','blood_group','phone_number','address')
            ->bySchool(auth()->user()->school_id)
            ->where('role','teacher')
            ->orderBy('name');
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return $this->headings;
    }
}
