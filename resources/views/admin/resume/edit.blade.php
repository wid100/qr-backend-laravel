@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Resume Edit</a></li>

            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                           <form action="{{ route('admin.resume.update', $resume->id) }}" method="POST" class="my-4">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="resume_name" class="form-label">Resume Name</label>
                                    <input type="text" class="form-control" name="resume_name" value="{{ old('resume_name', $resume->resume_name ?? '') }}" placeholder="Not Available">
                                </div>
                                <div class="mb-3">
                                    <label for="fname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="fname" value="{{ old('fname', $resume->fname ?? '') }}" placeholder="Not Available">
                                </div>
                                <div class="mb-3">
                                    <label for="lname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="lname" value="{{ old('lname', $resume->lname ?? '') }}" placeholder="Not Available">
                                </div>
                                <div class="mb-3">
                                    <label for="profession" class="form-label">Profession</label>
                                    <input type="text" class="form-control" name="profession" value="{{ old('profession', $resume->profession ?? '') }}" placeholder="Not Available">
                                </div>


                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="number" class="form-control" name="phone" value="{{ old('phone', $resume->phone ?? '') }}" placeholder="Not Available">
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email', $resume->email ?? '') }}" placeholder="Not Available">
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3">{{ $resume->description ?? '' }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="3">{{ $resume->address ?? '' }}</textarea>
                                </div>

                                <h4>Work Experience</h4>
                                <div>
                                    <input hidden  id="work-data" type="text" class="form-control" value='{{ $resume->experience }}'>
                                    <input hidden  name="work" id="work" type="text" class="form-control" value="">
                                </div>
                                <div id="work-container">
                                </div>

                                <h4>Education</h4>
                                <div>
                                    <input hidden  id="data" type="text" class="form-control" value='{{ $resume->education }}'>
                                    <input hidden  name="education" id="education" type="text" class="form-control" value="">
                                </div>
                                <div id="education-container">
                                </div>

                                <h4>Skills</h4>
                                <div>
                                    <input hidden  type="text" class="form-control"  id="skills" value="{{ $resume->skill ?? '' }}">
                                    <input hidden name="skills" type="text" class="form-control"  id="skill-value" value="">
                                </div>

                                <div class="d-flex gap-2 my-2" id="skill-content">
                                </div>

                                <h4>Languages</h4>
                                <div>
                                    <input hidden   type="text" class="form-control"  id="languages" value="{{ $resume->language ?? '' }}">
                                    <input hidden  name="languages" type="text" class="form-control"  id="languages-value" value="">
                                </div>

                                <div class="d-flex gap-2 my-2" id="languages-content">
                                </div>

                                <h4>Interests</h4>
                                <div>
                                    <input hidden   type="text" class="form-control"  id="interest" value="{{ $resume->interest ?? '' }}">
                                    <input hidden  name="interest" type="text" class="form-control"  id="interest-value" value="">
                                </div>

                                <div class="d-flex gap-2 my-2" id="interest-content">
                                </div>

                                <h4>References</h4>
                                <div>
                                    <input hidden  id="references-data" type="text" class="form-control" value='{{ $resume->references }}'>
                                    <input   name="references" id="references" type="text" class="form-control" value="">
                                </div>
                                <div id="references-container">
                                </div>

                                <div class="my-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                          Active
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault2" checked>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                          Inactive
                                        </label>
                                    </div>
                                </div>


                                <a href="{{ route('admin.resume.index') }}" class="btn btn-info mt-4 rounded " style="margin: 0 !important;">Back</a>
                                <button class="btn btn-success ">Submit</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
{{-- education js  --}}
<script>
    var data = document.getElementById('data').value;
    var educationDataInput = document.getElementById('education');
    var educationData = JSON.parse(data);
    educationDataInput.value = JSON.stringify(educationData);

    var container = document.getElementById('education-container');


    function renderEducation() {
        container.innerHTML = '';

        educationData.forEach(function(item, index) {
            var educationHtml = `
                <div class="container mb-4 border border-1 ">
                    <h6 class="mt-2 d-flex gap-2">
                        <span class=" p-1 bg-warning text-black rounded btn-delete btn-sm" data-index="${index}" style="cursor:pointer;">Delete</span>

                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="institution" class="form-label">Institution</label>
                            <input type="text" class="form-control handleInput" attr="institution" data-index="${index}" value="${item.institution }" placeholder="Not Available">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="degree" class="form-label">Degree</label>
                            <input type="text" class="form-control handleInput" attr="degree" data-index="${index}"  value="${item.degree }">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fieldOfStudy" class="form-label">Field of Study</label>
                            <input type="text" class="form-control handleInput" data-index="${index}" attr="fieldOfStudy" value="${item.fieldOfStudy }" placeholder="Not Available">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="grade" class="form-label">Grade</label>
                            <input type="text" class="form-control handleInput" data-index="${index}" attr="grade" value="${item.grade }" placeholder="Not Available">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="startMonth" class="form-label">Start Month</label>
                            <input type="month" class="form-control handleInput" data-index="${index}" attr="startMonth" value="${item.startMonth ? new Date(item.startMonth).toISOString().substr(0, 7) : ''}" placeholder="Not Available">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="startYear" class="form-label">Start Year</label>
                            <input type="number" class="form-control handleInput" data-index="${index}" attr="startYear" value="${item.startYear ? new Date(item.startYear).getFullYear() : ''}" placeholder="Not Available">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="endMonth" class="form-label">End Month</label>
                            <input type="month" class="form-control handleInput" data-index="${index}" attr="endMonth" value="${item.endMonth ? new Date(item.endMonth).toISOString().substr(0, 7) : ''}" placeholder="Not Available">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="endYear" class="form-label">End Year</label>
                            <input type="number" class="form-control handleInput" data-index="${index}" attr="endYear" value="${item.endYear ? new Date(item.endYear).getFullYear() : ''}" placeholder="Not Available">
                        </div>
                    </div>
                </div>
            `;


            container.innerHTML += educationHtml;
        });


        var deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var index = this.getAttribute('data-index');
                deleteEducation(index);
            });
        });
    }

    // Function to delete an education item
    function deleteEducation(index) {
        educationData.splice(index, 1);

        renderEducation();
        console.log('result: ', educationData);
        educationDataInput.value = JSON.stringify(educationData );
    }
    renderEducation();

    document.querySelectorAll('.handleInput').forEach(function(input) {
        input.addEventListener('input', function() {
            var index = this.getAttribute('data-index');
            var attr = this.getAttribute('attr');
            educationData[index][attr] = this.value;

            console.log(educationData);
            educationDataInput.value = JSON.stringify(educationData );
        });
    });




