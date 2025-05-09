<div class="w-full md:w-1/4 border-l-1 border-gray-300 p-2">
    <h3 class="text-base text-slate-700 font-bold mb-8">Total Modules ({{ count($course->modules) }})</h3>

    @foreach($course->modules as $key=>$module)
        <div class="flex flex-col bg-slate-200 my-2 p-2">
            <p class="text-base line-clamp-1 cursor-pointer" onclick="openContents('{{$key}}')">{{substr($module->title,0,50)}} ({{count($module->contents)}})</p>
            <div class="hidden module-contents content-box-{{$key}}">
                @foreach($module->contents as $key=>$content)
                    <div class="px-3 w-full">
                        <div class="bg-white">
                            <p class="text-sm line-clamp-1 my-1 rounded-md cursor-pointer p-1">{{ucfirst($content->content_type) ." ". ($key + 1)}}  </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
