function darkmode(){
    const body = document.body
    const wasDarkmode = localStorage.getItem('darkmode') == 'true'

    localStorage.setItem('darkmode', !wasDarkmode)
    body.classList.toggle('dark-mode', !wasDarkmode)
}

document.querySelector('.btn').addEventListener('click', darkmode)

function onload(){
    document.body.classList.toggle('dark-mode', localStorage.getItem('darkmode') == 'true')
}
document.addEventListener('DOMContentLoaded', onload)

