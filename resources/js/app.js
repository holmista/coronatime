let hamburger = document.getElementById('hamburger')
hamburger.addEventListener('click', () => {
    let littleMenu = document.getElementById('littleMenu')
    let display = littleMenu.style.display === "flex" ? "none" : "flex"
    littleMenu.style.display = display
})

const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());

for (let i in params){
    if(i==='country'){
        let down = document.getElementById('desc-country')
        let up = document.getElementById('asc-country')
        if(params[i]==='desc'){
            down.setAttribute("fill", "#010414")
            up.setAttribute("fill", "#BFC0C4")
        }
        else if(params[i]==='asc'){
            up.setAttribute("fill", "#010414")
            down.setAttribute("fill", "#BFC0C4")
        }
    }
    if(i==='confirmed'){
        let down = document.getElementById('desc-confirmed')
        let up = document.getElementById('asc-confirmed')
        if(params[i]==='desc'){
            down.setAttribute("fill", "#010414")
            up.setAttribute("fill", "#BFC0C4")
        }
        if(params[i]==='asc'){
            up.setAttribute("fill", "#010414")
            down.setAttribute("fill", "#BFC0C4")
        }
    }
    if(i==='deaths'){
        let down = document.getElementById('desc-deaths')
        let up = document.getElementById('asc-deaths')
        if(params[i]==='desc'){
            down.setAttribute("fill", "#010414")
            up.setAttribute("fill", "#BFC0C4")
        }
        if(params[i]==='asc'){
            up.setAttribute("fill", "#010414")
            down.setAttribute("fill", "#BFC0C4")
        }
    }
    if(i==='recovered'){
        let down = document.getElementById('desc-recovered')
        let up = document.getElementById('asc-recovered')
        if(params[i]==='desc'){
            down.setAttribute("fill", "#010414")
            up.setAttribute("fill", "#BFC0C4")
        }
        if(params[i]==='asc'){
            up.setAttribute("fill", "#010414")
            down.setAttribute("fill", "#BFC0C4")
        }
    }
}
