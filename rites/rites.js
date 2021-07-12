// TODO : Ajouter fonction autocomplete chant du chemin pour les inputs "chant_"
const ordinauxFr = [
    '----',
    'deuxième',
    'troisième',
    'quatrième',
    'cinquième',
    'sixième',
    'septième',
    'huitième',
    'neuvième',
    'dixième',
    'onzième',
    'douzième',
    'treizième',
    'quatorzième',
    'quinzième',
    'seizième',
    'dix-septième',
    'dix-huitième',
    'dix-neuvième',
    'vingtième',
    'vingt et unième',
    'vingt-deuxième',
    'vingt-troisième',
    'vingt-quatrième',
    'vingt-cinquième',
    'vingt-sixième',
    'vingt-septième',
    'vingt-huitième',
    'vingt-neuvième',
    'trentième',
    'trente et unième',
    'trente-deuxième',
    'trente-troisième',
    'trente-quatrième',
    'trente-cinquième',
    'trente-sixième',
    'trente-septième',
    'trente-huitième',
    'trente-neuvième',
    'quarantième',
    'quarante et unième',
    'quarante-deuxième',
    'quarante-troisième',
    'quarante-quatrième',
    'quarante-cinquième',
    'quarante-sixième',
    'quarante-septième',
    'quarante-huitième',
    'quarante-neuvième',
    'cinquantième',
    'cinquante et unième',
    'cinquante-deuxième',
    'cinquante-troisième',
    'cinquante-quatrième',
    'cinquante-cinquième',
    'cinquante-sixième',
    'cinquante-septième',
    'cinquante-huitième',
    'cinquante-neuvième',
    'soixantième',
    'soixante et unième',
    'soixante-deuxième',
    'soixante-troisième',
    'soixante-quatrième',
    'soixante-cinquième',
    'soixante-sixième',
    'soixante-septième',
    'soixante-huitième',
    'soixante-neuvième',
    'soixante-dixième',
    'soixante et onzième',
    'soixante-douzième',
    'soixante-treizième',
    'soixante-quatorzième',
    'soixante-quinzième',
    'soixante-seizième',
    'soixante-dix-septième',
    'soixante-dix-huitième',
    'soixante-dix-neuvième',
    'quatre-vingtième',
    'quatre-vingt-unième',
    'quatre-vingt-deuxième',
    'quatre-vingt-troisième',
    'quatre-vingt-quatrième',
    'quatre-vingt-cinquième',
    'quatre-vingt-sixième',
    'quatre-vingt-septième',
    'quatre-vingt-huitième',
    'quatre-vingt-neuvième',
    'quatre-vingt-dixième',
    'quatre-vingt-onzième',
    'quatre-vingt-douzième',
    'quatre-vingt-treizième',
    'quatre-vingt-quatorzième',
    'quatre-vingt-quinzième',
    'quatre-vingt-seizième',
    'quatre-vingt-dix-septième',
    'quatre-vingt-dix-huitième',
    'quatre-vingt-dix-neuvième',
    'centième',
  ];
  
function trouverOrdinaux(val, genre = 'M') {
    const max = ordinauxFr.length;
    if (val == 1) {
      if (genre == 'F') {
        return 'première';
      } else {
        return 'premier';
      }
    } else if (val <= max) {
      return ordinauxFr[val - 1];
    } else {
      const err = new Error();
      err.name = 'RangeError';
      err.message = `French ordinal only works with <= ${max}`;
      throw err;
    }
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

function ajouterSection() {
    var main = document.getElementById("field_ev");
    var cntr = (main.datacntr || 0) + 1;
    main.datacntr = cntr;
    
    const field = document.createElement("fieldset");
        field.id = field.name = "fieldlect" + cntr ;
        const legend = document.createElement("legend");
            legend.innerText = capitalizeFirstLetter(trouverOrdinaux(cntr,"F")) + ' lecture' ;
        field.appendChild(legend);
        const div_mon = document.createElement("div");
            const label_mon = document.createElement("label");
                label_mon.setAttribute("for", "mon_" + cntr) ;
                label_mon.innerText = "Monition "  + trouverOrdinaux(cntr,"F") + " lecture : " ;
            div_mon.appendChild(label_mon);
            const input_mon = document.createElement("input");
                input_mon.id = input_mon.name = "mon_" + cntr ;
                input_mon.type = "text" ;
            div_mon.appendChild(input_mon) ;
        field.appendChild(div_mon) ;
        const div_lect = document.createElement("div");
            const label_lect = document.createElement("label");
                label_lect.setAttribute("for", "lec_" + cntr) ;
                label_lect.innerText = "Proclamation "  + trouverOrdinaux(cntr,"F") + " lecture : " ;
            div_lect.appendChild(label_lect);
            const input_lect = document.createElement("input");
                input_lect.id = input_lect.name = "lect_" + cntr ;
                input_lect.type = "text" ;
            div_lect.appendChild(input_lect) ;
        field.appendChild(div_lect) ;
        const div_ref = document.createElement("div");
            const label_ref = document.createElement("label");
                label_ref.setAttribute("for", "ref_" + cntr) ;
                label_ref.innerText = "Référence biblique "  + trouverOrdinaux(cntr,"F") + " lecture : " ;
            div_ref.appendChild(label_ref);
            const input_ref = document.createElement("input");
                input_ref.id = input_ref.name = "ref_" + cntr ;
                input_ref.type = "text" ;
            div_ref.appendChild(input_ref) ;
        field.appendChild(div_ref) ;
        const div_chant = document.createElement("div");
            const label_chant = document.createElement("label");
                label_chant.setAttribute("for", "chant_" + cntr) ;
                label_chant.innerText = "Chant après la "  + trouverOrdinaux(cntr,"F") + " lecture : " ;
            div_chant.appendChild(label_chant);
            const input_chant = document.createElement("input");
                input_chant.id = input_chant.name = "chant_" + cntr ;
                input_chant.type = "text" ;
            div_chant.appendChild(input_chant) ;
        field.appendChild(div_chant) ;
        if( lelien = document.getElementById("lien_ajouter")) {
            lelien.remove();
        }
        const lien = document.createElement("a");
        lien.id = "lien_ajouter" ;
        lien.href = "#" ;
        lien.addEventListener("click",ajouterSection);
        lien.innerText = " + " ;

        if( lelien2 = document.getElementById("lien_retirer")) {
            lelien2.remove();
        }
        const lien2 = document.createElement("a");
        lien2.id = "lien_retirer" ;
        lien2.href = "#" ;
        lien2.addEventListener("click",retirerSection);
        lien2.innerText = " - " ;

    main.parentNode.insertBefore(field,main);
    main.parentNode.insertBefore(lien,main);
    main.parentNode.insertBefore(lien2,main);
    if (cntr > 1) {
        input_mon.focus();
    } 
    
}

function retirerSection() {
    var main = document.getElementById("field_ev");
    if ( el = document.getElementById("fieldlect" + main.datacntr)) {
        el.remove();
    }
    var cntr = main.datacntr - 1;
    main.datacntr = cntr;
}