<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;

class PatientController extends Controller {
    public function index() {
        return ApiResponse::success(Patient::with('user')->get());
    }

    public function store(Request $request) {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string',
            'id_type' => 'required|string',
            'id_no' => 'required|string',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'address' => 'required|string',
            'medium_acquisition' => 'required|string',
        ])->validate();

        $user = User::create([
            'name' => $request->name,
            'id_type' => $request->id_type,
            'id_no' => $request->id_no,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'address' => $request->address,
            'email' => uniqid().'@example.com',
            'password' => bcrypt('password')
        ]);

        $patient = Patient::create([
            'user_id' => $user->id,
            'medium_acquisition' => $request->medium_acquisition
        ]);

        return ApiResponse::success($patient->load('user'), 'Patient created successfully', 201);
    }

    public function show($id) {
        return ApiResponse::success(Patient::with('user')->findOrFail($id));
    }

    public function update(Request $request, $id) {
        $patient = Patient::findOrFail($id);
        $user = $patient->user;

        $user->update($request->only(['name', 'id_type', 'id_no', 'gender', 'dob', 'address']));
        $patient->update($request->only(['medium_acquisition']));

        return ApiResponse::success($patient->load('user'), 'Patient updated successfully');
    }

    public function destroy($id) {
        $patient = Patient::findOrFail($id);
        $patient->user->delete();
        $patient->delete();

        return ApiResponse::success(null, ['message' => 'Deleted successfully']);
    }
}
