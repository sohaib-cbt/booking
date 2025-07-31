<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class ReportsExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Booking::query();

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['therapist'])) {
            $query->where('therapist_id', $this->filters['therapist']);
        }
        if (!empty($this->filters['client_name'])) {
            $query->where('client_name', 'like', '%' . $this->filters['client_name'] . '%');
        }
        if (!empty($this->filters['location'])) {
            $query->where('location', 'like', '%' . $this->filters['location'] . '%');
        }
        if (!empty($this->filters['archive'])) {
            $query->where('status', $this->filters['archive']);
        }
        if (!empty($this->filters['type'])) {
            $query->where('booking_form_type', $this->filters['type']);
        }
        if (!empty($this->filters['school_id'])) {
            $query->where('school_id', $this->filters['school_id']);
        }

        // Select ALL columns
        $bookings = $query->get();

        // Format dates and decode JSON where needed
        return $bookings->map(function ($booking) {
            // Format function for team members
            $formatTeam = function ($json, $includeRole = true) {
                if (empty($json) || !is_string($json)) return '';
                $team = json_decode($json, true);
                if (!is_array($team)) return '';

                return collect($team)->map(function ($t) use ($includeRole) {
                    $parts = [];
                    if (!empty($t['name'])) $parts[] = "Name, {$t['name']}";
                    if ($includeRole && !empty($t['role'])) $parts[] = "Role, {$t['role']}";
                    if (!empty($t['phone'])) $parts[] = "Phone, {$t['phone']}";
                    return '(' . implode(' --- ', $parts) . ')';
                })->implode(', ');
            };

            return [
                'id' => $booking->id,
                'booking_form_type' => $booking->booking_form_type
                    ? ucwords(str_replace('_', ' ', $booking->booking_form_type))
                    : $booking->booking_form_type,

                'entry_type' => $booking->entry_type
                    ? ucwords(str_replace('_', ' ', $booking->entry_type))
                    : $booking->entry_type,
                'school_id' => ucwords($booking->school?->school_name),
                'private_room_area' => $booking->private_room_area,
                'specific_time' => $booking->specific_time,
                'other_app_scheduling_info' => is_string($booking->other_app_scheduling_info) ? implode(', ', json_decode($booking->other_app_scheduling_info, true) ?? []) : $booking->other_app_scheduling_info,
                'days_off_week' => is_string($booking->days_off_week) ? implode(', ', json_decode($booking->days_off_week, true) ?? []) : $booking->days_off_week,
                'child_attend' => $booking->child_attend,
                'schedule_by' => $booking->schedule_by,
                'internal_team' => $formatTeam($booking->internal_team, true), // With role
                'external_team' => $formatTeam($booking->external_team, false), // No role
                'length_of_metting' => $booking->length_of_metting,
                'follow_up_meeting' => is_string($booking->follow_up_meeting) ? implode(', ', array_map(fn($item) => ucwords(str_replace('_', ' ', $item)), json_decode($booking->follow_up_meeting, true) ?? [])) : $booking->follow_up_meeting,
                'client_name' => ucwords($booking->client_name),
                'language' => ucwords($booking->language),
                'priority' => ucwords($booking->priority),
                'reminder_call' => $booking->reminder_call,
                'alayacare_type' => $booking->alayacare_type,
                'ax/reax' => $booking->{'ax/reax'},
                'alayacare_service_code' => $booking->alayacare_service_code,
                'room_setup' => $booking->room_setup,
                'units_from' => $booking->units_from,
                'units_to' => $booking->units_to,
                'trvel_time' => $booking->trvel_time,
                'area_of_town' => $booking->area_of_town,
                'rooms' => is_string($booking->rooms) ? implode(', ', json_decode($booking->rooms, true) ?? []) : $booking->rooms,
                'location' => ucwords($booking->location),
                'therapist_id' => ucwords($booking->therapist?->name),
                'inform_to' => is_string($booking->inform_to) ? implode(', ', array_map(fn($item) => ucwords(str_replace('_', ' ', $item)), json_decode($booking->inform_to, true) ?? [])) : $booking->inform_to,
                'report_time' => $booking->report_time,
                'reoccur_app_info' => ucwords($booking->reoccur_app_info),
                'comments' => ucfirst($booking->comments),
                'status' => $booking->status,
                'created_at' => Carbon::parse($booking->created_at)->format('d-M-Y h:i A'),
                'updated_at' => Carbon::parse($booking->updated_at)->format('d-M-Y h:i A'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Booking ID',
            'Booking Type',
            'Entry Type',
            'School',
            'Private Room Area',
            'Specific Time',
            'Other App Scheduling Info',
            'Days Off Week',
            'Child Attend',
            'Schedule By',
            'Internal Team',
            'External Team',
            'Length Of Meeting',
            'Follow Up Meeting',
            'Client Name',
            'Language',
            'Priority',
            'Reminder Call',
            'Alayacare Type',
            'Ax/Reax',
            'Alayacare Service Code',
            'Room Setup',
            'Units From',
            'Units To',
            'Travel Time',
            'Area Of Town',
            'Rooms',
            'Location',
            'Therapist ID',
            'Inform To',
            'Report Time',
            'Reoccur App Info',
            'Comments',
            'Status',
            'Created At',
            'Updated At'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F81BD']],
            ],
        ];
    }

    // Conditional formatting for status column
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $rowCount = $sheet->getHighestRow();

                for ($row = 2; $row <= $rowCount; $row++) {
                    $status = $sheet->getCell("AH{$row}")->getValue();

                    if (strtolower($status) === 'active') {
                        $sheet->getStyle("AH{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('92D050'); // Green
                        $sheet->getStyle("AH{$row}")->getFont()->getColor()->setRGB(Color::COLOR_WHITE);
                    } else {
                        $sheet->getStyle("AH{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FF0000'); // Red
                        $sheet->getStyle("AH{$row}")->getFont()->getColor()->setRGB(Color::COLOR_WHITE);
                    }
                }
            }
        ];
    }
}
