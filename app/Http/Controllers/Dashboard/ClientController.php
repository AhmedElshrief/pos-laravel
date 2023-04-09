<?php

namespace App\Http\Controllers\Dashboard;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::when($request->search, function ($query) use ($request){
            return $query->where('name', 'like', '%'. $request->search .'%')
                ->orWhere('phone', 'like', '%'. $request->search .'%')
                ->orWhere('address', 'like', '%'. $request->search .'%');
        })->latest()->paginate(7);

        return view('dashboard.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('dashboard.clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:clients',
            'phone' => ['required', 'digits:11', 'unique:clients'],
            'address' => ['required', 'string', 'regex:/^[a-zA-Z]+[\w\s-]*$/'],
        ]);

        Client::create($data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.clients.index');
    }

    public function edit(Client $client)
    {
        return view('dashboard.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z]+[\w\s-]*$/',  // accept combination string and digits or string only
                Rule::unique('clients', 'name')->ignore($client->id, 'id'),
            ],
            'phone' => [
                'required',
                'digits:11',
                Rule::unique('clients', 'phone')->ignore($client->id, 'id'),
            ],
            'address' => [
                'required',
                'string',
                'regex:/^[a-zA-Z]+[\w\s-]*$/'
            ],
        ]);

        $client->update($data);
        session()->flash('success', __('site.update_successfully'));
        return redirect()->route('dashboard.clients.index');
    } // end of update

    public function destroy(Client $client)
    {
        $client->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.clients.index');
    }// end of delete

}// end of controller
