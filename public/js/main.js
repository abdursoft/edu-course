/****************************************
 * | All users functionality defined here
 ***************************************/


/********************
 * | Loading sppinner
 *******************/

async function spinner(container,color='danger'){
    $(container).html(`<div class="flex items-center justify-center"><div class="spinner-border text-${color}" role="status"><span class="sr-only"></span></div></div>`);
}


/*************************************
 * | User authenctication and profiles
 ************************************/

async function userRegistration() {
    await spinner('.errorMsg');
    axios.post('/signup',$(".userRegistration").serialize())
    .then((response) => {
        if(response.status === 201){
            messageRender(response.data.message,'green','success');
        }else{
            messageRender(response.data.message,'red');
        }
        $(".userRegistration")[0].reset();
        $(".errorMsg").empty();
    }).catch( async (error) =>{
        $(".errorMsg").empty();
        messageRender(error.response.data.errors,'red');
    })
}

async function loginToBook() {
    sessionStorage.setItem('backURL',window.location.href);
    window.location.href = '/login';
}

async function userLogin() {
    await spinner('.errorMsg');
    axios.post('/signin',$(".userLogin").serialize())
    .then((response) => {
        if(response.status === 200){
            messageRender(response.data.message,'green','success');

            if(sessionStorage.backURL !== undefined){
                let url = sessionStorage.backURL;
                sessionStorage.removeItem('backURL');
                window.location.href = url;
            }else{
                window.location.href = '/user/dashboard';
            }
        }else{
            messageRender(response.data.message,'red');
        }
    }).catch( async (error) =>{
        $(".errorMsg").empty();
        messageRender(error.response.data.message,'red');
    })
}

async function userProfile() {
    await spinner('.errorMsg');
    axios.post('/user/profile',$(".userProfile").serialize())
    .then((response) => {
        if(response.status === 200){
            messageRender(response.data.message,'green','success');
        }else{
            messageRender(response.data.message,'red');
        }
        $(".errorMsg").empty();
    }).catch(error => {
        messageRender(error.response.data.message,'red');
        $(".errorMsg").empty();
    })
}


async function getProfile() {
    axios.get('/user/profile')
    .then((response) => {
        if(response.status === 200){
            const data = response.data.data;
            $(".name").val(data.name);
            $(".email").val(data.email);
            $(".phone").val(data.phone);
            $(".address").val(data.address);
        }
    })
}

async function toggleProfileForm() {
    $("#car_form").toggleClass('d-none');
}

async function getRents() {
    axios.get('/user/get-rents')
    .then((response) => {
        if(response.status === 200){
            const rents = response.data.data;
            let complete = 0;
            let onGoing = 0;
            let amount = 0;
            let book = 0;

            $(rents).each((index,item) => {
                let num = item.status === 'Ongoing' ? 1 : 0;
                let bok = item.status === 'Booked' ? 1 : 0;
                let com = item.status === 'Completed' ? 1 : 0;
                onGoing += num;
                book += bok;
                complete += com;

                if(item.status === 'Ongoing' || item.status === 'Completed'){
                    amount += parseInt(item.total_cost);
                }
            })
            $(".totalRent").text(complete);
            $(".onGoing").text(onGoing);
            $(".totalSpent").text(amount);
            $(".totalBook").text(book);
        }
    })
}


async function rentTable() {
    table = new DataTable('#rentCompleted' ,{
        layout: {
            topStart: {
                buttons: ['excelHtml5', 'csvHtml5', 'pdfHtml5']
            }
        }
    })

}


async function destroyTable() {
    $("#rentCompleted").DataTable().destroy();
}

async function renderTables(event=true) {
    axios.get('/user/get-rents')
    .then(async (response) => {
        if(response.status === 200){
            let rents = response.data.data;
            $(".bodyCompleted").empty();
            $(rents).each((index, item) => {
                let clss = '';
                let ogAction = '';
                if(item.status === 'Booked'){
                    ogAction = `<button class='btn btn-outline-danger' onClick="rentCancel('${item.id}')">Cancel</button>`;
                    clss = "text-dark";
                }else if(item.status === 'Completed'){
                    clss = "text-success";
                }
                else if(item.status === 'Ongoing'){
                    clss = "text-primary";
                }else{
                    clss = "text-danger";
                }
                $(".bodyCompleted").append(`
                    <tr>
                        <td>${item.start_date}</td>
                        <td>${item.end_date}</td>
                        <td>${item.days} days</td>
                        <td>${item.total_cost}</td>
                        <td>${ogAction}</td>
                        <td><p class="${clss}">${item.status}</p></td>
                    </tr>
                `);
            });
            if(event){
                await rentTable();
            }
        }
    })
}

