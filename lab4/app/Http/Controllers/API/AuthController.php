<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * @OA\Post (
     *     path="/login",
     *     operationId="signIn",
     *     tags={"Authorization"},
     *     summary="Login for api-calls",
     *     description="Authorizes the user",
     *     @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *      ),
     *      @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *     @OA\RequestBody (
     *        required=true,
     *        description="The Token Request",
     *        @OA\JsonContent(
     *           @OA\Property(property="email",type="string",example="your@email.com"),
     *           @OA\Property(property="password",type="string",example="YOUR_PASSWORD")
     *        )
     *     ),
     *     @OA\Response (
     *        response=200,
     *        description="User signed in",
     *        @OA\JsonContent (
     *           @OA\Property(property="user", type="object", ref="#/components/schemas/User")
     *        )
     *     ),
     *     @OA\Response (
     *        response=422,
     *        description="Wrong credentials response",
     *        @OA\JsonContent (
     *           @OA\Property (property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     *)
     */
    public function signin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $authUser = Auth::user();
            $success['token'] =  $authUser->createToken('MyAuthApp')->plainTextToken;
            $success['name'] =  $authUser->name;

            return $this->sendResponse($success, 'User signed in');
        }
        else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 422);
        }
    }

    /**
     * @OA\Post (
     *     path="/register",
     *     operationId="signUp",
     *     tags={"Authorization"},
     *     summary="Register for api-calls",
     *     description="Registers the user",
     *     @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *      ),
     *     @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *      ),
     *      @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *     ),
     *     @OA\Parameter(
     *      name="confirm_password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *     ),
     *     @OA\RequestBody (
     *        required=true,
     *        description="The user registration request",
     *        @OA\JsonContent(
     *           @OA\Property(property="name",type="string",example="The Architect"),
     *           @OA\Property(property="email",type="string",example="your@email.com"),
     *           @OA\Property(property="password",type="string",example="YOUR_PASSWORD"),
     *           @OA\Property(property="confirm_password",type="string",example="YOUR_PASSWORD")
     *        )
     *     ),
     *     @OA\Response (
     *        response=200,
     *        description="User created successfully.",
     *        @OA\JsonContent (
     *           @OA\Property(property="user", type="object", ref="#/components/schemas/User")
     *        )
     *     ),
     *     @OA\Response (
     *        response=400,
     *        description="Bad request",
     *     )
     *)
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User created successfully.');
    }

    public function handleUnauthorizedRequest()
    {
        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 401);
    }
}
