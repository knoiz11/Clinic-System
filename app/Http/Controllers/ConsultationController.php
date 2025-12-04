<?php

namespace App\Http\Controllers;

use App\Models\VitalSign;
use App\Models\PhysicalExam;
use App\Models\Consultation;
use App\Models\DoctorOrder;
use App\Models\Laboratory;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends Controller
{
    // ============================================
    // SHOW CONSULTATION PAGE (Missing Method)
    // ============================================
    
    public function show($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        
        // Return the consultation view with employee data
        return view('admin.consultation.show', compact('employee'));
    }

    // ============================================
    // VITAL SIGNS
    // ============================================
    
    public function getVitalSigns($employeeId)
    {
        $vitalSigns = VitalSign::where('employee_id', $employeeId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($vitalSigns);
    }

    public function storeVitalSign(Request $request, $employeeId)
    {
        $validator = Validator::make($request->all(), [
            'heart_rate' => 'required',
            'bp_systolic' => 'required',
            'bp_diastolic' => 'required',
            'bp_assessment' => 'required',
            'administered_by' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $vitalSign = VitalSign::create([
            'employee_id' => $employeeId,
            'body_temperature' => $request->body_temperature,
            'heart_rate' => $request->heart_rate,
            'pulse_rate' => $request->pulse_rate,
            'bp_systolic' => $request->bp_systolic,
            'bp_diastolic' => $request->bp_diastolic,
            'respiratory_rate' => $request->respiratory_rate,
            'bp_assessment' => $request->bp_assessment,
            'administered_by' => $request->administered_by,
            'remarks' => $request->remarks,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vital signs saved successfully',
            'data' => $vitalSign
        ], 201);
    }

    public function updateVitalSign(Request $request, $employeeId, $id)
    {
        $vitalSign = VitalSign::where('employee_id', $employeeId)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'heart_rate' => 'required',
            'bp_systolic' => 'required',
            'bp_diastolic' => 'required',
            'bp_assessment' => 'required',
            'administered_by' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $vitalSign->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Vital signs updated successfully',
            'data' => $vitalSign
        ]);
    }

    public function deleteVitalSign($employeeId, $id)
    {
        $vitalSign = VitalSign::where('employee_id', $employeeId)->findOrFail($id);
        $vitalSign->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vital signs deleted successfully'
        ]);
    }

    // ============================================
    // PHYSICAL EXAM
    // ============================================
    
    public function getPhysicalExams($employeeId)
    {
        $physicalExams = PhysicalExam::where('employee_id', $employeeId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($physicalExams);
    }

    public function storePhysicalExam(Request $request, $employeeId)
    {
        $physicalExam = PhysicalExam::create([
            'employee_id' => $employeeId,
            'general_appearance' => $request->general_appearance,
            'head_neck' => $request->head_neck,
            'chest_lungs' => $request->chest_lungs,
            'heart_cardiovascular' => $request->heart_cardiovascular,
            'abdomen' => $request->abdomen,
            'extremities' => $request->extremities,
            'additional_notes' => $request->additional_notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Physical exam saved successfully',
            'data' => $physicalExam
        ], 201);
    }

    public function updatePhysicalExam(Request $request, $employeeId, $id)
    {
        $physicalExam = PhysicalExam::where('employee_id', $employeeId)->findOrFail($id);
        $physicalExam->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Physical exam updated successfully',
            'data' => $physicalExam
        ]);
    }

    public function deletePhysicalExam($employeeId, $id)
    {
        $physicalExam = PhysicalExam::where('employee_id', $employeeId)->findOrFail($id);
        $physicalExam->delete();

        return response()->json([
            'success' => true,
            'message' => 'Physical exam deleted successfully'
        ]);
    }

    // ============================================
    // CONSULTATION
    // ============================================
    
    public function getConsultations($employeeId)
    {
        $consultations = Consultation::where('employee_id', $employeeId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($consultations);
    }

    public function storeConsultation(Request $request, $employeeId)
    {
        $consultation = Consultation::create([
            'employee_id' => $employeeId,
            'chief_complaint' => $request->chief_complaint,
            'history_illness' => $request->history_illness,
            'diagnosis' => $request->diagnosis,
            'treatment_plan' => $request->treatment_plan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Consultation saved successfully',
            'data' => $consultation
        ], 201);
    }

    public function updateConsultation(Request $request, $employeeId, $id)
    {
        $consultation = Consultation::where('employee_id', $employeeId)->findOrFail($id);
        $consultation->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Consultation updated successfully',
            'data' => $consultation
        ]);
    }

    public function deleteConsultation($employeeId, $id)
    {
        $consultation = Consultation::where('employee_id', $employeeId)->findOrFail($id);
        $consultation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Consultation deleted successfully'
        ]);
    }

    // ============================================
    // DOCTOR'S ORDER
    // ============================================
    
    public function getDoctorOrders($employeeId)
    {
        $doctorOrders = DoctorOrder::where('employee_id', $employeeId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($doctorOrders);
    }

    public function storeDoctorOrder(Request $request, $employeeId)
    {
        $doctorOrder = DoctorOrder::create([
            'employee_id' => $employeeId,
            'medication_orders' => $request->medication_orders,
            'lab_tests_ordered' => $request->lab_tests_ordered,
            'special_instructions' => $request->special_instructions,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor\'s order saved successfully',
            'data' => $doctorOrder
        ], 201);
    }

    public function updateDoctorOrder(Request $request, $employeeId, $id)
    {
        $doctorOrder = DoctorOrder::where('employee_id', $employeeId)->findOrFail($id);
        $doctorOrder->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Doctor\'s order updated successfully',
            'data' => $doctorOrder
        ]);
    }

    public function deleteDoctorOrder($employeeId, $id)
    {
        $doctorOrder = DoctorOrder::where('employee_id', $employeeId)->findOrFail($id);
        $doctorOrder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Doctor\'s order deleted successfully'
        ]);
    }

    // ============================================
    // LABORATORY
    // ============================================
    
    public function getLaboratories($employeeId)
    {
        $laboratories = Laboratory::where('employee_id', $employeeId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($laboratories);
    }

    public function storeLaboratory(Request $request, $employeeId)
    {
        $laboratory = Laboratory::create([
            'employee_id' => $employeeId,
            'test_type' => $request->test_type,
            'test_results' => $request->test_results,
            'test_date' => $request->test_date,
            'conducted_by' => $request->conducted_by,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laboratory results saved successfully',
            'data' => $laboratory
        ], 201);
    }

    public function updateLaboratory(Request $request, $employeeId, $id)
    {
        $laboratory = Laboratory::where('employee_id', $employeeId)->findOrFail($id);
        $laboratory->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Laboratory results updated successfully',
            'data' => $laboratory
        ]);
    }

    public function deleteLaboratory($employeeId, $id)
    {
        $laboratory = Laboratory::where('employee_id', $employeeId)->findOrFail($id);
        $laboratory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Laboratory results deleted successfully'
        ]);
    }

    // ============================================
    // GET ALL RECORDS (For initial page load)
    // ============================================
    
    public function getAllRecords($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        
        return response()->json([
            'vitalSigns' => $employee->vitalSigns()->orderBy('created_at', 'desc')->get(),
            'physicalExams' => $employee->physicalExams()->orderBy('created_at', 'desc')->get(),
            'consultations' => $employee->consultations()->orderBy('created_at', 'desc')->get(),
            'doctorOrders' => $employee->doctorOrders()->orderBy('created_at', 'desc')->get(),
            'laboratories' => $employee->laboratories()->orderBy('created_at', 'desc')->get(),
        ]);
    }
}