</script>

{{-- work js  --}}
<script>
    var workData = document.getElementById('work-data').value;
    var workDataInput = document.getElementById('work');
    var workData = JSON.parse(workData);
    workDataInput.value = JSON.stringify(workData);

    var workContainer = document.getElementById('work-container');
    function renderWork() {
        workContainer.innerHTML = '';

        workData.forEach(function(item, index) {
            var workHtml = `
                <div class="container mb-4 border border-1 ">
                    <h6 class="mt-2 d-flex gap-2">
                        <span class=" p-1 bg-warning text-black rounded btn-work-delete btn-sm" data-index="${index}" style="cursor:pointer;">Delete</span>

                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jobTitle" class="form-label">Job Title</label>
                            <input type="text" class="form-control handleWorkInput" attr="jobTitle" data-index="${index}" value="${item.jobTitle }" placeholder="Not Available">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="employeeName" class="form-label">Company Name</label>
                            <input type="text" class="form-control handleWorkInput" attr="employeeName" data-index="${index}"  value="${item.employeeName }">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label">Location Address</label>
                            <input type="text" class="form-control handleWorkInput" data-index="${index}" attr="location" value="${item.location }" placeholder="Not Available">
                        </div>
                        <div class="col-md-6 mb-3">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="startMonth" class="form-label">Start Month</label>
                            <input type="month" class="form-control handleWorkInput" data-index="${index}" attr="startMonth" value="${item.startMonth ? new Date(item.startMonth).toISOString().substr(0, 7) : ''}" placeholder="Not Available">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="startYear" class="form-label">Start Year</label>
                            <input type="number" class="form-control handleWorkInput" data-index="${index}" attr="startYear" value="${item.startYear ? new Date(item.startYear).getFullYear() : ''}" placeholder="Not Available">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="endMonth" class="form-label">End Month</label>
                            <input type="month" class="form-control handleWorkInput" data-index="${index}" attr="endMonth" value="${item.endMonth ? new Date(item.endMonth).toISOString().substr(0, 7) : ''}" placeholder="Not Available">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="endYear" class="form-label">End Year</label>
                            <input type="number" class="form-control handleWorkInput" data-index="${index}" attr="endYear" value="${item.endYear ? new Date(item.endYear).getFullYear() : ''}" placeholder="Not Available">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Job Description</label>
                            <textarea class="form-control handleWorkInput" data-index="${index}" attr="description" placeholder="Not Available">${item.description}</textarea>
                        </div>
                        <div class="col-md-12 mb-3 " >
                            <div class="form-check">
                            <input class="form-check-input workingNowCheckbox" type="checkbox" data-index="${index}" attr="workingNow" ${item.workingNow ? 'checked' : ''} >
                            <label class="form-check-label"> I am currently working here.</label>
                        </div>

                    </div>
                </div>
            `;


            workContainer.innerHTML += workHtml;
        });


        var deleteWorkBtn = document.querySelectorAll('.btn-work-delete');
        deleteWorkBtn.forEach(function(button) {
            button.addEventListener('click', function() {
                var index = this.getAttribute('data-index');
                deleteWork(index);
            });
        });
    }

    // Function to delete an education item
    function deleteWork(index) {
        workData.splice(index, 1);

        renderWork();
        console.log('result: ', workData);
        workDataInput.value = JSON.stringify(workData);
    }
    renderWork();

    // input change data
    document.querySelectorAll('.handleWorkInput').forEach(function(input) {
        input.addEventListener('input', function() {
            var index = this.getAttribute('data-index');
            var attr = this.getAttribute('attr');
            workData[index][attr] = this.value;

            console.log(workData[index]);
            workDataInput.value = JSON.stringify(workData);
        });
    });

    // working now checked
    var workingNowCheckboxes = document.querySelectorAll('.workingNowCheckbox');
    workingNowCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var index = this.getAttribute('data-index');
            var isChecked = this.checked;
            workData[index].workingNow = isChecked;

            if (isChecked) {
                workData[index].endMonth = null;
                workData[index].endYear = null;
                console.log(`Currently working at index ${index}`);
            } else {
                console.log(`Not currently working at index ${index}`);
            }

            workDataInput.value = JSON.stringify(workData);
            console.log(workData[index].workingNow);

        });
    });


