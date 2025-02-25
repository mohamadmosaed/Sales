<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {

        $data = User::orderBy('id','DESC')->paginate(5);

        return view('users.index',compact('data'))

            ->with('i', ($request->input('page', 1) - 1) * 5);

    }




    public function create()

    {

        $roles = Role::pluck('name','name')->all();

        return view('users.create',compact('roles'));

    }



    public function store(Request $request)

    {


        $this->validate($request, [

            'name' => 'required',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|same:confirm-password',

            'roles_name' => 'required'

        ]);



        $input = $request->all();

        $input['password'] = Hash::make($input['password']);



        $user = User::create($input);

        $user->assignRole($request->input('roles_name'));



        return redirect()->route('users.index')

                        ->with('success','User created successfully');

    }




    public function show($id)

    {

        $user = User::find($id);

        return view('users.show',compact('user'));

    }





    public function edit($id)

    {

        $user = User::find($id);

        $roles = Role::pluck('name','name')->all();

        $userRole = $user->roles->pluck('name','name')->all();



        return view('users.edit',compact('user','roles','userRole'));

    }




    public function update(Request $request, $id)
    {
        // التحقق من وجود المستخدم
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'المستخدم غير موجود');
        }

        // التحقق من صحة البيانات
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles_name' => 'required'
        ]);

        $input = $request->all();

        // تحديث كلمة المرور
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        // تحديث المستخدم
        $user->update($input);

        // تحديث الأدوار
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles_name'));

        return redirect()->route('users.index')->with('success', 'المستخدم تم تحديثه بنجاح');
    }



    public function destroy($id)

    {

        User::find($id)->delete();

        return redirect()->route('users.index')

                        ->with('success','User deleted successfully');

    }



    public function checkSubscription($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $subscription = $user->subscription; // Assuming relationship is defined

        $currentDate = Carbon::now();

        if ($currentDate->between($subscription->start_date, $subscription->end_date)) {
            return response()->json(['message' => 'You are subscribed.']);
        } else {
            return response()->json(['message' => 'You are not subscribed.'], 403);
        }
    }

}

