<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19.5.24
 * Time: 10:51
 */

namespace App\exports;



use App\User;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExports implements FromQuery,ShouldAutoSize,WithHeadings
{
    private $headings = [
        'Name',
        'Email',
        'Phone Number',
        'Gender',
        'Student Code',
        'Blood Group',
        'Section',
        'Class',
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
        return User::query()->select('users.name','users.email','users.phone_number','users.gender','users.student_code','users.blood_group','sections.section_number','classes.class_number','users.address')
            ->where('users.school_id', auth()->user()->school_id)
            ->where('users.role','student')
            ->whereYear('users.created_at', $this->year)
            ->join('sections','sections.id', '=', 'users.section_id')
            ->join('classes','sections.class_id', '=', 'classes.id')
            ->orderBy('users.name');
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return $this->headings;
    }
}
