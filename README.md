Nota: 
//Reload sekiranya session tamat (419)
error: function(xhr, error, code) {
    if (xhr.status === 419) {
        window.location.reload();
    } else {
        console.error('An error occurred:', error);
    }
}
