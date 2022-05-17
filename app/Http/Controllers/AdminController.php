<?php

namespace App\Http\Controllers;

use App\Models\CompanyAsset;
use App\Models\EmergencyC;
use App\Models\EmployeeTemplate;
use App\Models\Image;
use App\Models\JobInfo;
use App\Models\Training;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function index()
    {
        $data = User::when(request('search', '') != '', function ($query) {
            $query->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('email', 'like', '%' . request('search') . '%')
                ->orWhere('employee_status', request('search'))
                ->orWhere('department', 'like', '%' . request('search') . '%')
                ->orWhere('site', 'like', '%' . request('search') . '%');
        })
            ->when(request('dept', '') != '', function ($query) {
                $query->where('department', 'like', '%' . request('dept') . '%');
            })
            ->when(request('site', '') != '', function ($query) {
                $query->where('site', 'like', '%' . request('site') . '%');
            })
            ->latest()
            ->paginate(7);
        return response()->json(['data' => $data]);
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'department' => 'required',
            'site' => 'required',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'site' => $data['site'],
            'department' => $data['department'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json(['data' => $data]);
    }

    public function UserDetails($id)
    {
        $user = User::findOrFail($id)->load('Employees', 'jobInfos', 'emergency', 'Images', 'Assets', 'trainings');
        $canwrite = true;
        return response()->json(['user' => $user, 'canwrite' => $canwrite]);
    }

    public function personalDetails(Request $request, $id)
    {
        $validator = $request->validate([
            "Fname"    => "required",
            "dob"    => "required",
            "nationalId"    => "required",
        ], [
            'Fname.required' => 'At least two names are required',
            'dob.required' => 'Your date of birth is required',
            'nationalId.required' => 'ID No, is required'
        ]);
        $personaldetails = EmployeeTemplate::where('user_id', $id)->first();
        User::findOrFail($id)->update(['name' => $request->Fname]);
        if ($personaldetails) {
            $personaldetails->update($request->all());
        } else {
            EmployeeTemplate::create($request->all());
        }

        return response($personaldetails, Response::HTTP_CREATED);
    }

    public function JobDetails(Request $request, $id)
    {
        $validator = $request->validate([
            "title"    => "required",
            "supervisor"    => "required",
            "department"    => "required",
        ], [
            'title.required' => 'Title required',
            'supervisor.required' => 'Your supervisor is required',
            'department.required' => 'Department is required'
        ]);

        $Jobdetails = JobInfo::where('user_id', $id)->first();
        if ($Jobdetails) {
            $Jobdetails->update($request->all());
        } else {
            JobInfo::create($request->all());
        }

        return response($Jobdetails, Response::HTTP_CREATED);
    }

    public function  EmergencyContact(Request $request, $id)
    {
        $validator = $request->validate([
            "Fname"    => "required",
            "Pphone"    => "required",
        ], [
            'Fname.required' => 'At least two names are required',
            'Pphone.required' => 'Primary Phone Number is required',
        ]);

        $Jobdetails = EmergencyC::where('user_id', $id)->first();
        if ($Jobdetails) {
            $Jobdetails->update($request->all());
        } else {
            EmergencyC::create($request->all());
        }
    }

    public function uploadDocs(Request $request, $id)
    {

        $request->validate([
            'file' => 'required',
            'docName' => 'required'
        ]);

        if ($request->hasFile('file')) {
            $user = User::findOrFail($id);
            $name = $user->name . '-' . $request->file->getClientOriginalName();
            $request->file->storeAs('public/images', $name);
            $upload = Image::Create([
                'user_id' => $id,
                'file' => $name,
                'docName' => $request->docName
            ]);
        }
        return response()->json(['success' => 'File uploaded successfully.']);
    }

    public function destroyDoc($id)
    {
        $doc = Image::findOrFail($id);
        $doc->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function CompanyAsset(Request $request, $id)
    {
        $request->validate([
            'IssueDate' => 'required',
            'AssetName' => 'required'
        ]);

        $asset = CompanyAsset::Create([
            'user_id' => $id,
            'asset_name' => $request->AssetName,
            'date_issued' => $request->IssueDate,
            'comment' => $request->comment,
        ]);

        return response()->json([$asset]);
    }

    public function destroyAsset($id)
    {
        $doc = CompanyAsset::findOrFail($id);
        $doc->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function TrainingRecord(Request $request, $id)
    {
        $request->validate([
            'trainingName' => 'required',
            'type' => 'required',
            'trainingCompany' => 'required',
            'trainer' => 'required',
            'Certstatus' => 'required',
            'date' => 'required',
            'file' => 'required_if:Certstatus,yes'
        ]);

        $upload = Training::Create([
            'user_id' => $id,
            'training_name' => $request->trainingName,
            'type' => $request->type,
            'training_company' => $request->trainingCompany,
            'trainer' => $request->trainer,
            'cert_status' => $request->Certstatus,
            'date_completed' => $request->date
        ]);

        if ($request->hasFile('file')) {
            $user = User::findOrFail($id);
            $name = $user->name . '-' . $request->file->getClientOriginalName();
            $request->file->storeAs('public/images/Trainings', $name);
            $upload->update([
                'file' => $name,
            ]);
        }

        return response($upload, Response::HTTP_CREATED);
    }

    public function destroyTraining($id)
    {
        $doc = Training::findOrFail($id);
        $doc->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function GeneratePDF($id)
    {
        $user = User::findOrFail($id)->load('Employees', 'jobInfos', 'emergency', 'Images', 'Assets', 'trainings');
        return response()->json(['user' => $user]);
    }

    public function UserStatus(Request $request, $id)
    {

        $data = $request->validate([
            'date_inactive' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->update($data);
        if ($user->employee_status == 'active') {
            $user->update(['employee_status' => 'inactive']);
        } else {
            $user->update(['employee_status' => 'active']);
        }

        return response(Response::HTTP_CREATED);
    }
}
