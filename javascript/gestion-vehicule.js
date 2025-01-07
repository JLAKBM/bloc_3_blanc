function openForm(gestionMode) {
    if (gestionMode == "ajout") {
        document.querySelector(".formulaire-gestion h1").innerText = "Ajouter un véhicule"
        document.querySelector('.formulaire-gestion input[type="submit"]').value = "Ajouter un véhicule"
    }
    else {
        document.querySelector(".formulaire-gestion h1").innerText = "Modifier un véhicule"
        document.querySelector('.formulaire-gestion input[type="submit"]').inneText = "Modifier un véhicule"
    }

    document.querySelector('.formulaire-gestion input[type="hidden"]').value = gestionMode
    
    gestionVehiculeSectionClassList = document.querySelector("#gestion-vehicule").classList
    if (gestionVehiculeSectionClassList.contains("open")) {
        gestionVehiculeSectionClassList.remove("open")
    }
    else {
        gestionVehiculeSectionClassList.add("open")
    }
}

function openDetails(element) {
    if (element.lastElementChild.classList.contains("open")) {
        element.lastElementChild.classList.remove("open")
    }
    else {
        element.lastElementChild.classList.add("open")
    }
}

function deleteVehicule(element) {
    if (confirm("Voulez-vous vraiment supprimer le véhicule " + element.id + " ?")) {
        form = document.querySelector('#supprimer-vehicule')
        form.firstElementChild.value = element.id
        form.submit()
    }
}