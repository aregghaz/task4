<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use \Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = User::paginate(10);
            $previousPageUrl = $users->previousPageUrl();
            $nextPageUrl = $users->nextPageUrl();
            $count = $users->count();
            $currentPage = $users->currentPage();
            $hasMorePages = $users->hasMorePages();
            $perPage = $users->perPage();
            $status = Response::HTTP_OK;
            $response = [
                'status' => $status,
                'count' => $count,
                'previous' => $previousPageUrl,
                'currentPage' => $currentPage,
                'nextPageUrl' => $nextPageUrl,
                'hasMorePages' => $hasMorePages
            ];

            foreach ($users as $user) {
                $response['data'][] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'nid' => $user->nid,
                    'no_Birthday' => $user->no_Birthday,
                    'phone' => $user->phone,
                ];
            }
        } catch (\Exception $e) {
            $status = Response::HTTP_BAD_REQUEST;
        }

        $data = Array();
    $data['response'] = $response['data'];
    $data['status'] = $status;

    return view('user', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request)
    {

        try {
            $data = $request->all();
            $file = $request->input('picture');

            $v = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
                'no_Birthday' => 'required',
                'nid' => 'required',
                'phone' => 'required',

            ]);
            if ($v->fails()) {
                $status = Response::HTTP_BAD_REQUEST;

                $response = Array();

                $response['status'] = $status;


                if ($v->errors()->has('username')) {
                    $response['messages'][] = [
                        'messages' => last($v->errors()->get('name')),
                        'field' => 'name',
                    ];
                }
                if ($v->errors()->has('email')) {
                    $response['messages'][] = [
                        'messages' => last($v->errors()->get('email')),
                        'field' => 'email',
                    ];
                }
                if ($v->errors()->has('password')) {
                    $response['messages'][] = [
                        'messages' => last($v->errors()->get('password')),
                        'field' => 'password',
                    ];
                }
                if ($v->errors()->has('nid')) {
                    $response['messages'][] = [
                        'messages' => last($v->errors()->get('nid')),
                        'field' => 'nid',
                    ];
                }
                if ($v->errors()->has('no_Birthday')) {
                    $response['messages'][] = [
                        'messages' => last($v->errors()->get('no_Birthday')),
                        'field' => 'no_Birthday',
                    ];
                }
                if ($v->errors()->has('phone')) {
                    $response['messages'][] = [
                        'messages' => last($v->errors()->get('phone')),
                        'field' => 'phone',
                    ];
                }

                $data['response']=$response;
                $data['status']=$status;

                return view('user', $data['response']);
            }
            $user = User::create([
                'username' => $data['username'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'no_Birthday' => $data['no_Birthday'],
                'nid' => $data['nid'],
                'phone' => $data['phone'],
            ]);

            $status = Response::HTTP_OK;
            $response = [
                'status' => $status,
                'message' => 'User has been added successfully',
            ];
        } catch (\Exception $e) {
            $status = Response::HTTP_BAD_REQUEST;
            $response = [
                'status' => $status,
                'message' => $e->getMessage(),
            ];
        }


        $data['response']=$response;
        $data['status']=$status;

        return view('user', $data['response']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            $status = Response::HTTP_OK;
            $response = [
                'status' => $status,
            ];

            $response['data'][] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'no_Birthday' => $user->no_Birthday,
                'phone' => $user->phone,
                'nid' => $user->nid
            ];
        } catch (\Exception $e) {
            $status = Response::HTTP_BAD_REQUEST;
            $response = [
                'status' => $status,
                'message' => 'User Not Found'
            ];
        }
        $data['response']=$response;
        $data['status']=$status;

        return view('user', $data['response']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id)
    {
        try {
            $editUser = User::findOrFail($id);
            $status = Response::HTTP_OK;
            $response = [
                'status' => $status,
            ];

            $response['data'][] = [
                'id' => $editUser->id,
                'name' => $editUser->name,
                'password' => $editUser->password,
                'email' => $editUser->email,
                'no_Birthday' => $editUser->no_Birthday,
                'phone' => $editUser->phone,
                'nid' => $editUser->nid
            ];
        } catch (\Exception $e) {
            $status = Response::HTTP_BAD_REQUEST;
            $response = [
                'status' => $status,
                'message' => 'User Not Found'
            ];
        }
        $data['response']=$response;
        $data['status']=$status;

        return view('user', $data['response']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $updateUser = User::findOrFail($id);
            $v = Validator::make($request->all(), [
                'email' => 'required|unique:users',
                'password' => 'required',
                'name' => 'required',
                'no_Birthday' => 'no_Birthday',
                'nid' => 'nid',
                'phone' => 'phone',

            ]);
            if ($v->fails()) {
                $status = Response::HTTP_BAD_REQUEST;

                $response = Array();

                $response['status'] = $status;


                if ($v->errors()->has('username')) {
                    $response['messages'][] = [
                        'messages' => last($v->errors()->get('name')),
                        'field' => 'name',
                    ];
                }
                if ($v->errors()->has('email')) {
                    $response['messages'][] = [
                        'messages' => last($v->errors()->get('email')),
                        'field' => 'email',
                    ];
                }
                if ($v->errors()->has('password')) {
                    $response['messages'][] = [
                        'messages' => last($v->errors()->get('password')),
                        'field' => 'password',
                    ];
                }
                if ($v->errors()->has('nid')) {
                    $response['messages'][] = [
                        'messages' => last($v->errors()->get('nid')),
                        'field' => 'nid',
                    ];
                }
                if ($v->errors()->has('no_Birthday')) {
                    $response['messages'][] = [
                        'messages' => last($v->errors()->get('no_Birthday')),
                        'field' => 'no_Birthday',
                    ];
                }
                if ($v->errors()->has('phone')) {
                    $response['messages'][] = [
                        'messages' => last($v->errors()->get('phone')),
                        'field' => 'phone',
                    ];
                }

                $data['response']=$response;
                $data['status']=$status;

                return view('user', $data['response']);
            }
            $status = Response::HTTP_OK;
            $file = $request->input('picture');
            if (!empty($file)) {
                $image = base64_decode($file);
                $photopath = 'images/' . microtime() . '.jpg';
                $fp = fopen($photopath, 'wb+');
                fwrite($fp, $image);
                fclose($fp);
            } else {
                $photopath = "";
            }
            $response = [
                'status' => $status,
                'message' => 'User Has Been Updated Successfully'
            ];
            $updateUser->name = $request->input('name');
            $updateUser->position = $request->input('no_Birthday');
            $updateUser->extension = $request->input('nid');
            $updateUser->alias = $request->input('phone');
            $updateUser->save();
        } catch (\Exception $e) {
            $status = Response::HTTP_BAD_REQUEST;
            $response = [
                'status' => $status,
                'message' => 'User Not Found'
            ];
        }
        $data['response']=$response;
        $data['status']=$status;

        return view('user', $data['response']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $delUser = User::findOrFail($id);
            $delStatus = $delUser->delete();
            $status = Response::HTTP_OK;
            $response = [
                'status' => $status,
                'message' => 'User has been deleted successfully'

            ];
        } catch (\Exception $e) {
            $status = Response::HTTP_BAD_REQUEST;
            $response = [
                'status' => $status,
                'message' => 'User Not Found'
            ];
        }
        $data['response']=$response;
        $data['status']=$status;

        return view('user', $data['response']);
    }

}
