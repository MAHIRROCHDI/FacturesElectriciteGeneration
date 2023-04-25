const reclamationType = document.querySelector(".reclamation select") ; 
const autreType = document.createElement("input") ; 
autreType.setAttribute("name" , "autre") ; 
autreType.setAttribute("class" , "d-block mb-20 w-full p-10 rad-6 b-none bg-eee"); 
autreType.setAttribute("placeholder" , "Le type de reclamation"); 
console.log(autreType) ; 
if(reclamationType){
    reclamationType.addEventListener("input"  ,function(){
        if(reclamationType.value === "autre"){
            reclamationType.after(autreType) ;
        }
        else {
            autreType.remove(); 
        }
    })
}