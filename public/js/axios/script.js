function messageRender(message,color,error="error"){

    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-right',
        iconColor: color,
        customClass: {
          popup: 'colored-toast',
        },
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
      });

    if(typeof message === 'object'){
        let er = '';
        for (const item in message) {
            if(typeof (message[item]) === 'object'){
                for (const errors in message[item]) {
                    Toast.fire({
                        icon: error,
                        title: message[item][errors],
                    })
                }
            }else{
                Toast.fire({
                    icon: error,
                    title: message[item],
                })
            }
        }
    }else{
        Toast.fire({
            icon: error,
            title: message,
        })
    }
}
