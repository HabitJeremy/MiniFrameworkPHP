$(document).ready(function () {

    $body = $('body');

    $body.on('click', '.changePublicationArticle', function (e) {
        e.preventDefault();
        var $btn = $(this);
        url = "index.php?o=article&a=changePublicationAjax&id=" + $(this).attr("data-id");
        $parent = $(this).parent();
        $.ajax({
            type: "GET",
            url: url
        })
            .done(function (response) {
                if (typeof response.message !== 'undefined') {
                    if (response.message === "success") {
                        $btn.text(response.newText);
                        /* message de notification */
                        if ($("#ajaxSuccessNotification").length) {
                            $("#ajaxSuccessNotification").html("<span class='txt-b'>Ok</span> :  Statut de publication modifiée !");
                        } else {
                            $("#contentNotification").prepend(
                                "<span id='ajaxSuccessNotification' class='msg-success'>" +
                                "<span class='txt-b'>Ok</span> : Statut de publication modifiée </span>"
                            );
                        }
                    }
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if ($("#ajaxErrorNotification").length) {
                    $("#ajaxErrorNotification").html("<span class='txt-b'>Erreur</span> : une erreur s'est produite !");
                } else {
                    $("#contentNotification").prepend(
                        "<span id='ajaxErrorNotification' class='msg-error'>" +
                        "<span class='txt-b'>Erreur</span> : une erreur s'est produite !</span>"
                    );
                }
            });
    });
});