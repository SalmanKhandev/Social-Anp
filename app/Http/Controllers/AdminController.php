<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\User;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public $adminRepository;
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }
    public function index()
    {
        $admins = $this->adminRepository->all();
        return view("admins.index", compact('admins'));
    }

    public function createAdmin(AdminRequest $request)
    {
        $this->adminRepository->createAdmin($request);
        return response()->json(['success' => true, 'message' => 'Admin created successfully']);
    }

    public function updateAdmin(AdminRequest $request)
    {
        $this->adminRepository->updateAdmin($request);
        return response()->json(['success' => true, 'message' => 'Admin Updated successfully']);
    }

    public function deleteAdmin(Request $request)
    {
        $deleteAdmin = $this->adminRepository->deleteAdmin($request);
        return response()->json(['success' => true, 'message' => 'Admin deleted successfully']);
    }
}
