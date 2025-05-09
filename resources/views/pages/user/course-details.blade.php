@extends('layouts.user')
@section('title',$course->title)


@section('content')

    {{-- course section  --}}
    <div class="flex flex-col md:flex-row gap-3 w-full h-full">
        @include('components.course.preview')
        @include('components.course.module')
    </div>


    <script>
        function openContents(id){
            $(".module-contents").each((index,item) => {
                $(item).addClass('hidden');
                $(`.content-box-${id}`).removeClass('hidden');
            })
        }
    </script>
@endsection
