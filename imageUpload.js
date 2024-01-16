


function previewImages(){
    var input = document.getElementById('imageInput');
    var container = document.getElementById('imageContainer');

    

    for (var i = 0; i < input.files.length; i++) {
        var file = input.files[i];
        var reader = new FileReader();

        reader.onloadend = function () {
            var img = document.createElement('img');
            img.src = reader.result;
            img.classList.add('image-preview');
            img.addEventListener('click', function() {
                this.remove();
                updateFileInfo();
            });
            container.appendChild(img);
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    
}