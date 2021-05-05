<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Models\EmergencyC;
use App\Models\EmployeeTemplate;
use App\Models\Image;
use App\Models\JobInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeTemplateController extends Controller
{


    public function index()
    {
        $dataA = auth()->user()->Employees()->get();
        $dataB = auth()->user()->jobInfos()->get();
        $dataC = auth()->user()->emergency()->get();
        $dataD = auth()->user()->Images()->get();
        return response()->json(['dataA' => $dataA, 'dataB' => $dataB, 'dataC' => $dataC, 'dataD' => $dataD]);
    }

    public function store(Request $request)
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
        $EmployeeTemplate = auth()->user()->Employees()->Create($request->all());
        return response($EmployeeTemplate, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $EmployeeTemplate = EmployeeTemplate::findOrFail($id);
        $EmployeeTemplate->update($request->all());
        return response($EmployeeTemplate, Response::HTTP_CREATED);
    }

    public function storeB(Request $request)
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
        $jobInfo = auth()->user()->jobInfos()->Create($request->all());
        return response($jobInfo, Response::HTTP_CREATED);
    }

    public function updateB(Request $request, $id)
    {
        $EmployeeTemplate = JobInfo::findOrFail($id);
        $EmployeeTemplate->update($request->all());
        return response($EmployeeTemplate, Response::HTTP_CREATED);
    }

    public function storeC(Request $request)
    {
        $validator = $request->validate([
            "Fname"    => "required",
            "Pphone"    => "required",
        ], [
            'Fname.required' => 'At least two names are required',
            'Pphone.required' => 'Primary Phone Number is required',
        ]);
        $EmployeeTemplate = auth()->user()->emergency()->Create($request->all());
        return response($EmployeeTemplate, Response::HTTP_CREATED);
    }

    public function updateC(Request $request, $id)
    {
        $EmployeeTemplate = EmergencyC::findOrFail($id);
        $EmployeeTemplate->update($request->all());
        return response($EmployeeTemplate, Response::HTTP_CREATED);
    }

    public function upload(Request $request)
    {

        $request->validate([
            'file' => 'required',
            'docName' => 'required'
        ]);

        if ($request->hasFile('file')) {
            $name = md5($request->file . microtime()) . '.' . $request->file->extension();
            $request->file->storeAs('public/images', $name);
            $upload = auth()->user()->images()->Create([
                'file' => $name,
                'docName' => $request->docName
            ]);
        }
        return response()->json(['success' => 'File uploaded successfully.']);
    }

    public function destroy($id)
    {
        $doc = Image::findOrFail($id);
        $doc->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    //file
    public function file($id)
    {
        $image = Image::find($id);
        $filename = $image->file;
        $path = storage_path('app/public/images/' . $filename);
        return response()->file($path);
    }

    public function Admin()
    {
        $data = User::when(request('filterId', '') != '', function ($query) {
            $query->where('id', request('filterId'));
        })
            ->when(request('dept', '') != '', function ($query) {
                $query->where('department', 'like', '%' . request('dept') . '%');
            })
            ->when(request('site', '') != '', function ($query) {
                $query->where('site', 'like', '%' . request('site') . '%');
            })
            ->paginate(7);
        return response()->json(['data' => $data]);
    }

    public function SelectedDept()
    {
        $dept = request('dept');
        $filter = User::where('department', 'like', '%' . request('dept') . '%')->get();
        return response()->json(['filter' => $filter]);
    }

    public function Adminview($id)
    {
        $user = User::findOrFail($id)->load('Employees', 'jobInfos', 'emergency', 'Images');
        return $user;
    }

    public function selectall()
    {
        $dept = request('dept');
        return User::where('department', 'like', '%' . $dept  . '%')
            ->when(request('site', '') != '', function ($query) {
                $query->where('site', 'like', '%' . request('site') . '%');
            })
            ->pluck('id');
    }

    public function export($employees)
    {
        $employees = explode(',', $employees);
        return (new EmployeeExport($employees))->download('Employees.xlsx');
    }
}