async function rentCancel(id) {
    axios.post('/user/rents/cancel',{id:id})
    .then(async (response) => {
        if(response.status === 200){
            messageRender(response.data.message,'green','success');
            await destroyTable();
            await renderTables();
        }else{
            messageRender(response.data.message,'red');
        }
    }).catch(error => {
        messageRender(error.response.data.message,'red');
    })
}



/**************************************
 * | Car finding and Search for booking
 *************************************/

async function searchCar() {
    const type = $(".carType").val();
    const brand = $(".carBrand").val();
    const price = $("#carPrice").val();

    await spinner('.carSection');
    await spinner('.paginationSection');
    axios.get(`/car/search?car_type=${type}&price=${price}&brand=${brand}`)
    .then(async(response) => {
        if(response.status === 200){
            await carRender(response.data.data);
            await paginatorButtons(response.data.links,`car_type=${type}&price=${price}&brand=${brand}`);
        }
    })
}


async function carPaginator() {
    await spinner('.carSection');
    await spinner('.paginationSection');
    axios.get('/car/find')
    .then(async(response) => {
        if(response.status === 200){
            await carRender(response.data.data);
            await paginatorButtons(response.data.links);
        }
    })
}


async function carRender(data) {
    if(typeof data === 'object' || typeof data === 'array'){
        $(".carSection").empty();
        $(data).each((index,item) => {
            if(item)
            $(".carSection").append(`
                <div class="col-md-3 item p-2">
                    <a href="/car/details/${item.id}" title="Life" class="image-link"><img src="/storage/${item.image}"
                            class="post-image img-fluid" />
                        <div class="types mt-2">
                            <h4 class="text-center text-uppercase m-0 text-dark">
                                ${item.name}
                            </h4>
                            <p class="text-center m-0 p-0">Starts from <b> ${item.daily_rent_price}৳/day</b></p>

                            <div class="d-flex justify-content-center">
                                <a href="/car/details/${item.id}" class="btn-underline mt-2 mb-2 text-uppercase fw-bold"
                                    style="font-size: 14px">Rent now</a>
                            </div>
                        </div>
                    </a>
                </div>
            `);
        });
    }
}

async function getPaginator(url,urlSuffix=undefined) {
    await spinner('.carSection');
    await spinner('.paginationSection');
    axios.get(url)
    .then(async(response) => {
        if(response.data !== null){
            await carRender(response.data.data);
            await paginatorButtons(response.data.links,urlSuffix);
        }
    })
}

async function paginatorButtons(links,urlSuffix=undefined) {
    $(".paginationSection").empty();
    $(links).each((index,item) => {
        if(index !== 0 && index < links.length - 1){
            let active = item.active === true ? 'btnActive' : '';
            let url = urlSuffix !== undefined ? item.url+"&"+urlSuffix : item.url;
            $(".paginationSection").append(`
                <div onclick="getPaginator('${url}','${urlSuffix}')" class='btnBox ${active}'>${item.label}</div>
            `);
        }
    })
}

async function getCarType() {
    axios.get('/car/types')
    .then(async(response) => {
        $(".carType").empty();
        $(".carType").append(`<option value='' selected>Select Car Type</option>`);
        if(response.status === 200){
            $(response.data.data).each((index,item) => {
                $(".carType").append(`<option value="${item.car_type}">${item.car_type}</option>`);
            })
        }
    })
}

async function getCarBrand() {
    axios.get('/car/brands')
    .then(async(response) => {
        $(".carBrand").empty();
        $(".carBrand").append(`<option value='' selected>Select a Brand</option>`);
        if(response.status === 200){
            $(response.data.data).each((index,item) => {
                $(".carBrand").append(`<option value="${item.brand}">${item.brand}</option>`);
            })
        }
    })
}




/**************************************
 * | Car checking availability for book
 *************************************/


async function chekAvailability() {
    await spinner('.errorMsg');
    axios.post('/car/availability',$("#chekAvailability").serialize())
    .then(async (response) => {
        if(response.status === 200){
            messageRender(response.data.message,'green','success');
        }else{
            messageRender(response.data.message,'red');
        }
        $(".errorMsg").empty();
    }).catch(error => {
        messageRender(error.response.data.message,'red');
        $(".errorMsg").empty();
    });
}
