<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AreaDisabled;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function read()
    {
        $list = [];
        $areas = Area::where('allowed', true)->get();
        $days = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];

        foreach ($areas as $area) {
            $start = date('H:i', strtotime($area->start_time));
            $end = date('H:i', strtotime($area->end_time));
            $areaDays = json_decode($area->days);

            $text = [];
            foreach ($areaDays as $day) {
                $text[] = $days[$day] . " - $start as $end";
            }

            $list[] = [
                'id' => $area->id,
                'title' => $area->title,
                'cover' => asset("storage/photos/$area->cover"),
                'days' => $text,
            ];
        }

        return $list;
    }

    public function create(Request $request)
    {
        $data = Validator::make($request->all(), [
            'unit_id' => 'required|exists:units,id',
            'area_id' => 'required|exists:areas,id',
            'date' => 'required|date_format:Y-m-d\TH:i',
        ]);

        if ($data->fails()) {
            return ['error' => $data->errors()];
        }

        $data = $data->validated();
        $area = Area::find($data['area_id']);

        $areaDays = json_decode($area->days);
        $day = date('w', strtotime($data['date']));
        if (!in_array($day, $areaDays)) {
            return ['error' => 'Dia indisponivel'];
        }

        $start = strtotime($area->start_time);
        $end = strtotime($area->end_time);
        $end = strtotime('-1 hours', $end);
        $hour = date('H:i', strtotime($data['date']));
        $hour = strtotime($hour);
        if ($hour < $start || $hour > $end) {
            return ['error' => 'Horario indisponivel'];
        }

        $date = date('Y-m-d', strtotime($data['date']));
        if (AreaDisabled::where('area_id', $data['area_id'])->firstWhere('day', $date)) {
            return ['error' => 'Este dia foi desabilitado'];
        }

        $dateTime = date('Y-m-d H:i:00', strtotime($data['date']));
        if (Reservation::where('area_id', $data['area_id'])->firstWhere('date', $dateTime)) {
            return ['error' => 'Data ou horario já está agendado'];
        }

        Reservation::create($data);

        return [
            'error' => '',
        ];
    }

    public function getDisabled($id)
    {
        $area = Area::find($id);
        if (empty($area)) return redirect()->route('login');
        $list = [];

        $disabled = AreaDisabled::where('area_id', $id)->get();
        foreach ($disabled as $item) {
            $list[] = $item->day;
        }

        $days = json_decode($area->days);

        for ($i = 0; $i < 90; $i++) {
            $index = strtotime("+$i days");
            $date = date('w', $index);
            if (!in_array($date, $days)) {
                $list[] = date('Y-m-d', $index);
            }
        }

        return [
            'error' => '',
            'list' => $list,
        ];
    }

    public function delete($id)
    {
        $reservation = Reservation::find($id);
        if (!empty($reservation)) {
            $authId = Auth::id();
            $owner = $reservation->unit->user->id;

            if ($authId != $owner) {
                return redirect()->route('login');
            }
        } else {
            return ['error' => 'Reserva não encontrada'];
        }

        $reservation->delete();

        return [
            'error' => '',
        ];
    }
}
