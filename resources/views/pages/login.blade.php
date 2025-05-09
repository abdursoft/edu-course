@extends('layouts.home')

@section('title', 'Login | Registration')


@section('content')
    <div class="w-screen relative overflow-hidden min-h-screen flex items-center justify-center p-2">
        <div
            class="w-full md:w-2/6 lg:w-2/8 flex flex-col-reverse md:flex-row items-center justify-between rounded-[11px] p-4 shadow-2xl bg-slate-900 text-white">
            <div class="w-full px-3 md:px-7 py-20 relative">
                <form action="" class="userLogin"  onsubmit="userLogin();return false;">
                    <div class="card">
                        <div class="text-3xl mb-2 font-fold"></div>
                        <div class="p-1 w-full"><label class="my-2">Username</label><input type="text"
                                class="p-inputtext p-component w-full rounded-[12px] p-3 border border-black-500" name="username" placeholder="Username"></div>
                        <div class="p-1 w-full"><label class="my-2">Password</label><input type="password"
                                class="p-inputtext p-component w-full rounded-[12px] p-3 border border-black-500" name="password" placeholder="Password" ></div>
                        <button
                            class="btn btn-block text-center rounded-[20px] min-h-[55px] px-10 text-white mt-3 py-2 w-full flex items-center justify-center gap-5 bg-cyan-600 hover:bg-red-400 duration-[500ms] cursor-pointer"
                            type="submit">Signin</button>
                        <p class="mt-[20px] text-center text-md">Don't have an account? <a href="{{route('page.register')}}"
                                class="font-fold text-cyan-800">Sign Up</a></p>
                    </div>
                </form>
                <div class="flex items-center justify-center p-3"><div class="errorMsg"></div></div>
            </div>
        </div>
    </div>
@endsection
