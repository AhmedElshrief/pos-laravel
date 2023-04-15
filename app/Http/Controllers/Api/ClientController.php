<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Request;
use Validator;

class ClientController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $clients = ClientResource::collection(Client::all());
        return $this->apiResponse($clients, ['Data is fetched'],200);
    }
    // end of index

    public function show($client)
    {
        $client = Client::find($client);
        if ($client) {
            return $this->apiResponse(new ClientResource($client), ['Data is fetched'], 200);
        }
        return $this->apiResponse(null, ['Client not found'], 404);
    }
    // end of show

    public function store(Request $request)
    {
        $data = Validator::make($request->all(),[
            'name' => 'required|unique:clients',
            'phone' => ['required', 'digits:11', 'unique:clients'],
            'address' => ['required', 'string', 'regex:/^[a-zA-Z]+[\w\s-]*$/'],
        ]);

        if($data->fails()) {
            return $this->apiResponse(null, [$data->errors()], 400);
        }

        $client = Client::create($request->all());
        return $this->apiResponse(new ClientResource($client), ['Client is saved'],201);
    }
    // end of store

    public function update(Request $request, $client)
    {
        $client = Client::find($client);

        if($client) {
            $data = Validator::make($request->all(),[
                'name' => 'required|unique:clients',
                'phone' => ['required', 'digits:11', 'unique:clients'],
                'address' => ['required', 'string', 'regex:/^[a-zA-Z]+[\w\s-]*$/'],
            ]);

            if($data->fails()) {
                return $this->apiResponse(null, [$data->errors()], 400);
            }

            $client->update($request->all());
            return $this->apiResponse(new ClientResource($client), ['Data is updated'], 200);
        }

        return $this->apiResponse(null, ['Client not found'], 404);
    }
    // end of update

    public function destroy($client)
    {
        $client = Client::find($client);
        if($client) {
            $client->delete();
            return $this->apiResponse(null, ['client is deleted'], 200);
        }
        return $this->apiResponse(null, ['Client is not found'], 404);
    }
    // end of delete

}// end of class


