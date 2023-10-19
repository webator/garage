document.addEventListener('DOMContentLoaded', function() {
    var priceMinSelect = document.getElementById('priceMin');
    var priceMaxSelect = document.getElementById('priceMax');
    var yearMinSelect = document.getElementById('yearMin');
    var yearMaxSelect = document.getElementById('yearMax');
    var kmMinSelect = document.getElementById('kmMin');
    var kmMaxSelect = document.getElementById('kmMax');
    document.getElementById("priceRange").textContent = 'De €' + priceMinSelect.value + ' à €' + priceMaxSelect.value;
    document.getElementById("yearRange").textContent = 'De ' + yearMinSelect.value + ' à ' + yearMaxSelect.value;
    document.getElementById("kmRange").textContent = 'De ' + kmMinSelect.value + ' à ' + kmMaxSelect.value;
    

    function updateCarsVisibility() {
        var minPrice = parseFloat(priceMinSelect.value);
        var maxPrice = parseFloat(priceMaxSelect.value);
        var minYear = parseInt(yearMinSelect.value);
        var maxYear = parseInt(yearMaxSelect.value);
        var minKm = parseInt(kmMinSelect.value);
        var maxKm = parseInt(kmMaxSelect.value);
        document.getElementById("priceRange").textContent = 'De €' + priceMinSelect.value + ' à €' + priceMaxSelect.value;
        document.getElementById("yearRange").textContent = 'De ' + yearMinSelect.value + ' à ' + yearMaxSelect.value;
        document.getElementById("kmRange").textContent = 'De ' + kmMinSelect.value + ' à ' + kmMaxSelect.value;
        if (minPrice > maxPrice || minYear > maxYear || minKm > maxKm) {
            alert("Veuillez vérifier les valeurs saisies.");
            return;
        }

        var cars = document.querySelectorAll('.cars');
        cars.forEach(function(car) {
            var carPrice = parseFloat(car.getAttribute('data-price'));
            var carYear = parseInt(car.getAttribute('data-year'));
            var carKm = parseInt(car.getAttribute('data-km'));
            if (
                carPrice >= minPrice && carPrice <= maxPrice &&
                carYear >= minYear && carYear <= maxYear &&
                carKm >= minKm && carKm <= maxKm
            ) {
                car.style.display = 'block';
            } else {
                car.style.display = 'none';
            }
        });

    }

    function updateMaxOptions(maxSelect, minValue) {
        var options = maxSelect.options;
        for (var i = 0; i < options.length; i++) {
            var optionValue = parseFloat(options[i].value);
            if (optionValue <= minValue) {
                options[i].disabled = true;
            } else {
                options[i].disabled = false;
            }
        }
    }
    function updateMinOptions(minSelect, maxValue) {
        var options = minSelect.options;
        for (var i = 0; i < options.length; i++) {
            var optionValue = parseFloat(options[i].value);
            if (optionValue >= maxValue) {
                options[i].disabled = true;
            } else {
                options[i].disabled = false;
            }
        }
    }
    priceMinSelect.addEventListener('change', function() {
        updateCarsVisibility();
    });
    priceMaxSelect.addEventListener('change', function() {
        updateCarsVisibility();
    });
    yearMinSelect.addEventListener('change', function() {
        updateCarsVisibility();
    });

    yearMaxSelect.addEventListener('change', function() {
        updateCarsVisibility();
    });

    kmMinSelect.addEventListener('change', function() {
        updateCarsVisibility();
    });

    kmMaxSelect.addEventListener('change', function() {
        updateCarsVisibility();
    });
});
function resetSelectsKM() {
    document.getElementById("kmMin").value = "0";
    document.getElementById("kmMax").value = "200000";

    var event = new Event('change');
    document.getElementById("kmMin").dispatchEvent(event);
    document.getElementById("kmMax").dispatchEvent(event);
}
function resetSelectsYear() {
    document.getElementById("yearMin").value = "0";
    document.getElementById("yearMax").value = "100000";

    var event = new Event('change');
    document.getElementById("yearMin").dispatchEvent(event);
    document.getElementById("yearMax").dispatchEvent(event);
}

function resetPrice() {
    document.getElementById("priceMin").value = "0";
    document.getElementById("priceMax").value = "100000";

    var event = new Event('change');
    document.getElementById("priceMin").dispatchEvent(event);
    document.getElementById("priceMax").dispatchEvent(event);
}
$(document).ready(function() {
    $('#temoignages_note input[type="radio"]').each(function() {
      var value = $(this).val();
      var stars = '';
  
      for (var i = 1; i <= value; i++) {
        stars += '<i class="fa-solid fa-star"></i>';
      }
  
      $(this).next('label').html(stars);
    });
  });
