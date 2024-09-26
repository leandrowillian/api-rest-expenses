<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserController
{

    /**
     * @param StoreUpdateRequest $request
     */
    public function __construct(
        protected UserService $service
    ) {}
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->service->getAll();
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateRequest $request)
    {
        // Set user data sent from request (can be a DTO in the future)
        $userData = $request->only(['name', 'email', 'password']);

        $userCreated = $this->service->create($userData);
        return new UserResource($userCreated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->service->getById($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateRequest $request, string $id)
    {
        $userToBeUpdated = $this->service->getById($id);
        // Check if user has authorization to update the id passed
        if($request->user()->cannot('update', $userToBeUpdated)) {
            return response()->json(['message'=> 'You do not have permission to update this user'], 403);
        }

        // Set user data sent from request (can be a DTO in the future)
        $userData = array_merge(
            ['id' => $id], 
            $request->only('name','email','password')
        );
        $userUpdated = $this->service->update($userData);
        return new UserResource($userUpdated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userToBeDeleted = $this->service->getById($id);
        // Check if user has authorization to update the id passed
        if(Auth::user()->cannot('delete', $userToBeDeleted)) {
            return response()->json(['message'=> 'You do not have permission to delete this user'], 403);
        }

        if ($this->service->delete($id)) return response()->json([], 204);

        return response()->json([],500);
    }
}
