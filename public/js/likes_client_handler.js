// Post new comment to server
function handleLike(form, e) {
    e.preventDefault();
    form = $(form);
    formUrl = form.attr("action");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "post",
        url: formUrl,
        data: form.serialize(),
        success: function (response) {
            if (response == "create") {
                // Increase like
                $(".total-likes").text(parseInt($(".total-likes").first().text()) + 1);
                $(".heart-icon").addClass("fa-solid").removeClass("fa-regular");
            } else {
                // Decrease like
                $(".total-likes").text(parseInt($(".total-likes").first().text()) - 1);
                $(".heart-icon").addClass("fa-regular").removeClass("fa-solid");
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}
