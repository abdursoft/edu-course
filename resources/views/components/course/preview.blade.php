<div class="w-full md:w-3/4">
    <img src="{{Storage::url($course->preview_image)}}" alt="{{$course->title}}" class="w-full h-[460px]">
    <div class="flex items-center justify-between">
        <h3 class="text-xl md:text-2xl text-slate-700 font-bold">{{ $course->title }}</h3>
        <h3 class="text-xl md:text-2xl text-slate-700 font-bold">${{ $course->price }}</h3>
    </div>
    <h3 class="text-base md:text-xl text-slate-700 font-bold mt-3">Course Duration: {{ $course->duration }}</h3>
    <h3 class="text-base md:text-xl text-slate-700 font-bold mt-3">Course Details:</h3>
    <article>{{ $course->description }}</article>
</div>
