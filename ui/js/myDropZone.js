window.addEventListener("load", function () {
    document.getElementById("image").onchange = function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            // obtention des données chargées et rendu de l'aperçu
            $imgPreview = document.getElementById("imgPreview");
            $imgPreview.style.display = "inline-block";
            console.log(e.target.result);
            $imgPreview.src = e.target.result;
        };
        // Suppresson du texte par défaut
        document.getElementById('defaultTxt').style.display = "none";
        // lecture de l'image en tant qu'une donnée URL
        reader.readAsDataURL(this.files[0]);
    };
});