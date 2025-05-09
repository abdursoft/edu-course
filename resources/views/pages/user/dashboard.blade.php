@extends('layouts.user')
@section('title','User Dashboard')


@section('content')
    <h3 class="text-2xl mb-15">Dashboard</h3>

    <h3 class="text-2xl text-slate-400 font-bold">Previous course</h3>
    {{-- course section  --}}
    <div class="flex flex-col md:flex-row gap-3 w-full">
        @foreach($courses as $course)
            <div class="p-0 md:p-3 w-full md:w-1/4 lg:w-1/5">
                <a href="{{route('user.courseDetails',$course->id)}}">
                    <div class="w-full h-[300px] overflow-hidden rounded-md bg-slate-700">
                        <img src="{{Storage::url($course->preview_image)}}" alt="{{$course->title}}" class="w-full rounded-y-md h-[270px]">
                        <p class="text-white line-clamp-1">{{$course->title}}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
