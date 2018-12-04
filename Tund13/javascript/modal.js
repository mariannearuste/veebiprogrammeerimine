let modal;
let modalImg;
let captionText;
let closeBtn;
let photoDir = "../picuploads/";
let modalId;

window.onload = function(){
  modal = document.getElementById("myModal");
  modalImg = document.getElementById("modalImg");
  captionText = document.getElementById("caption");
  closeBtn = document.getElementsByClassName("close")[0];
  let allThumbs = document.getElementById("gallery").getElementsByTagName("img");
  let thumbCount  = allThumbs.length;
  for(let i = 0; i < thumbCount; i ++){
    allThumbs[i].addEventListener("click", openModal);
  }
  closeBtn.addEventListener("click", closeModal);
  modalImg.addEventListener("click", closeModal);
}

function openModal(e){
  modal.style.display = "block";
  modalImg.src = photoDir + e.target.dataset.fn;
  modalId = e.target.dataset.id;
  captionText.innerHTML = e.target.alt; 
  for(let i = 1; i < 6; i ++){
		document.getElementById("rate" + i).checked=false
	}
 document.getElementById("storeRating") .addEventListener("click", storeRating);
 
 
}

function storeRating(){
	let rating;
	for(let i = 1; i < 6; i ++){
		if(document.getElementById("rate" + i).checked){
			rating = document.getElementById("rate" + i).checked);
			rating = i;	
		}
	}
	if(rating > 0){
		let request = new XMLHttpRequest();
	request.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			//järgmisena on asjad mida javascript peab tulemusega tegema
			document.getElementById("pic").innerHTML = this.responseText;
			document.getElementById("storeRating") .removeEventListener("click", storeRating);

		}
	}
	//siin määrate veebiaadressi ja parameetrid
	request.open("GET", "savephotorating.php?id=" + modalId + "&rating=" + rating, true);
	request.send();
	}
}	
	

function closeModal(){
  modal.style.display = "none";
}
