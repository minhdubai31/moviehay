<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    // Show Register/Create Form
    public function create()
    {
        return view('users.register');
    }

    // Create New User
    public function store(Request $request)
    {
        // Validate request data
        $formData = $request->validate(
            [
                'user_id' => 'require',
                'username' => ['required', 'min:3', 'not_regex:/^admin$/'],
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => 'required|confirmed|min:6'
            ],
            [
                'username.required' => 'Vui lòng điền trường này.',
                'username.min' => 'Tên người dùng phải có tối thiểu :min ký tự.',
                'username.not_regex' => 'Không thể sử dụng tên người dùng này.',
                'email.required' => 'Vui lòng điền trường này.',
                'email.email' => 'Email chưa hợp lệ.',
                'email.unique' => 'Email đã được sử dụng.',
                'password.required' => 'Vui lòng điền trường này.',
                'password.confirmed' => 'Mật khẩu không trùng khớp.',
                'password.min' => 'Mật khẩu phải có tối thiểu :min ký tự.'
            ]
        );

        // Hash Password
        $formData['password'] = bcrypt($formData['password']);

        // Save avatar image to storage
        if ($request->hasFile('avatar')) {
            $image_path = '/images/' . $request->file('avatar')->getClientOriginalName() . time() . 'thumb.jpg';
            Image::make($request->file('avatar'))->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/' . $image_path));

            $formData['avatar'] = $image_path;
        }

        // Create User
        $user = User::create($formData);

        // Login
        auth()->login($user);

        return redirect(session('previous_url', '/'))->with('message', 'Đã tạo tài khoản và đăng nhập thành công');
    }

    // Logout User
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back()->with('message', 'Bạn đã đăng xuất');
    }

    // Show Login Form
    public function login()
    {
        if (!stristr(url()->previous(), "/users")) {
            session(['previous_url' => url()->previous()]);
        }
        return view('users.login');
    }

    // Authenticate User
    public function authenticate(Request $request)
    {
        $formData = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => 'required'
            ],
            [
                'email.required' => 'Vui lòng điền trường này.',
                'email.email' => 'Email chưa hợp lệ.',
                'password.required' => 'Vui lòng điền trường này.',
            ]
        );

        if (auth()->attempt($formData)) {
            $request->session()->regenerate();

            if (auth()->user()->username == 'admin') return redirect('/admin')->with('message', 'Đã đăng nhập tài khoản quản trị viên');
            return redirect(session('previous_url', '/'))->with('message', 'Đăng nhập thành công');
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu chưa chính xác'])->onlyInput('email');
    }

    // Drop user
    public function drop(User $user)
    {
        if (auth()->user()->username != 'admin' and auth()->user()->user_id != $user->user_id) {
            return redirect('/');
        }
        $user->delete();
        return back()->with('message', 'Người dùng đã được xóa');
    }

    // User management page
    public function manage(User $user)
    {
        if (auth()->user()->username != 'admin' and auth()->user()->user_id != $user->user_id) {
            return redirect('/');
        }
        return view('users.manage', [
            'this_user' => $user
        ]);
    }

    // User edit
    public function edit(User $user)
    {
        if (auth()->user()->username != 'admin' and auth()->user()->user_id != $user->user_id) {
            return redirect('/');
        }
        return view('users.edit', [
            'this_user' => $user
        ]);
    }

    // Update user
    public function update(Request $request, User $user)
    {
        // Check if logged in user is owner of the account
        if (auth()->user()->username != 'admin' and auth()->user()->user_id != $user->user_id) {
            return redirect('/');
        }

        $rules = [
            'username' => ['required', 'min:3', 'not_regex:/^admin$/'],
        ];

        $errormsg = [
            'username.required' => 'Vui lòng điền trường này.',
            'username.min' => 'Tên người dùng phải có tối thiểu :min ký tự.',
            'username.not_regex' => 'Không thể sử dụng tên người dùng này.'
        ];

        if ($request['email'] != $user->email) {
            $rules = array_merge($rules, [
                'email' => ['required', 'email', Rule::unique('users', 'email')]
            ]);

            $errormsg = array_merge($errormsg, [
                'email.required' => 'Vui lòng điền trường này.',
                'email.email' => 'Email chưa hợp lệ.',
                'email.unique' => 'Email đã được sử dụng.'
            ]);
        }

        // If user choose change password
        if ($request->has('change-pass')) {

            // Check if inputted old password correct 
            if (Hash::check($request['old_password'], $user->password)) {
                $rules = array_merge($rules, [
                    'password' => 'required|confirmed|min:6'
                ]);

                $errormsg = array_merge($errormsg, [
                    'password.required' => 'Vui lòng điền trường này.',
                    'password.confirmed' => 'Mật khẩu không trùng khớp.',
                    'password.min' => 'Mật khẩu phải có tối thiểu :min ký tự.'
                ]);


                $validator = Validator::make($request->all(), $rules, $errormsg);
                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }

                $formData = $validator->validated();
                // Hash password
                $formData['password'] = bcrypt($formData['password']);
            } else {
                // Old password incorrect
                $validator = Validator::make($request->all(), $rules, $errormsg);
                $validator->after(
                    function ($validator) {
                        $validator->errors()->add(
                            'old_password',
                            'Mật khẩu cũ không chính xác.'
                        );
                    }
                );
                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }
            }
        } else {
            // Check other rules if password is correct
            $validator = Validator::make($request->all(), $rules, $errormsg);
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $formData = $validator->validated();
        }

        // Update new avatar
        if ($request->hasFile('avatar')) {
            $image_path = '/images/' . $request->file('avatar')->getClientOriginalName() . time() . 'thumb.jpg';
            Image::make($request->file('avatar'))->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/' . $image_path));

            $formData['avatar'] = $image_path;
        }

        // Delete old avatar file
        if ($user->avatar != null)
            Storage::disk('public')->delete($user->avatar);

        $user->update($formData);
        return redirect('/users/manage/' . $user->user_id)->with('message', 'Cập nhật tài khoản thành công');
    }

    // User history
    public function history(User $user)
    {
        if (auth()->user()->username != 'admin' and auth()->user()->user_id != $user->user_id) {
            return redirect('/');
        }
        return view('users.history', [
            'user' => $user
        ]);
    }
}