function scrollToContact(){
    document.addEventListener('DOMContentLoaded', function() {
        var contactSection = document.getElementById('contact');
        if (contactSection) {
            window.scrollTo({
                top: contactSection.offsetTop,
                behavior: 'smooth'
            });
        }
    });
}
function scrollToTemoignage(){
    document.addEventListener('DOMContentLoaded', function() {
        var temoignagesSection = document.getElementById('temoignages');
        if (temoignagesSection) {
            window.scrollTo({
                top: temoignagesSection.offsetTop,
                behavior: 'smooth'
            });
        }

    });
}

function ContactFormFill(voitureId) {
    // Récupérer le titre de la voiture
    var titreVoiture = document.querySelector('.cars[data-id="' + voitureId + '"] h3').textContent;

    // Remplir le champ de sujet dans le formulaire de contact
    var champSujet = document.getElementById('contact_sujet');
    if (champSujet) {
        champSujet.value = titreVoiture;
    }

    // Faire défiler jusqu'à la section de contact
    var sectionContact = document.getElementById('contact');
    if (sectionContact) {
        sectionContact.scrollIntoView({ behavior: 'smooth' });
    }
}

function controlFromInput(fromSlider, fromInput, toInput, controlSlider) {
    const [from, to] = getParsed(fromInput, toInput);
    fillSlider(fromInput, toInput, '#C6C6C6', '#25daa5', controlSlider);
    if (from > to) {
        fromSlider.value = to;
        fromInput.value = to;
    } else {
        fromSlider.value = from;
    }
}
    
function controlToInput(toSlider, fromInput, toInput, controlSlider) {
    const [from, to] = getParsed(fromInput, toInput);
    fillSlider(fromInput, toInput, '#C6C6C6', '#25daa5', controlSlider);
    setToggleAccessible(toInput);
    if (from <= to) {
        toSlider.value = to;
        toInput.value = to;
    } else {
        toInput.value = from;
    }
}

function controlFromSlider(fromSlider, toSlider, fromInput) {
  const [from, to] = getParsed(fromSlider, toSlider);
  fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
  if (from > to) {
    fromSlider.value = to;
    fromInput.value = to;
  } else {
    fromInput.value = from;
  }
}

function controlToSlider(fromSlider, toSlider, toInput) {
  const [from, to] = getParsed(fromSlider, toSlider);
  fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
  setToggleAccessible(toSlider);
  if (from <= to) {
    toSlider.value = to;
    toInput.value = to;
  } else {
    toInput.value = from;
    toSlider.value = from;
  }
}

function getParsed(currentFrom, currentTo) {
  const from = parseInt(currentFrom.value, 10);
  const to = parseInt(currentTo.value, 10);
  return [from, to];
}

function fillSlider(from, to, sliderColor, rangeColor, controlSlider) {
    if (to && to.max && to.min) {
        const rangeDistance = to.max - to.min;
        const fromPosition = from.value - to.min;
        const toPosition = to.value - to.min;
        controlSlider.style.background = `linear-gradient(
          to right,
          ${sliderColor} 0%,
          ${sliderColor} ${(fromPosition) / (rangeDistance) * 100}%,
          ${rangeColor} ${((fromPosition) / (rangeDistance)) * 100}%,
          ${rangeColor} ${(toPosition) / (rangeDistance) * 100}%, 
          ${sliderColor} ${(toPosition) / (rangeDistance) * 100}%, 
          ${sliderColor} 100%)`;
    }
}


function setToggleAccessible(currentTarget) {
    if (currentTarget && currentTarget.value) {
      const toSlider = document.querySelector('#toSlider');
      if (Number(currentTarget.value) <= 0 ) {
        toSlider.style.zIndex = 2;
      } else {
        toSlider.style.zIndex = 0;
      }
    }
  }
  
  document.addEventListener('DOMContentLoaded', function() {
    const fromSlider = document.querySelector('#priceMin').value;
    const toSlider = document.querySelector('#priceMax').value;

    fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
    setToggleAccessible(toSlider);
    
    fromSlider.oninput = () => controlFromSlider(fromSlider, toSlider, fromInput);
    toSlider.oninput = () => controlToSlider(fromSlider, toSlider, toInput);
    
  });
  