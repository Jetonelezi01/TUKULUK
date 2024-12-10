
    document.getElementById('searchButton').addEventListener('click', function() {
        var searchTerm = document.getElementById('searchInput').value.trim().toLowerCase();
        var messageElement = document.getElementById('message');
        
        if (searchTerm) {
            // Lista e restoranteve dhe URL-të përkatëse
            var restaurants = {
                "restorant": "restorantet.html",
                "restaurant": "restorantet.html",
                "bocata": "Bocata_rest.html",
                "bocaten": "Bocata_rest.html",
                "grand": "Grand_rest.html",
                "bakal": "Bakal_rest.html",    
                "blackmoon" : "blackmoon_shishabar.html" ,
                "black moon" : "blackmoon_shishabar.html " ,
                "boss" : "Boss_rest.html" ,
                "coco lounge" : "Cocolounge_shishabar.html" ,
                "coco" : "Cocolounge_shishabar.html" ,
                "dante" : "Dante_rest.html" ,
                "delfin" : "Delfin_rest.html" ,
                "driada" : "Driada_rest.html" ,
                "ema" : "Ema_rest.html",
                "fratelli" : "Fratelli_rest.html",
                "garison" : "Garison_shishabar.html",
                "grand" : "Grand_rest.html",
                "kurtishi" : "Kurtishi_rest.html",
                "sanitari" : "uje_instalues.html",
     
            };
    
            // Kërkoni për një përputhje të emrit të restorantit
            var found = false;
            for (var restaurant in restaurants) {
                // Kontrollojmë nëse fraza e kërkuar përmban emrin e restorantit
                if (searchTerm.includes(restaurant.toLowerCase())) {
                    window.location.href = restaurants[restaurant]; // Dërgon përdoruesin në faqen e restorantit
                    found = true;
                    break;
                }
            }
    
            if (!found) {
                messageElement.style.color = "red";
                messageElement.textContent = "Kërkimi për '" + searchTerm + "' nuk dha rezultate.";
            }
        } else {
            messageElement.style.color = "red";
            messageElement.textContent = "Ju lutem shkruani dicka per te kerkuar!";
        }
    });
    
    
    
