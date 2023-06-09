<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:read_users')->only('index');
        $this->middleware('permission:create_users')->only('create');
        $this->middleware('permission:update_users')->only('edit');
        $this->middleware('permission:delete_users')->only('destroy');
    }

    public function index(Request $request)
    {
        $users = User::whereRoleIs('admin')->where(function ($q) use ($request) {
            return $q->where('first_name', 'like', '%' . $request->search . '%')
                ->orWhere('last_name', 'like', '%' . $request->search . '%');
        })->latest()->paginate(7);

        return view('dashboard.users.index', compact('users'));

    }// end of index method


    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store()
    {
        request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'image' => 'image',
            'password' => 'required|confirmed',
            'permissions' => 'required',
        ]);

        $data = request()->except(['password', 'password_confirmation', 'permissions', 'image']);

        $data['password'] = bcrypt(request('password'));

        if (request()->image) {
            Image::make(request()->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/user_images/' . request()->image->hashName()));

            $data['image'] = request()->image->hashName();
        }


        $user = User::create($data);

        $user->attachRole('admin');
        if (request()->permissions)
            $user->syncPermissions(request()->permissions);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.users.index');
    }

    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id)
            ],
            'image' => 'image',
            'permissions' => 'required',
        ]);

        $data = request()->except(['permissions', 'image']);

        if (request()->image) {

            if ($user->image != 'default.png') {

                Storage::disk('public_uploads')->delete('/user_images/' . $user->image);

            }

            Image::make(request()->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/user_images/' . request()->image->hashName()));

            $data['image'] = request()->image->hashName();
        }

        $user->update($data);
        if (request()->permissions)
            $user->syncPermissions($request->permissions);
        else
            $user->syncPermissions([]);

        session()->flash('success', __('site.update_successfully'));
        return redirect()->route('dashboard.users.index');
    }


    public function destroy(User $user)
    {
        if ($user->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
        }

        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
    }
}
