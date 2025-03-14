<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use Exception;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function index() {
        $appointment = Appointment::with('barber')->get();
        return response()->json($appointment, 200, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request) {
        try {
            $request->validate([
                "name" => "required|string|max:255",
                "barber_id" => "required|exists:barbers,id",
                "appointment" => "required|date",
            ], [
                "string"=> "A(z) :attribute mezőnek szövegnek kell lennie!",
                "name.required" => "A(z) :attribute mező megadása kötelező!",
                "barber_id.required" => "A(z) :attribute mező megadása kötelező!",
                "appointment.required" => "A(z) :attribute mező megadása kötelező!",
                "exists"=> "A(z) :attribute mezőnek egy létező barberhez kell tartoznia!",
                "max" => "A(z) :attribute mező túl hosszú! Max: :max",
                "date"=> "A(z) :attribute mezőnek dátum típusúnak kell lennie!",
            ]);
        } catch (ValidationException $e) {
            return response()->json(["success" => false, "uzenet" => $e->errors()], 400, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
        }

        $appointment = Appointment::create($request->all());
        return response()->json(["success" => true, "uzenet" => $appointment->name." sikeresen rögzítve"], 200, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
    }

    public function destroy(Request $request) {
        try {
            $request->validate([
                "id" => "required|exists:barbers,id",
            ], [
                "required" => "A(z) :attribute mező megadása kötelező!",
                "exists"=> "A(z) :attribute mezőnek egy létező barberhez kell tartoznia!",
            ]);
        } catch (ValidationException $e) {
            return response()->json(["success" => false, "uzenet" => $e->errors()], 400, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
        }

        try {
            $appointment = Appointment::findOrFail($request->id);
        } catch (Exception $e) {
            return response()->json(["success" => false, "uzenet" => "Ilyen időpont nem létezik!"], 400, options: JSON_UNESCAPED_UNICODE);
        }

        if ($appointment->delete()) {
            return response()->json(["success" => true, "uzenet" => "Törölve!"], 200, options: JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(["success" => false, "uzenet" => "Nincs törölve!"], 400, options: JSON_UNESCAPED_UNICODE);
        }
    }
}
