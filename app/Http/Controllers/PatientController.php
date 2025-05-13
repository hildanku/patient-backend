<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;

class PatientController extends Controller {
    public function index() {
        $patients = Patient::with('user')->get();

        if ($patients->isEmpty()) {
            return ApiResponse::success($patients, 'No patient found');
        }

        return ApiResponse::success($patients);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'id_type' => 'required|string',
            'id_no' => 'required|string',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'address' => 'required|string',
            'medium_acquisition' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ApiResponse::validation($validator->errors());
        }

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'id_type' => $validated['id_type'],
            'id_no' => $validated['id_no'],
            'gender' => $validated['gender'],
            'dob' => $validated['dob'],
            'address' => $validated['address'],
        ]);

        $patient = Patient::create([
            'user_id' => $user->id,
            'medium_acquisition' => $validated['medium_acquisition'],
        ]);

        return ApiResponse::success($patient->load('user'), 'Patient created successfully', 201);
    }

    public function show($id) {
        $patient = Patient::with('user')->find($id);

        if (!$patient) {
            return ApiResponse::error(null, 'Patient not found', 404);
        }

        return ApiResponse::success($patient);
    }

    public function update(Request $request, $id) {
        $patient = Patient::find($id);
        if (!$patient) {
            return ApiResponse::error(null, 'Patient not found', 404);
        }
        $user = $patient->user;

        if (!$user) {
            return ApiResponse::error(null, 'User not found', 404);
        }

    $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string',
            'id_type' => 'sometimes|required|string',
            'id_no' => 'sometimes|required|string',
            'gender' => 'sometimes|required|string',
            'dob' => 'sometimes|required|date',
            'address' => 'sometimes|required|string',
            'medium_acquisition' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return ApiResponse::validation($validator->errors());
        }

        $validated = $validator->validated();

        if (isset($validated['name']) || isset($validated['id_type']) || 
            isset($validated['id_no']) || isset($validated['gender']) || 
            isset($validated['dob']) || isset($validated['address'])) {
            $user->update(array_intersect_key($validated, array_flip(['name', 'id_type', 'id_no', 'gender', 'dob', 'address'])));
        }
        
        if (isset($validated['medium_acquisition'])) {
            $patient->update(['medium_acquisition' => $validated['medium_acquisition']]);
        }

        return ApiResponse::success($patient->load('user'), 'Patient updated successfully');
    }

    public function destroy($id) {
        $patient = Patient::find($id);

        if(!$patient) {
            return ApiResponse::error(null, 'Patient not found', 404);
        }

        $patient->user->delete();
        $patient->delete();

        return ApiResponse::success(null, 'Patient deleted successfully');
    }
}