</script>

{{-- skills  --}}
<script>

    var skillsData = JSON.parse(document.getElementById('skills').value);
    var skillValue = document.getElementById('skill-value');
    skillValue.value = JSON.stringify(skillsData);
    var skillContent = document.getElementById('skill-content');

    // Function to render skills
    function renderSkills() {
        skillContent.innerHTML = '';

        skillsData.forEach(function(skill, index) {
            var skillHtml = `
                <div class="skill-item border border-1 p-2 shadow" data-index="${index}">
                    <span>${skill}</span>
                    <button type="button" class="badge text-bg-warning btn-skill-delete" data-index="${index}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-dark " style="width:15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            `;
            skillContent.innerHTML += skillHtml;
        });

        // Add delete event listeners after rendering
        var deleteSkillButtons = document.querySelectorAll('.btn-skill-delete');
        deleteSkillButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var index = this.getAttribute('data-index');
                deleteSkill(index);
            });
        });
    }

    // Function to delete a skill item

    function deleteSkill(index) {
        skillsData.splice(index, 1);

        skillValue.value = JSON.stringify(skillsData);

        console.log('skills after delete: ', skillsData);
        renderSkills();
    }

    // Initial render of the skills
    renderSkills();


</script>

{{-- languages  --}}
<script>

    var languagesData = JSON.parse(document.getElementById('languages').value);
    var languagesValue = document.getElementById('languages-value');
    languagesValue.value = JSON.stringify(languagesData);
    var languagesContent = document.getElementById('languages-content');

    // Function to render skills
    function renderLanguage() {
        languagesContent.innerHTML = '';

        languagesData.forEach(function(item, index) {
            var skillHtml = `
                <div class="skill-item border border-1 p-2 shadow" data-index="${index}">
                    <span>${item}</span>
                    <button type="button" class="badge text-bg-warning btn-languages-delete" data-index="${index}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-dark " style="width:15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            `;
            languagesContent.innerHTML += skillHtml;
        });

        // Add delete event listeners after rendering
        var deleteLanguagesButtons = document.querySelectorAll('.btn-languages-delete');
        deleteLanguagesButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var index = this.getAttribute('data-index');
                deleteLanguage(index);
            });
        });
    }

    // Function to delete a skill item

    function deleteLanguage(index) {
        languagesData.splice(index, 1);

        languagesValue.value = JSON.stringify(languagesData);

        console.log('skills after delete: ', languagesData);
        renderLanguage();
    }

    // Initial render of the skills
    renderLanguage();


