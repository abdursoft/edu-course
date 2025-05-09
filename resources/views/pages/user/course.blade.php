@extends('layouts.user')
@section('title', 'Create course')


@section('content')
    <form id="courseForm" enctype="multipart/form-data">
        <h2 class="text-2xl mb-15">Create Course</h2>
        @csrf
        <div class="flex flex-col w-full">
            <label>Course Name:</label>
            <input class='bg-slate-200 p-2 rounded-md px-2' type="text" name="title" placeholder="Title" required>
        </div>

        <div class="flex flex-col w-full">
            <label>Price:</label>
            <input class='bg-slate-200 p-2 rounded-md px-2' type="number" name="price" placeholder="250" required>
        </div>

        <div class="flex flex-col w-full">
            <label>Description:</label>
            <textarea class='bg-slate-200 p-2 rounded-md px-2' type="text" name="description" placeholder="course description" required></textarea>
        </div>

        <div class="flex flex-col w-full">
            <label>Preview Image:</label>
            <input class='bg-slate-200 p-2 rounded-md px-2' type="file" accept="image/*" name="preview_image" required>
        </div>

        <div class="flex flex-col w-full">
            <label>Course Preview:</label>
            <input class='bg-slate-200 p-2 rounded-md px-2' type="file" accept="video/mp4" name="preview" required>
        </div>

        <div class="flex flex-col w-full">
            <label>Category</label>
            <select class="bg-slate-200 p-2 rounded-md px-2" name="category_id" required>
                @foreach($category as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div id="modules"></div>

        <div class="flex items-center justify-between w-full py-2">
            <button type="button" class="btn bg-blue-600 text-white rounded-md cursor-pointer p-2" onClick="addModule()">Add Module</button>
            <button type="submit" class="btn bg-green-600 text-white rounded-md cursor-pointer p-2" >Submit Course</button>
        </div>

        <div class="flex items-center justify-center p-3 spinner hidden">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M2,12A11.2,11.2,0,0,1,13,1.05C12.67,1,12.34,1,12,1a11,11,0,0,0,0,22c.34,0,.67,0,1-.05C6,23,2,17.74,2,12Z"><animateTransform attributeName="transform" dur="0.6s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
        </div>
    </form>

    <script>
        let moduleIndex = 0;

        function addModule() {
            const modulesDiv = document.getElementById('modules');

            const moduleDiv = document.createElement('div');
            moduleDiv.classList.add('module');
            moduleDiv.dataset.index = moduleIndex;

            moduleDiv.innerHTML = `
                <div class='bg-slate-200 p-2 my-5'>
                <div class='flex items-center justify-between'>
                <h3>Module ${moduleIndex + 1}</h3>
                <button type="button" class="btn bg-red-600 text-white cursor-pointer p-1 rounded-md" onClick="removeModule(this)">Remove</button>
                </div>
                <div class='flex flex-col gap-1 my-2'> <label>Module Title:</label>
                <input class='bg-white p-2 rounded-md px-2' type="text" name="modules[${moduleIndex}][title]" required></div>
                <div class='flex flex-col gap-1 my-2'><label>Module Duration:</label>
                <input class='bg-white p-2 rounded-md px-2' type="text" name="modules[${moduleIndex}][duration]"></div>
                <div class="contents"></div>
                <button type="button" class='btn bg-green-600 text-white p-1 rounded-md cursor-pointer' onClick="addContent(this)">Add Content</button>
                </div>
            `;

            modulesDiv.appendChild(moduleDiv);
            moduleIndex++;
        }

        function removeModule(button) {
            const moduleDiv = button.closest('.module');
            moduleDiv.remove();
        }

        function addContent(button) {
            const moduleDiv = button.closest('.module');
            const index = moduleDiv.dataset.index;
            const contentsDiv = moduleDiv.querySelector('.contents');

            const contentCount = contentsDiv.children.length;

            const contentDiv = document.createElement('div');
            contentDiv.classList.add('content');

            contentDiv.innerHTML = `
            <div class='md:px-[100px] md:py-5 my-2'>
            <div class='bg-white w-full p-3 rounded-md'>
            <div class='flex items-center justify-between'>
            <h4>Content ${contentCount + 1}</h4>
            <button class='btn bg-red-600 text-white rounded-md p-1 cursor-pointer' type="button" onClick="removeContent(this)">Remove</button>
            </div>
            <div class='flex flex-col gap-1 my-2'>
            <label>Type:</label>
            <select class='bg-slate-200 p-2 rounded-md px-2' name="modules[${index}][contents][${contentCount}][content_type]">
            <option value="video">Video</option>
            <option value="audio">Audio</option>
            </select>
            </div>
            <div class='flex flex-col gap-1 my-2'>
            <label>Content URL:</label>
            <input class='bg-slate-200 p-2 rounded-md px-2' type="url" name="modules[${index}][contents][${contentCount}][content_url]">
            </div>
            <div class='flex flex-col gap-1 my-2'>
            <label>Duration:</label>
            <input class='bg-slate-200 p-2 rounded-md px-2' type="text" name="modules[${index}][contents][${contentCount}][duration]">
            </div>
            </div>
            </div>
            `;

            contentsDiv.appendChild(contentDiv);
        }

        function removeContent(button) {
            const contentDiv = button.closest('.content');
            contentDiv.remove();
        }


        document.getElementById('courseForm').addEventListener('submit', function(e) {
            e.preventDefault();
            $('.spinner').removeClass('hidden');
            const formData = new FormData(this);

            fetch('/user/course-action', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    $('.spinner').addClass('hidden');
                    alert('Course created successfully!');
                    window.location.reload();
                })
                .catch(err => {
                    alert('Error submitting course.');
                });
        });
    </script>

@endsection
