function loadInbox() {
    $.ajax({
        url: 'asset/process/inbox.php',
        success: function (data) {
            $('#inbox .container').html(data);
        },
        error: function (error) {
            console.log(error);
            Swal.fire({
                title: 'Erro',
                text: error.statusText,
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        }
    });
}

function loadProfile(id = 0) {
    $.ajax({
        url: 'asset/process/profile.php?id=' + id,
        success: function (data) {
            $('#profile .container').html(data);
        },
        error: function (error) {
            console.log(error);
            Swal.fire({
                title: 'Erro',
                text: error.statusText,
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        }
    });
}
function atualizar(){
    location.href = '/chat';
    chat();
}

function chat(id = 0) {
    $.ajax({
        url: 'asset/process/chat.php?id=' + id,
        success: function (data) {
            $('#chat').html(data);
            loadProfile(id);
        },
        error: function (error) {
            console.log(error);
            Swal.fire({
                title: 'Erro',
                text: error.statusText,
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        }
    });
}
function reiniciar(id_us){
    $('#inbox').html('<img class = "mostra" src="asset/img/mostra.png" alt="">')
    $('#inbox').addClass('d-none d-md-block')
    chat(id_us)
}

function search() {
    var term = $( "input.searchField" ).val();
    if (term.length >= 1) {
        $.ajax({
            url: 'asset/process/search.php?term=' + term,
            success: function (data) {
                $('#searchContainer').show();
                $('#searchContainer').html(data);
            }
        });
    } else {
        $('#searchContainer').hide();
    }
}

function logout() {
    $.ajax({
        url: '/timeline',
        beforeSend: function () {
            $('#loading').show();
        },
        success: function () {
            location.href = '/timeline';
        }
    });
}

$( document ).ready(function() {
  setInterval(() => {
        loadInbox();
    }, 300);
    loadProfile();
    chat();
});

function previewUpload(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#userImg').attr('src', e.target.result);
            var formData = new FormData($("#uploadPic")[0]);
            $.ajax({
                type: 'post',
                url: 'asset/process/updateProfile.php',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                error: function (error) {
                    Swal.fire({
                        title: 'Imagem não alterada!',
                        text: error.statusText,
                        icon: 'error',
                        confirmButtonText: 'Tentar novamente'
                    })
                }
            });
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function() {
    previewUpload(this);
});