</script>

{{-- interest  --}}
<script>

    var interestData = JSON.parse(document.getElementById('interest').value);
    var interestValue = document.getElementById('interest-value');
    interestValue.value = JSON.stringify(interestData);
    var interestContent = document.getElementById('interest-content');

    // Function to render skills
    function renderInterest() {
        interestContent.innerHTML = '';

        interestData.forEach(function(item, index) {
            var interestHtml = `
                <div class="skill-item border border-1 p-2 shadow" data-index="${index}">
                    <span>${item}</span>
                    <button type="button" class="badge text-bg-warning btn-interest-delete" data-index="${index}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-dark " style="width:15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            `;
            interestContent.innerHTML += interestHtml;
        });

        // Add delete event listeners after rendering
        var deleteInterestButtons = document.querySelectorAll('.btn-interest-delete');
        deleteInterestButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var index = this.getAttribute('data-index');
                deleteInterest(index);
            });
        });
    }

    // Function to delete a skill item

    function deleteInterest(index) {
        interestData.splice(index, 1);

        interestValue.value = JSON.stringify(interestData);

        console.log('skills after delete: ', interestData);
        renderInterest();
    }

    // Initial render of the skills
    renderInterest();


</script>

{{-- references js  --}}
<script>
    var referencesData = document.getElementById('references-data').value;
    var referencesDataInput = document.getElementById('references');
    var referencesData = JSON.parse(referencesData);
    referencesDataInput.value = JSON.stringify(referencesData);

    var referencesContainer = document.getElementById('references-container');
    function renderReferences() {
        referencesContainer.innerHTML = '';

        referencesData.forEach(function(item, index) {
            var workHtml = `
                <div class="container mb-4 border border-1 ">
                    <h6 class="mt-2 d-flex gap-2">
                        <span class=" p-1 bg-warning text-black rounded btn-references-delete btn-sm" data-index="${index}" style="cursor:pointer;">Delete</span>

                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control handleReferencesInput" attr="firstName" data-index="${index}" value="${item.firstName }" placeholder="Not Available">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control handleReferencesInput" attr="lastName" data-index="${index}"  value="${item.lastName }">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jobTitle" class="form-label">Job Title </label>
                            <input type="text" class="form-control handleReferencesInput" data-index="${index}" attr="jobTitle" value="${item.jobTitle }" placeholder="Not Available">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" class="form-control handleReferencesInput" data-index="${index}" attr="phone" value="${item.phone }" placeholder="Not Available">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control handleReferencesInput" data-index="${index}" attr="email" value="${item.email }" placeholder="Not Available">
                        </div>


                    </div>
                </div>
            `;


            referencesContainer.innerHTML += workHtml;
        });


        var deleteReferencesBtn = document.querySelectorAll('.btn-references-delete');
        deleteReferencesBtn.forEach(function(button) {
            button.addEventListener('click', function() {
                var index = this.getAttribute('data-index');
                deleteReferences(index);
            });
        });
    }


    // Function to delete an education item
    function deleteReferences(index) {
        referencesData.splice(index, 1);

        renderReferences();
        console.log('result: ', referencesData);
        referencesDataInput.value = JSON.stringify(referencesData);
    }
    renderReferences();

    // input change data
    document.querySelectorAll('.handleReferencesInput').forEach(function(input) {
        input.addEventListener('input', function() {
            var index = this.getAttribute('data-index');
            var attr = this.getAttribute('attr');
            referencesData[index][attr] = this.value;

            console.log(referencesData[index]);
            referencesDataInput.value = JSON.stringify(referencesData);
        });
    });




</script>



@endsection


