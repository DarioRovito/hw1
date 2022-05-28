//necessaria per la ricerca dei diversi contenuti che vengono distinti tramite type
function search(event) {
  console.log('entra qui');
  event.preventDefault();
  contents = {};
  const form_data = new FormData(document.querySelector("form"));
  contents.type = form_data.get('type');

  if (contents.type === "sports") {
    console.log("sports");
    fetch("search_content.php?type=" + contents.type + "&q=" + encodeURIComponent(form_data.get('content'))).then(onResponse).then(onJson_sports);
  }

  if (contents.type === "giphy") {
    console.log("giphy");
    fetch("search_content.php?type=" + contents.type + "&q=" + encodeURIComponent(form_data.get('content'))).then(onResponse).then(onJson_gif);
  }

  if (contents.type === "spotify") {
    console.log('spotify');
    fetch("search_content.php?type=" + contents.type + "&q=" + encodeURIComponent(form_data.get('content'))).then(onResponse).then(onJson_spotify);
  }
}

function onResponse(response) {
  console.log('risposta ricevuta');
  console.log(response);
  return response.json();
}

//Permette di stampare le canzoni che si cercano
function onJson_spotify(json) {
  console.log(json);
  console.log('appendi musica');
  const bookcase = document.querySelector('.box_container #contents');
  bookcase.innerHTML = '';
  if (json.tracks.items.length == 0 || !json.tracks.items.length) {
    console.log('nessun risultato');
    const error = document.createElement("h1");
    error.classList.add('error');
    const messaggio = document.createTextNode("Nessun risultato!");
    error.appendChild(messaggio);
    bookcase.appendChild(error);
  } else {

    for (let mus in json.tracks.items) {
      const music = json.tracks.items[mus];
      const immagine = music.album.images[1].url;
      const shelf = document.createElement('div');
      shelf.classList.add('content');
      const img = document.createElement('img');
      img.src = immagine;
      img.dataset.id = json.tracks.items[mus].id;

      const artists_name = document.createElement('h1');
      artists_name.textContent = music.artists[0].name;
      const name_music = document.createElement('h2');
      name_music.textContent = music.album.name;

      shelf.appendChild(img);

      shelf.appendChild(name_music);
      shelf.appendChild(artists_name);
      bookcase.appendChild(shelf);
      img.addEventListener('click', apriModale);
    }
  }
}

//Stampa  gli sports cercati
function onJson_sports(json) {
  console.log(json);
  console.log('appendi sport');
  const bookcase = document.querySelector('.box_container #contents');
  bookcase.innerHTML = '';
  const results = json;
  // Leggi il numero di risultati e memorizzo dentro una variabile
  let num_results = results.length;

  if (num_results == 0 || !num_results) {
    console.log('nessun risultato');
    const error = document.createElement("h1");
    error.classList.add('error');
    const messaggio = document.createTextNode("Nessun risultato!");
    error.appendChild(messaggio);
    bookcase.appendChild(error);
  }
  //nel caso in cui la ricerca abbia trovato elementi o non sia stato digitato sbagliato 
  else {
    let j = 0;
    //nel caso in cui gli elementi trovati siano inferiori a 10
    if (num_results < 10) {
      console.log('diminuisci valore');
      j = num_results;
    }
    else {
      //nel caso gli elementi siano superiori a 10
      console.log('entra qui');
      j = 10;
    }
    //visualizzo risultati fino ad un massimo di 10 elementi che verranno ristituiti dal json
    for (let i = 0; i < j; i++) {
      console.log('visualizza risultati');
      if (results[i].relationships.images.data[0]) {
        const immagine = results[i].relationships.images.data[0].url;
        const shelf = document.createElement('div');
        shelf.classList.add('content');
        const img = document.createElement('img');
        img.src = immagine;
        const name_sport = document.createElement('h2');
        name_sport.textContent = results[i].attributes.name;
        img.dataset.id = results[i].id;
        img.addEventListener('click', apriModale);
        shelf.appendChild(img);
        shelf.appendChild(name_sport);
        bookcase.appendChild(shelf);
      }
    }
  }

}

