<?php

namespace App\Observers;

use App\Models\Attendance;
use App\Models\Meeting;
use App\Models\Student;

class MeetingObserver
{
    public function created(Meeting $meeting)
    {
        $users = Student::get()->pluck('id')->toArray();
        $data = collect([]);
        foreach ($users as $user) {
            $data[] = [
                'user_id' => $user,
                'meeting_id' => $meeting->id,
                'date' => $meeting->date,
                'attend' => false,
            ];
        }
        Attendance::insert($data->toArray());

    }
}
