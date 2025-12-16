<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Meeting;
use App\Models\Student;
use App\Models\Teacher;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $lastMeeting = Meeting::whereRaw("CONCAT(date, ' ', time) <= ?", [now()])
            ->orderByRaw("CONCAT(date, ' ', time) DESC")
            ->first();
        $secondMeeting = Meeting::whereRaw("CONCAT(date, ' ', time) <= ?", [now()])
            ->orderByRaw("CONCAT(date, ' ', time) DESC")
            ->skip(1)
            ->first();

        $lastCount = Attendance::where('meeting_id', $lastMeeting?->id)->where('attend', 1)->count();
        $secondCount = Attendance::where('meeting_id', $secondMeeting?->id)->where('attend', 1)->count();

        $description = null;
        $description_icon = null;
        $chart = [];
        $color = null;

        if ($lastMeeting && $secondMeeting) {
            $description = $lastCount >= $secondCount
                ? __('Increase in Attendance')
                : __('Decrease in Attendance');
            $description_icon = $lastCount >= $secondCount
            ? 'heroicon-m-arrow-trending-up'
            : 'heroicon-m-arrow-trending-down';
            $chart = $lastCount >= $secondCount
                ? [7, 2, 10, 3, 15, 4, 17]
                :[16, 4 , 11 , 3 , 10 , 2 , 7];

            $color = $lastCount >= $secondCount
                ? 'success'
                : 'danger';
        }


        return [
            Stat::make(__('Total Students') , Student::count()),
            Stat::make(__('Total Meetings') , Meeting::count()),
            Stat::make(__('Total Teachers') , Teacher::count()),

            Stat::make(__('Last Attendance') , Attendance::where('meeting_id' ,$lastMeeting?->id)->where('attend' , 1)->count())
                ->description($description)
                ->descriptionIcon($description_icon)
                ->chart($chart)
                ->color($color),


        ];
    }
}