//Stampa le gif cercate
function onJson_gif(json) {
  console.log(json);
  console.log('appendi gif');
  const bookcase = document.querySelector('.box_container #contents');
  bookcase.innerHTML = '';
  const gif = json;
  if (json.length == 0 || !json.length) {
    console.log('nessun risultato');
    const error = document.createElement("h1");
    const messaggio = document.createTextNode("Nessun risultato!");
    error.appendChild(messaggio);
    bookcase.appendChild(error);
  } else {

    for (let j = 0; j < 10; j++) {
      const immagine = gif[j].thumbnail;
      const shelf = document.createElement('div');
      shelf.classList.add('content');
      const img = document.createElement('img');
      img.src = immagine;
      img.dataset.id = json[j].id;
      shelf.appendChild(img);
      bookcase.appendChild(shelf);
      img.addEventListener('click', apriModale);
    }

  }
}

let contenuto = {};

//Apre la modale che visualizza il contenuto cercato permette la condivisione di esso
function apriModale(event) {
  const type = contents.type;
  console.log(type);

  contents.id = event.currentTarget.dataset.id;
  console.log(contents.id);

  const modale = document.querySelector('#modale');
  //creo un nuovo elemento img

  const container = document.createElement('div');
  container.classList.add('container_modal');

  //blocco lo scroll della pagina
  document.body.classList.add('no-scroll');
  //rendo la modale visibile
  modale.classList.remove('hidden');

  const btnEsc = document.createElement('button');
  btnEsc.classList.add('Esc_modal');
  btnEsc.addEventListener('click', chiudiModale);
  btnEsc.textContent = 'Esci';

  const btnCondividi = document.createElement('button');
  btnCondividi.classList.add('btnCond');
  btnCondividi.textContent = 'Condividi';
  btnCondividi.addEventListener('click', Condividi);

  const titoloPost = document.createElement('input');
  titoloPost.type = 'text';
  titoloPost.classList.add('titolo');
  titoloPost.placeholder = 'Inserisci un titolo';

  const image = document.createElement('img');
  image.classList.add('condivisione');
  image.src = event.currentTarget.src;
  container.appendChild(image);

  if (type === 'spotify') {

    contenuto = document.createElement('iframe');
    contenuto.src = "https://open.spotify.com/embed/track/" + contents.id;
    contenuto.frameBorder = 0;
    contenuto.setAttribute('allowtransparency', 'true');
    contenuto.allow = "encrypted-media";
    contenuto.classList = "track";

    container.appendChild(contenuto);
  }

  modale.appendChild(container);

  container.appendChild(titoloPost);
  container.appendChild(btnEsc);
  container.appendChild(btnCondividi);





}

//una volta condiviso il post si viene reinderizzati alla home
function RitornoHome() {
  location.href = "home.php";

}

//Condividi il post
function Condividi(event) {
  console.log(event.currentTarget);
  const controltitolo = document.querySelector('.titolo');

  if (controltitolo.value == '') {

    alert('Inserisci un titolo al Post');

  }
  else {

    const titolo = document.querySelector('.titolo');


    const formData = new FormData();

    console.log(contents.type);
    console.log(contents.id);

    formData.append('type', contents.type);
    formData.append('id', contents.id);
    formData.append('text', titolo.value);
    console.log(titolo.value);

    fetch("post_arrange.php", { method: "post", body: formData }).then(onResponse).then(RitornoHome);

  }

}

function RitornoHome() {
  location.href = "home.php";

}


function chiudiModale(event) {
  const Esc = document.querySelector('#modale');
  Esc.classList.add('hidden');
  //riabilito lo scroll
  document.body.classList.remove('no-scroll');
  //rimuovo le foto selezionate
  modale.innerHTML = ' ';
}

// Aggiungo event listener al form1 per la RICERCA
const form = document.querySelector('#search');
form.addEventListener('submit', search);

//Apre la sidebar laterale nella versione mobile
function open_sidebar() {
  console.log('open sidebar');
  sidebar = document.querySelector('#sidebar');
  sidebar.classList.remove('hidden');
}

//chiude la sidebar laterale nella versione mobile
function close_sidebar() {

  sidebar = document.querySelector('#sidebar');
  side = sidebar.querySelector('#sidebar_links');
  sidebar.classList.add('hidden');

}

sidebar_button = document.querySelector('div#sidebar_button');

sidebar_button.addEventListener('click', open_sidebar);
sidebar = document.querySelector('#sidebar');
sidebar.addEventListener('click', close_sidebar);




