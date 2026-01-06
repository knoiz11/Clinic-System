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
        $validator = Validator::make($request->all(), [
            'administered_by' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $physicalExam = PhysicalExam::create([
            'employee_id' => $employeeId,
            'head' => $request->head,
            'conjunctiva_pale' => $request->conjunctiva_pale,
            'conjunctiva_yellowish' => $request->conjunctiva_yellowish,
            'conjunctiva_remarks' => $request->conjunctiva_remarks,
            'neck_enlarged_thyroid' => $request->neck_enlarged_thyroid,
            'neck_enlarged_lymph' => $request->neck_enlarged_lymph,
            'thorax_abnormal_cardiac' => $request->thorax_abnormal_cardiac,
            'thorax_abnormal_breathing' => $request->thorax_abnormal_breathing,
            'thorax_remarks' => $request->thorax_remarks,
            'chest' => $request->chest,
            'breast_mass' => $request->breast_mass,
            'breast_nipple_discharge' => $request->breast_nipple_discharge,
            'breast_skin_orange' => $request->breast_skin_orange,
            'breast_enlarged_nodes' => $request->breast_enlarged_nodes,
            'breast_remarks' => $request->breast_remarks,
            'abdomen_enlarged_liver' => $request->abdomen_enlarged_liver,
            'abdomen_mass' => $request->abdomen_mass,
            'abdomen_scar' => $request->abdomen_scar,
            'abdomen_tenderness' => $request->abdomen_tenderness,
            'abdomen_remarks' => $request->abdomen_remarks,
            'others' => $request->others,
            'administered_by' => $request->administered_by,
            'remarks' => $request->remarks,
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
        $validator = Validator::make($request->all(), [
            'diagnosis' => 'required|string',
            'disposition' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $doctorOrder = DoctorOrder::create([
            'employee_id' => $employeeId,
            'doctors_order' => $request->doctors_order,
            'prescription' => $request->prescription,
            'order_date' => $request->order_date,
            'diagnosis' => $request->diagnosis,
            'other_diagnosis' => $request->other_diagnosis,
            'icd11_codes' => $request->icd11_codes,
            'treatment_plan' => $request->treatment_plan,
            'disposition' => $request->disposition,
            'reasons_for_discharge' => $request->reasons_for_discharge,
            'discharge_datetime' => $request->discharge_datetime,
            'order_remarks' => $request->order_remarks,
            'schedule_next' => $request->schedule_next,
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
        $validator = Validator::make($request->all(), [
            'administered_by' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $laboratory = Laboratory::create([
            'employee_id' => $employeeId,
            'blood_chemistry' => $request->blood_chemistry,
            'blood_oxygenation' => $request->blood_oxygenation,
            'complete_blood_count' => $request->complete_blood_count,
            'immunology' => $request->immunology,
            'clinical_chemistry' => $request->clinical_chemistry,
            'fecalysis' => $request->fecalysis,
            'serology' => $request->serology,
            'sputum_microscopy' => $request->sputum_microscopy,
            'urinalysis' => $request->urinalysis,
            'hematology' => $request->hematology,
            'administered_by' => $request->administered_by,
            'remarks' => $request->remarks,
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