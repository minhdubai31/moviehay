// Clear form
function clearForm(form) {
    try {
        form.trigger("reset");
        commentAccept(form[0]);
    } catch (error) {
        form.reset();
        commentAccept(form); 
    }
}


// Add cancel button into form
function addCancelBtn(form) {
    $(form).children().last().fadeIn(100);
}

// Remove cancel button from form
function removeCancelBtn(form) {
    $(form).children().last().fadeOut(100);
    clearForm(form);
}

function commentAccept(form, cancelBtnToggle = false) {
    if (form.cmt_content.value.trim() != "") {
        form.submitBtn.disabled = false;
        form.submitBtn.classList.remove("bg-slate-200", "text-gray-400");
        form.submitBtn.classList.add(
            "bg-orange-600",
            "hover:bg-orange-700",
            "text-white"
        );
        if(cancelBtnToggle) 
            addCancelBtn(form);
    } else {
        form.submitBtn.disabled = true;
        form.submitBtn.classList.remove(
            "bg-orange-600",
            "hover:bg-orange-700",
            "text-white"
        );
        form.submitBtn.classList.add("bg-slate-200", "text-gray-400");
        if(cancelBtnToggle)
            removeCancelBtn(form);
    }
}

// Convert time to min, hour, day, month or year
function timeDuration(timestamp) {
    // Split timestamp into [ Y, M, D, h, m, s ]
    var t = timestamp.split(/[- :]/);

    // Apply each element to the Date function
    var d = new Date(Date.UTC(t[0], t[1] - 1, t[2], t[3], t[4], t[5]));

    var duration = Date.now() - d;

    duration = duration + 3600*1000*7;

    var milliseconds = Math.floor((duration % 1000) / 100),
        seconds = Math.floor((duration / 1000) % 60),
        minutes = Math.floor((duration / (1000 * 60)) % 60),
        hours = Math.floor((duration / (1000 * 60 * 60)) % 24),
        days = Math.floor((duration / (1000 * 60 * 60 * 24)) % 30),
        months = Math.floor((duration / (1000 * 60 * 60 * 24 * 30)) % 12),
        years = Math.floor(duration / (1000 * 60 * 60 * 24 * 30 * 12));

    return years > 0
        ? `${years} năm trước`
        : months > 0
        ? `${months} tháng trước`
        : days > 0
        ? `${days} ngày trước`
        : hours > 0
        ? `${hours} giờ trước`
        : minutes > 0
        ? `${minutes} phút trước`
        : "Vài giây trước";
}

// Show comment time duration
function displayDuration() {
    $(".cmt_duration").each((index, el) => {
        $(el).text(timeDuration(el.innerText));
    });
}

// Show reply box
function showReplyBox(replyText) {
    $('.replycomment-form').each((index, el) => {
        $(el).slideUp(200);
    });
    $(replyText).parent().parent().nextAll('.replycomment-form').first().slideDown(200);
}

// Update comments
function updateComments(ep_id) {
    fetch('/comments/' + ep_id)
        .then((res) => res.text())
        .then((data) => {
            $('#comments-container').html(data);
            displayDuration();
        });
}



// Post new comment to server
function storeComment(form, e) {
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
            clearForm(form);

            // Update comments
            updateComments(response.ep_id);

            // Remove cancel button
            removeCancelBtn(form[0]);
        },
        error: function (error) {
            console.log(error);
        },
    });
}
