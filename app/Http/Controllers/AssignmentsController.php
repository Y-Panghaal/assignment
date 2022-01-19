<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AssignmentsController extends Controller
{
    public function index() {
        return view('new_assignments');
    }

    public function saveAssignment(Request $request) {
        $rules = [
            'name'          => 'required|min:2|max:50',
            'email'         => 'required|email:dns,rfc|unique:assignments,email',
            'company_name'  => 'required|min:2|max:50',
            'phone_number'  => 'sometimes|nullable|numeric|digits:10',
            'country'       => 'sometimes|nullable|string',
            'details'       => 'sometimes|nullable|string'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        try {
            $id = DB::table('assignments')->insertGetId([
                'name'          => trim($request->input('name')),
                'email'         => trim($request->input('email')),
                'company_name'  => trim($request->input('company_name')),
                'phone_number'  => trim($request->input('phone_number')) === '' ? trim($request->input('phone_number')) : null,
                'country'       => trim($request->input('country')) === '' ? trim($request->input('country')) : null,
                'details'       => trim($request->input('details')) === '' ? trim($request->input('details')) : null,
            ]);
            return redirect('/add-report')->with('success', "Your report has been submitted successfully! Report id is $id.");
        } catch(\Exception $e) {
            Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->withInput()->with('error', 'Something went wrong while saving report. Please try again after sometime.');
        }
    }

    public function reports() {
        $reports = DB::table('assignments')->get();
        return view('list_assignments', compact('reports'));
    }

    public function report($id) {
        if (!((int)$id > 0)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Invalid Report Id.'
            ]);
        }
        $report = DB::table('assignments')->where('id', $id)->first();
        if ($report === null) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Report not found.'
            ]);
        }
        return response()->json([
            'status' => 'ok',
            'message' => 'Fetched report.',
            'report' => $report
        ]);
    }

    public function delete($id) {
        if (!((int)$id > 0)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Invalid Report Id.'
            ]);
        }
        $report = DB::table('assignments')->where('id', $id)->first();
        if ($report === null) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Report not found.'
            ]);
        }
        $deletes = DB::table('assignments')->where('id', $id)->delete();
        if ($deletes > 0) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Report deleted successfully!',
            ]);
        }
        return response()->json([
            'status' => 'fail',
            'message' => 'Report not deleted.'
        ]);
    }
}
