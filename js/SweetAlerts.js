function alreadyExists() {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Gebruiker bestaat al!',
    })
}

function passwordError() {
    Swal.fire({
        icon: 'error',
        title: 'Wachtwoord verkeerd',
        text: 'Wachtwoorden zijn niet het zelfde!',
    })
}
function wrongEmail() {
    Swal.fire({
        icon: 'error',
        title: 'Email incorrect',
        text: 'Email is incorect of bestaat al',
    })
}
function LoginError() {
    Swal.fire({
        icon: 'error',
        title: 'incorrect',
        text: 'Email of wachtwoord is incorect',
    })
}
function ageError() {
    Swal.fire({
        icon: 'error',
        title: 'Leeftijd',
        text: 'U leeftijd is geen getal probeer opnieuw',
    })
}

function adminsucsess() {
    Swal.fire({
        icon: 'success',
        title: 'data',
        text: 'U data is sucsessvol geinsert',
    })
}